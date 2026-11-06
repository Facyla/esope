<?php
declare(strict_types=1);

namespace Facyla\AccessCollections;

use Elgg\Plugins\IntegrationTestCase;

/**
 * @coversDefaultClass \Facyla\AccessCollections\Plugin
 */
class AccessCollectionsIntegrationTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function up(): void {
		// Setup runs before each test
	}

	/**
	 * @return void
	 */
	public function down(): void {
		// Cleanup runs after each test
	}

	/**
	 * @covers ::access_collections_create_custom_acl
	 * @covers ::access_collections_get_collection_by_name
	 */
	public function testIdempotentAclCreation(): void {
		// Arrange : obtenir le GUID du site
		$site_guid = elgg_get_site_entity()->guid;
		$test_name = '__test__profiletype:unique_test';

		// Nettoyage préalable si une collection existe déjà
		$existing = access_collections_get_collection_by_name($test_name);
		if ($existing instanceof \ElggAccessCollection) {
			$existing->delete();
		}

		// Act : créer la collection une première fois
		$collection1 = elgg_create_access_collection($test_name, $site_guid, 'profiletype');

		// Assert : vérifier que la première création réussit
		$this->assertInstanceOf(\ElggAccessCollection::class, $collection1);
		$this->assertNotNull($collection1);
		$collection1_id = $collection1->id;
		$this->assertNotNull($collection1_id);

		// Act : créer la collection une deuxième fois avec access_collections_create_custom_acl()
		// IMPORTANT : pour que access_collections_create_custom_acl() réutilise la collection existante,
		// elle DOIT être appelée avec le même $collection_name et $update_members=false.
		// Le paramètre $criteria est ignoré si $collection_name est fourni (cf. ligne 137-146 du source).
		$collection2 = access_collections_create_custom_acl(
			[], // critères vides, ignorés car $collection_name fourni
			$test_name,
			false // don't update members
		);

		// Assert : vérifier que la deuxième appel réutilise la même collection
		$this->assertInstanceOf(\ElggAccessCollection::class, $collection2);
		$this->assertNotNull($collection2);
		$this->assertSame($collection1_id, $collection2->id, 'Second call should reuse existing collection, not create a duplicate');

		// Assert : vérifier qu'aucun doublon n'est créé dans la DB
		$found = access_collections_get_collection_by_name($test_name);
		$this->assertInstanceOf(\ElggAccessCollection::class, $found, 'Exactly one collection should exist with this name');
		$this->assertSame($collection1_id, $found->id, 'Found collection should be the same as the one created');

		// Act : nettoyage
		$collection1->delete();

		// Assert : vérifier que la collection est bien supprimée
		$after = access_collections_get_collection_by_name($test_name);
		$this->assertNull($after, 'Collection should be deleted and not found by name');
	}

	/**
	 * @covers ::addMember
	 * @covers ::removeMember
	 * @covers ::hasMember
	 */
	public function testMembershipPrimitives(): void {
		// Arrange : créer deux ACLs de test
		$site_guid = elgg_get_site_entity()->guid;
		$acl_a = elgg_create_access_collection('__test__profiletype:a', $site_guid, 'profiletype');
		$acl_b = elgg_create_access_collection('__test__profiletype:b', $site_guid, 'profiletype');

		$this->assertInstanceOf(\ElggAccessCollection::class, $acl_a);
		$this->assertInstanceOf(\ElggAccessCollection::class, $acl_b);
		$this->assertNotNull($acl_a->id);
		$this->assertNotNull($acl_b->id);

		// Arrange : créer un utilisateur de test via le helper d'Elgg
		$user = $this->createUser();

		// Act : ajouter l'utilisateur à ACL A, retirer de ACL B (au cas où)
		$acl_a->addMember($user->guid);
		$acl_b->removeMember($user->guid);

		// Assert : vérifier la présence dans ACL A
		$this->assertTrue($acl_a->hasMember($user->guid), 'User should be member of ACL A after addMember()');

		// Assert : vérifier l'absence dans ACL B
		$this->assertFalse($acl_b->hasMember($user->guid), 'User should not be member of ACL B after removeMember()');

		// Act : switch — retirer de A, ajouter à B
		$acl_a->removeMember($user->guid);
		$acl_b->addMember($user->guid);

		// Assert : vérifier l'absence dans ACL A après switch
		$this->assertFalse($acl_a->hasMember($user->guid), 'User should not be member of ACL A after removeMember()');

		// Assert : vérifier la présence dans ACL B après switch
		$this->assertTrue($acl_b->hasMember($user->guid), 'User should be member of ACL B after addMember()');

		// Nettoyage automatique : $user est supprimé par BaseIntegrationTestCase
		// Nettoyage manuel des ACLs créées avec elgg_create_access_collection()
		$acl_a->delete();
		$acl_b->delete();
	}

	/**
	 * @covers ::access_collections_add_write_acl
	 * @covers ::access_collections_add_read_acl
	 * @covers ::access_collections_get_profile_types_acls
	 * @covers ::access_collections_get_custom_collections
	 */
	public function testWriteAccessHookIncludesCollectionForMember(): void {
		$site = elgg_get_site_entity();
		
		// Enregistrer une classe concrète pour le subtype custom_profile_type
		// (ElggObject est abstrait en Elgg 7, ElggUndefinedObject est la classe concrète)
		elgg_set_entity_class('object', 'custom_profile_type', \ElggUndefinedObject::class);
		
		// Créer un profile type (objet de subtype custom_profile_type, possédé par le site)
		$profile_type = $this->createObject([
			'subtype' => 'custom_profile_type',
			'owner_guid' => $site->guid,
			'container_guid' => $site->guid,
			'title' => 'Test Profile Type',
			'description' => false,
			'tags' => false,
		]);
		
		$this->assertNotNull($profile_type->guid, 'Profile type should be created');
		
		// Définir metadata_name (utilisé par ProfileTypes::getProfileTypes())
		$profile_type_name = 'test_type_' . $profile_type->guid;
		$profile_type->metadata_name = $profile_type_name;
		$profile_type->save();
		
		// Activer ce profile type dans les settings du plugin
		elgg_set_plugin_setting('profiletype_' . $profile_type->guid, 'yes', 'access_collections');
		
		// Créer une ACL avec le nom correspondant au profile type
		$collection_name = 'profiletype:' . $profile_type_name;
		$acl = elgg_create_access_collection($collection_name, $site->guid, 'profiletype');
		$this->assertInstanceOf(\ElggAccessCollection::class, $acl, 'ACL should be created');
		
		// Créer un user de test
		$user = $this->createUser();
		
		// Ajouter le user à l'ACL
		$this->assertTrue($acl->addMember($user->guid), 'addMember should return true');
		$this->assertTrue($acl->hasMember($user->guid), 'User should be member of ACL');
		
		// Vider le cache d'accès pour forcer le recalcul
		_elgg_services()->accessCache->clear();
		
		// Vérifier write access array (les clés sont des entiers : access_id => label)
		$write_array = elgg_get_write_access_array($user->guid, true);
		$this->assertArrayHasKey($acl->id, $write_array, 'ACL ID should be a key in write access array');
		$this->assertNotEmpty($write_array[$acl->id], 'ACL label should be present in write access array');
		
		// Vérifier read access array (array numérique de collection IDs, entiers)
		$read_array = elgg_get_access_array($user->guid, true);
		$this->assertContains($acl->id, $read_array, 'ACL ID should be in read access array');
		$this->assertTrue(in_array($acl->id, $read_array, true), 'ACL ID should be in read access array with strict comparison');
		
		// Nettoyage
		$acl->delete();
		elgg_call(ELGG_IGNORE_ACCESS, function() use ($profile_type) {
			$profile_type->delete();
		});
		elgg_set_plugin_setting('profiletype_' . $profile_type->guid, 'no', 'access_collections');
	}
}
