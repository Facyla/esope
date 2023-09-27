<?php

namespace Elgg\Database\Seeds;

use Elgg\Database\Update;
use Elgg\Exceptions\Seeding\MaxAttemptsException;

/**
 * Seed users
 *
 * @internal
 */
class Users extends Seed {

	/**
	 * {@inheritdoc}
	 */
	public function seed() {
		$count_friends = function ($user) {
			return elgg_count_entities([
				'types' => 'user',
				'relationship' => 'friend',
				'relationship_guid' => $user->guid,
				'inverse_relationship' => false,
				'metadata_names' => '__faker',
			]);
		};

		$exclude = [];

		$this->advance($this->getCount());

		$profile_fields_config = _elgg_services()->fields->get('user', 'user');
		$profile_fields = [];
		foreach ($profile_fields_config as $field) {
			$profile_fields[$field['name']] = $field['#type'];
		}
		
		while ($this->getCount() < $this->limit) {
			try {
				$user = $this->createUser([], [
					'profile_fields' => $profile_fields,
				]);
			} catch (MaxAttemptsException $e) {
				// unable to create a user with the given options
				continue;
			}

			$this->createIcon($user);

			$exclude[] = $user->guid;

			// Friend the user other members
			// Create a friend access collection and add some random friends to it
			if ($count_friends($user)) {
				continue;
			}

			$collection = elgg_create_access_collection('Best Fake Friends Collection', $user->guid, 'friends_collection');
			if ($collection instanceof \ElggAccessCollection) {
				$this->log("Created new friend collection for user {$user->getDisplayName()} [collection_id: {$collection->id}]");
			}

			$friends_limit = $this->faker()->numberBetween(5, 10);

			$friends_exclude = [$user->guid];
			while ($count_friends($user) < $friends_limit) {
				$friend = $this->getRandomUser($friends_exclude);
				if (!$friend) {
					continue;
				}

				$friends_exclude[] = $friend->guid;

				if ($user->addFriend($friend->guid, true)) {
					$this->log("User {$user->getDisplayName()} [guid: {$user->guid}] friended user {$friend->getDisplayName()} [guid: {$friend->guid}]");

					if ($collection instanceof \ElggAccessCollection && $this->faker()->boolean()) {
						$collection->addMember($friend->guid);
					}
					
					// randomize the river activity
					$since = $this->create_since;
					$this->setCreateSince(max($user->time_created, $friend->time_created));
					
					// fix river item
					$river = elgg_get_river([
						'view' => 'river/relationship/friend/create',
						'action_type' => 'friend',
						'subject_guid' => $user->guid,
						'object_guid' => $friend->guid,
					]);
					/* @var $item \ElggRiverItem */
					foreach ($river as $item) {
						$update = Update::table('river');
						$update->set('posted', $update->param($this->getRandomCreationTimestamp(), ELGG_VALUE_TIMESTAMP))
							->where($update->compare('id', '=', $item->id, ELGG_VALUE_ID));
						
						_elgg_services()->db->updateData($update);
					}
					
					$this->create_since = $since;
				}
			}

			$this->advance();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function unseed() {
		/* @var $users \ElggBatch */
		$users = elgg_get_entities([
			'type' => 'user',
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);

		/* @var $user \ElggUser */
		foreach ($users as $user) {
			if ($user->delete()) {
				$this->log("Deleted user {$user->guid}");
			} else {
				$this->log("Failed to delete user {$user->guid}");
				$users->reportFailure();
				continue;
			}

			$this->advance();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getType() : string {
		return 'user';
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions() : array {
		return [
			'type' => 'user',
		];
	}
}
