<?php

namespace Elgg\Database\Seeds;

use Elgg\Exceptions\Seeding\MaxAttemptsException;

/**
 * Seed users
 *
 * @internal
 */
class Groups extends Seed {

	/**
	 * {@inheritdoc}
	 */
	public function seed() {
		$this->advance($this->getCount());

		$count_members = function ($group) {
			return elgg_count_entities([
				'types' => 'user',
				'relationship' => 'member',
				'relationship_guid' => $group->getGUID(),
				'inverse_relationship' => true,
				'metadata_names' => '__faker',
			]);
		};

		$exclude = [];

		$profile_fields_config = _elgg_services()->fields->get('group', 'group');
		$profile_fields = [];
		foreach ($profile_fields_config as $field) {
			$profile_fields[$field['name']] = $field['#type'];
		}
		
		while ($this->getCount() < $this->limit) {
			try {
				$group = $this->createGroup([
					'access_id' => $this->getRandomGroupVisibility(),
					'content_access_mode' => $this->getRandomGroupContentAccessMode(),
					'membership' => $this->getRandomGroupMembership(),
				], [
					'profile_fields' => $profile_fields,
					'group_tool_options' => _elgg_services()->group_tools->all(),
				]);
			} catch (MaxAttemptsException $e) {
				// unable to create a group with the given options
				continue;
			}

			$this->createIcon($group);

			$exclude[] = $group->guid;

			if ($count_members($group) > 1) {
				// exclude owner from count
				continue;
			}

			$members_limit = $this->faker()->numberBetween(1, 5);

			$members_exclude = [];

			while ($count_members($group) - 1 < $members_limit) {
				$member = $this->getRandomUser($members_exclude);
				if (!$member) {
					continue;
				}

				$members_exclude[] = $member->guid;

				if ($group->join($member)) {
					$this->log("User {$member->getDisplayName()} [guid: {$member->guid}] joined group {$group->getDisplayName()} [guid: {$group->guid}]");
				}

				if (!$group->isPublicMembership()) {
					$invitee = $this->getRandomUser($members_exclude);
					if ($invitee) {
						$members_exclude[] = $invitee->guid;
						if (!$group->isMember($invitee)) {
							$group->addRelationship($invitee->guid, 'invited');
							$this->log("User {$invitee->getDisplayName()} [guid: {$invitee->guid}] was invited to {$group->getDisplayName()} [guid: {$group->guid}]");
						}
					}

					$requestor = $this->getRandomUser($members_exclude);
					if ($requestor) {
						$members_exclude[] = $requestor->guid;
						if (!$group->hasRelationship($requestor->guid, 'invited')
							&& !$group->isMember($requestor)
						) {
							$requestor->addRelationship($group->guid, 'membership_request');
							$this->log("User {$invitee->getDisplayName()} [guid: {$invitee->guid}] requested to join {$group->getDisplayName()} [guid: {$group->guid}]");
						}
					}
				}
			}

			$this->advance();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function unseed() {
		/* @var $groups \ElggBatch */
		$groups = elgg_get_entities([
			'type' => 'group',
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);

		/* @var $group \ElggGroup */
		foreach ($groups as $group) {
			if ($group->delete()) {
				$this->log("Deleted group {$group->guid}");
			} else {
				$this->log("Failed to delete group {$group->guid}");
				$groups->reportFailure();
				continue;
			}

			$this->advance();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getType(): string {
		return 'group';
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'group',
		];
	}
}
