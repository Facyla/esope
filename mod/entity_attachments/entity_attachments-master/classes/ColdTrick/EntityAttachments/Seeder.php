<?php

namespace ColdTrick\EntityAttachments;

use Elgg\Database\Clauses\OrderByClause;
use Elgg\Database\QueryBuilder;
use Elgg\Database\Seeds\Seed;
use Elgg\Exceptions\Seeding\MaxAttemptsException;

/**
 * Database seeder
 */
class Seeder extends Seed {
	
	protected array $types = [
		'custom_link' => ['href', 'title', 'subtitle'],
		'download_link' => ['href', 'title'],
		'linked_entity' => ['entity_guid'],
		'linked_group' => ['entity_guid'],
		'linked_user' => ['entity_guid'],
	];
	
	/**
	 * {@inheritdoc}
	 */
	public function seed() {
		$this->advance($this->getCount());
		
		$excluded_containers = [];
		
		while ($this->getCount() < $this->limit) {
			$time_created = $this->getRandomCreationTimestamp();
			$container_guid = $this->getRandomContainerGUID($excluded_containers);
			if (empty($container_guid)) {
				// no more unique containers to attach to
				break;
			}
			
			try {
				/* @var $entity \EntityAttachment */
				$entity = $this->createObject([
					'subtype' => \EntityAttachment::SUBTYPE,
					'owner_guid' => $container_guid,
					'container_guid' => $container_guid,
					'time_created' => $time_created,
					'order' => $time_created,
					'attachment_type' => $this->getAttachmentType(),
				]);
			} catch (MaxAttemptsException $e) {
				// unable to create attachment with the given options
				continue;
			}
			
			// remove useless seeded data
			unset($entity->description);
			unset($entity->tags);
			unset($entity->title); // could be re-added later
			
			if (!isset($exluded_containers[$container_guid])) {
				$excluded_containers[$container_guid] = 0;
			}
			
			// don't add to many attachments to the same container
			$excluded_containers[$container_guid]++;
			
			$this->setAttachmentTypeData($entity);
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function unseed() {
		/* @var $entities \ElggBatch */
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \EntityAttachment::SUBTYPE,
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);
		
		/* @var $entity \EntityAttachment */
		foreach ($entities as $entity) {
			if ($entity->delete()) {
				$this->log("Deleted entity attachment {$entity->guid}");
			} else {
				$this->log("Failed to delete entity attachment {$entity->guid}");
				$entities->reportFailure();
				continue;
			}
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getType(): string {
		return \EntityAttachment::SUBTYPE;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => \EntityAttachment::SUBTYPE,
		];
	}
	
	/**
	 * Get a random seeded searchable entity to attach to
	 *
	 * @param array $excluded_guids excluded GUIDs
	 *
	 * @return int
	 */
	protected function getRandomContainerGUID(array $excluded_guids = []): int {
		$excluded_guids[0] = 0;
		
		array_filter($excluded_guids, function ($value) {
			return $value <= 3;
		});
		
		// attach to other searchable content types
		$searchable = elgg_entity_types_with_capability('searchable');
		$object_subtypes = elgg_extract('object', $searchable, []);
		$excluded_subtypes = [
			'file', // already has 'attachments'
			\EntityAttachment::SUBTYPE, // shouldn't happen but just in case
		];
		$object_subtypes = array_filter($object_subtypes, function ($subtype) use ($excluded_subtypes) {
			return !in_array($subtype, $excluded_subtypes);
		});
		if (empty($object_subtypes)) {
			return 0;
		}
		
		$guids = elgg_get_entities([
			'type' => 'object',
			'subtypes' => $object_subtypes,
			'metadata_names' => ['__faker'],
			'limit' => 1,
			'callback' => function ($row) {
				return (int) $row->guid;
			},
			'wheres' => [
				function (QueryBuilder $qb, $main_alias) use ($excluded_guids) {
					// exclude given GUIDs
					return $qb->compare("{$main_alias}.guid", 'NOT IN', array_keys($excluded_guids), ELGG_VALUE_GUID);
				},
				function (QueryBuilder $qb, $main_alias) {
					// exclude objects with another object as it's container (e.g. comments)
					$ce = $qb->joinEntitiesTable($main_alias, 'container_guid');
					
					return $qb->compare("{$ce}.type", '!=', 'object', ELGG_VALUE_STRING);
				}
			],
			'order_by' => new OrderByClause('RAND()', null),
		]);
		
		return empty($guids) ? 0 : $guids[0];
	}
	
	/**
	 * Get a random attachment type
	 *
	 * @return string
	 */
	protected function getAttachmentType(): string {
		return array_rand($this->types);
	}
	
	/**
	 * Set the attachment type specific data
	 *
	 * @param \EntityAttachment $entity attachment
	 *
	 * @return void
	 */
	protected function setAttachmentTypeData(\EntityAttachment $entity): void {
		$fields = elgg_extract($entity->attachment_type, $this->types);
		
		foreach ($fields as $field) {
			$value = null;
			
			switch ($field) {
				case 'entity_guid':
					$linked_entity = null;
					switch ($entity->attachment_type) {
						case 'linked_entity':
							$linked_guid = $this->getRandomContainerGUID([$entity->container_guid => 0]);
							if (!empty($linked_guid)) {
								$linked_entity = get_entity($linked_guid);
							}
							break;
						case 'linked_group':
							$linked_entity = $this->getRandomGroup();
							
							break;
						case 'linked_user':
							$linked_entity = $this->getRandomUser();
							break;
					}
					
					if ($linked_entity instanceof \ElggEntity) {
						$value = $linked_entity->guid;
					}
					break;
				case 'href':
					$value = $this->faker()->url();
					
					break;
				case 'subtitle':
					$value = $this->faker()->words($this->faker()->numberBetween(5, 10), true);
					
					break;
				case 'title':
					$value = $this->faker()->words($this->faker()->numberBetween(2, 5), true);
					
					break;
			}
			
			$entity->$field = $value;
		}
	}
}
