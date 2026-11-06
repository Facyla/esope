<?php

declare(strict_types=1);

namespace Facyla\AccessCollections;

use Elgg\ActionResponseTestCase;
use Elgg\Http\OkResponse;

/**
 * Integration tests for access_collections plugin settings action
 */
class SettingsActionIntegrationTest extends ActionResponseTestCase {

	/**
	 * Setup before each test
	 */
	public function up(): void {
		parent::up();
		_elgg_services()->session_manager->setLoggedInUser($this->getAdmin());
	}

	/**
	 * Clean up profile types and ACLs
	 */
	private function cleanupProfileType(int $profile_type_guid): void {
		$profile_type = get_entity($profile_type_guid);
		if ($profile_type) {
			elgg_call(ELGG_IGNORE_ACCESS, function() use ($profile_type) {
				$profile_type->delete();
			});
		}

		// Delete ACLs created for this profile type
		$collection_name = 'profiletype:profiletype_test_' . $profile_type_guid;
		$collection = access_collections_get_collection_by_name($collection_name);
		if ($collection) {
			elgg_call(ELGG_IGNORE_ACCESS, function() use ($collection) {
				$collection->delete();
			});
		}

		// Clean up plugin settings
		elgg_set_plugin_setting('profiletype_' . $profile_type_guid, 'no', 'access_collections');
		elgg_set_plugin_setting('profiletype_label_' . $profile_type_guid, '', 'access_collections');
		elgg_set_plugin_setting('allow_delete', 'no', 'access_collections');
	}

	/**
	 * Test that enabling a profile type creates an ACL and syncs members
	 */
	public function testEnableProfileTypeCreatesAclAndSyncsMembers(): void {
		// Set up entity class for custom_profile_type
		elgg_set_entity_class('object', 'custom_profile_type', \ElggUndefinedObject::class);

		// Create profile type
		$profile_type = $this->createObject([
			'subtype' => 'custom_profile_type',
			'owner_guid' => elgg_get_site_entity()->guid,
			'container_guid' => elgg_get_site_entity()->guid,
			'title' => 'Test Profile Type',
			'description' => false,
			'tags' => false,
		]);
		$profile_type->metadata_name = 'profiletype_test_' . $profile_type->guid;
		$profile_type->save();

		// Create users with this profile type
		$user1 = $this->createUser();
		$user1->custom_profile_type = (int) $profile_type->guid;
		$user1->save();

		$user2 = $this->createUser();
		$user2->custom_profile_type = (int) $profile_type->guid;
		$user2->save();

		// Create user without profile type
		$user_no_type = $this->createUser();

		// Clean up any existing ACL with this name
		$collection_name = 'profiletype:profiletype_test_' . $profile_type->guid;
		$existing = access_collections_get_collection_by_name($collection_name);
		if ($existing) {
			$existing->delete();
		}

		// Execute action
		$response = $this->executeAction('access_collections/settings/save', [
			'params' => [
				'profiletype_' . $profile_type->guid => 'yes',
				'profiletype_label_' . $profile_type->guid => 'Test Custom Label',
				'allow_delete' => 'no',
			],
		]);

		// Assert response
		$this->assertInstanceOf(OkResponse::class, $response);

		// Assert ACL exists
		$collection = access_collections_get_collection_by_name('profiletype:profiletype_test_' . $profile_type->guid);
		$this->assertNotNull($collection);
		$this->assertInstanceOf(\ElggAccessCollection::class, $collection);

		// Assert ACL name
		$this->assertSame('profiletype:profiletype_test_' . $profile_type->guid, $collection->name);

		// Assert settings saved
		$this->assertSame('yes', elgg_get_plugin_setting('profiletype_' . $profile_type->guid, 'access_collections'));
		$this->assertSame('Test Custom Label', elgg_get_plugin_setting('profiletype_label_' . $profile_type->guid, 'access_collections'));

		// Assert ACL contains users with profile type
		$this->assertTrue($collection->hasMember($user1->guid));
		$this->assertTrue($collection->hasMember($user2->guid));

		// Assert ACL does not contain user without profile type
		$this->assertFalse($collection->hasMember($user_no_type->guid));

		// Assert allow_delete was reset
		$this->assertSame('no', elgg_get_plugin_setting('allow_delete', 'access_collections'));

		// Cleanup
		$this->cleanupProfileType($profile_type->guid);
	}

	/**
	 * Test that disabling a profile type without allow_delete keeps the ACL
	 */
	public function testDisableProfileTypeWithoutAllowDeleteKeepsAcl(): void {
		// Set up entity class
		elgg_set_entity_class('object', 'custom_profile_type', \ElggUndefinedObject::class);

		// Create profile type
		$profile_type = $this->createObject([
			'subtype' => 'custom_profile_type',
			'owner_guid' => elgg_get_site_entity()->guid,
			'container_guid' => elgg_get_site_entity()->guid,
			'title' => 'Test Profile Type',
			'description' => false,
			'tags' => false,
		]);
		$profile_type->metadata_name = 'profiletype_test_' . $profile_type->guid;
		$profile_type->save();

		// Create ACL manually
		$collection_name = 'profiletype:profiletype_test_' . $profile_type->guid;
		$acl = elgg_create_access_collection($collection_name, elgg_get_site_entity()->guid, 'profiletype');

		// Enable the setting
		elgg_set_plugin_setting('profiletype_' . $profile_type->guid, 'yes', 'access_collections');

		// Execute action (disable with allow_delete = no)
		$response = $this->executeAction('access_collections/settings/save', [
			'params' => [
				'profiletype_' . $profile_type->guid => 'no',
				'allow_delete' => 'no',
			],
		]);

		// Assert response
		$this->assertInstanceOf(OkResponse::class, $response);

		// Assert ACL still exists
		$collection_name = 'profiletype:profiletype_test_' . $profile_type->guid;
		$collection = access_collections_get_collection_by_name($collection_name);
		$this->assertNotNull($collection);
		$this->assertSame($collection_name, $collection->name);

		// Assert setting is now 'no'
		$this->assertSame('no', elgg_get_plugin_setting('profiletype_' . $profile_type->guid, 'access_collections'));

		// Cleanup
		$acl->delete();
		$this->cleanupProfileType($profile_type->guid);
	}

	/**
	 * Test that disabling a profile type with allow_delete deletes the ACL
	 */
	public function testDisableProfileTypeWithAllowDeleteDeletesAcl(): void {
		// Set up entity class
		elgg_set_entity_class('object', 'custom_profile_type', \ElggUndefinedObject::class);

		// Create profile type
		$profile_type = $this->createObject([
			'subtype' => 'custom_profile_type',
			'owner_guid' => elgg_get_site_entity()->guid,
			'container_guid' => elgg_get_site_entity()->guid,
			'title' => 'Test Profile Type',
			'description' => false,
			'tags' => false,
		]);
		$profile_type->metadata_name = 'profiletype_test_' . $profile_type->guid;
		$profile_type->save();

		// Create ACL manually
		$collection_name = 'profiletype:profiletype_test_' . $profile_type->guid;
		$acl = elgg_create_access_collection($collection_name, elgg_get_site_entity()->guid, 'profiletype');
		$acl_id = $acl->id;

		// Enable the setting
		elgg_set_plugin_setting('profiletype_' . $profile_type->guid, 'yes', 'access_collections');

		// Execute action (disable with allow_delete = yes)
		$response = $this->executeAction('access_collections/settings/save', [
			'params' => [
				'profiletype_' . $profile_type->guid => 'no',
				'allow_delete' => 'yes',
			],
		]);

		// Assert response
		$this->assertInstanceOf(OkResponse::class, $response);

		// Assert ACL was deleted
		$collection_name = 'profiletype:profiletype_test_' . $profile_type->guid;
		$collection = access_collections_get_collection_by_name($collection_name);
		$this->assertNull($collection);

		$this->assertNull(elgg_get_access_collection($acl_id));

		// Assert allow_delete was reset
		$this->assertSame('no', elgg_get_plugin_setting('allow_delete', 'access_collections'));

		// Assert setting is 'no'
		$this->assertSame('no', elgg_get_plugin_setting('profiletype_' . $profile_type->guid, 'access_collections'));

		// Cleanup
		$this->cleanupProfileType($profile_type->guid);
	}

	/**
	 * Test that allow_delete always resets to 'no' after the action
	 */
	public function testAllowDeleteAlwaysResetsToNo(): void {
		// Set up entity class
		elgg_set_entity_class('object', 'custom_profile_type', \ElggUndefinedObject::class);

		// Create profile type
		$profile_type = $this->createObject([
			'subtype' => 'custom_profile_type',
			'owner_guid' => elgg_get_site_entity()->guid,
			'container_guid' => elgg_get_site_entity()->guid,
			'title' => 'Test Profile Type',
			'description' => false,
			'tags' => false,
		]);
		$profile_type->metadata_name = 'profiletype_test_' . $profile_type->guid;
		$profile_type->save();

		// Enable the setting
		elgg_set_plugin_setting('profiletype_' . $profile_type->guid, 'yes', 'access_collections');

		// Set allow_delete to 'yes' manually
		elgg_set_plugin_setting('allow_delete', 'yes', 'access_collections');

		// Execute action (enable with allow_delete = yes)
		$response = $this->executeAction('access_collections/settings/save', [
			'params' => [
				'profiletype_' . $profile_type->guid => 'yes',
				'allow_delete' => 'yes',
			],
		]);

		// Assert response
		$this->assertInstanceOf(OkResponse::class, $response);

		// Assert allow_delete was reset
		$this->assertSame('no', elgg_get_plugin_setting('allow_delete', 'access_collections'));

		// Cleanup
		$this->cleanupProfileType($profile_type->guid);
	}
}
