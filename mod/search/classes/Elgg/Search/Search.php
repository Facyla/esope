<?php

namespace Elgg\Search;

/**
 * Search plugin
 */
class Search {

	/**
	 * @var array
	 */
	protected $params;

	/**
	 * Constructor
	 *
	 * @param array $params Search params
	 */
	public function __construct(array $params = []) {
		$this->initParams($params);
	}

	/**
	 * Returns search params
	 * @return array
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * Prepares a new highlighter
	 * @return Highlighter
	 */
	public function getHighlighter() {
		return new Highlighter($this->getParams());
	}

	/**
	 * Returns searchable type/subtype pairs
	 *
	 * <code>
	 * [
	 *    'user' => [],
	 *    'object' => [
	 *       'blog',
	 *    ]
	 * ]
	 * </code>
	 *
	 * @return array
	 */
	public function getTypeSubtypePairs() {
		return elgg_trigger_event_results('search:config', 'type_subtype_pairs', $this->params, elgg_entity_types_with_capability('searchable'));
	}

	/**
	 * Returns search types
	 *
	 * @return array
	 */
	public function getSearchTypes() {
		return elgg_trigger_event_results('search:config', 'search_types', $this->params, []);
	}

	/**
	 * List search results for given search type
	 *
	 * @param string $search_type Search type
	 * @param string $type        Entity type
	 * @param string $subtype     Subtype
	 * @param bool   $count       Count
	 *
	 * @return int|string
	 */
	public function listResults($search_type, $type = null, $subtype = null, $count = false) {
		$current_params = $this->params;
		
		$current_params['search_type'] = $search_type;
		$current_params['type'] = $type;
		$current_params['subtype'] = $subtype;
		
		// normalizing current search params so the listing has better awareness
		$current_params = _elgg_services()->search->normalizeOptions($current_params);
		
		$current_params['count'] = true;
		$search_count = (int) elgg_search($current_params);
		
		if ($count) {
			return $search_count;
		}
		
		$results = [
			'entities' => [],
			'count' => $search_count,
		];

		if (!empty($results['count'])) {
			unset($current_params['count']);
			$results['entities'] = elgg_search($current_params);
		}

		if (empty($results['entities'])) {
			return '';
		}

		return elgg_view('search/list', [
			'results' => $results,
			'params' => $current_params,
		]);
	}

	/**
	 * Prepare search params from request query elements
	 *
	 * @param array $params Params
	 *
	 * @return void
	 */
	protected function initParams(array $params = []) {

		// $search_type == all || entities || trigger event
		$search_type = get_input('search_type', 'all');
		$fields = get_input('fields');
		
		$query = get_input('q', get_input('tag', ''));

		if (preg_match('/\"(.*)\"/i', $query)) {
			// if query is quoted, e.g. "elgg has been released", perform literal search
			$tokenize = false;
			$query = preg_replace('/\"(.*)\"/i', '$1', $query);
		} else {
			$tokenize = true;
		}

		if ($search_type == 'all') {
			// We only display 2 results per search type
			$limit = 2;
			$offset = 0;
			$pagination = false;
		} else {
			$limit = max((int) get_input('limit'), elgg_get_config('default_limit'));
			$offset = get_input('offset', 0);
			$pagination = true;
		}

		$entity_type = get_input('entity_type', ELGG_ENTITIES_ANY_VALUE);
		if ($entity_type) {
			$entity_subtype = get_input('entity_subtype', ELGG_ENTITIES_ANY_VALUE);
		} else {
			$entity_subtype = ELGG_ENTITIES_ANY_VALUE;
		}

		$owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE);
		$container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);

		$order = get_input('order', 'desc');
		$sort = get_input('sort', 'time_created');
		$sort_by = (array) get_input('sort_by', []);
		if (isset($sort_by['property'])) {
			// single array variant, convert to an array of sort_by specs
			$sort_by = [$sort_by];
		}
		
		switch ($sort) {
			case 'action_on':
				$sort_by[] = [
					'property_type' => 'attribute',
					'property' => 'last_action',
					'direction' => $order,
				];
				break;

			case 'created':
			case 'time_created':
				$sort_by[] = [
					'property_type' => 'attribute',
					'property' => 'time_created',
					'direction' => $order,
				];
				break;

			case 'updated':
				$sort_by[] = [
					'property_type' => 'attribute',
					'property' => 'time_updated',
					'direction' => $order,
				];
				break;

			case 'alpha':
				$sort_by[] = [
					'property_type' => 'metadata',
					'property' => $entity_type === 'object' ? 'title' : 'name',
					'direction' => get_input('order', 'asc'), // different default value
				];
				break;
		}

		$current_params = [
			'query' => $query,
			'offset' => $offset,
			'limit' => $limit,
			'sort_by' => $sort_by,
			'search_type' => $search_type,
			'fields' => $fields,
			'partial_match' => true,
			'tokenize' => $tokenize,
			'type' => $entity_type,
			'subtype' => $entity_subtype,
			'owner_guid' => $owner_guid,
			'container_guid' => $container_guid,
			'pagination' => $pagination,
		];

		$params = array_merge($current_params, $params);
		
		// normalizing here to set query_parts
		$this->params = _elgg_services()->search->normalizeOptions($params);
		
		// unsetting some data which will be reset during actual search
		if (empty($params['fields'])) {
			// no fields provided by input, so unset the magic fields from normalilzation
			unset($this->params['fields']);
		}
		
		unset($this->params['_elgg_search_service_normalize_options']);
	}
}
