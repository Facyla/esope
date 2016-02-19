<?php

namespace AU\RSSImport;

class RSSImport Extends \ElggObject {

	/**
	 * Set subtype to rssimport.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "rssimport";
	}

	/**
	 * Determine if we can use the rssimport functionality
	 * @return boolean
	 */
	static function canUse() {
		// admin can always use it
		if (elgg_is_admin_logged_in()) {
			return true;
		}

		// is this a cron call?
		if (elgg_in_context('cron')) {
			return true;
		}

		// are we restricting to admin only?
		if (elgg_get_plugin_setting('adminonly', PLUGIN_ID) == 'yes') {
			return false;
		}

		// allow other plugins a say
		return elgg_trigger_plugin_hook('rssimport', 'can_use', null, true);
	}

	/**
	 * 
	 * @param \ElggGroup $group
	 * @param type $import_into
	 * @param type $forward
	 * @return boolean
	 */
	static function groupGatekeeper($group, $import_into, $forward = true) {
		if (!($group instanceof \ElggGroup)) {
			return true;
		}

		$attribute = 'rssimport_' . $import_into . '_enable';
		if ($group->$attribute != 'no') {
			return true;
		}

		// it's disabled, forward if necessary, otherwise return false
		if ($forward) {
			register_error(elgg_echo('rssimport:group:disabled'));
			forward($group->getURL());
		}

		return false;
	}

	/**
	 * get the simplepie feed for this import
	 */
	public function getFeed() {
		$cache_location = elgg_get_config('dataroot') . 'simplepie_cache/';
		if (!is_dir($cache_location)) {
			mkdir($cache_location, 0777);
		}

		$feed = new \SimplePie();
		$feed->set_feed_url($this->description);
		$feed->set_cache_location($cache_location);
		$feed->handle_content_type();
		$feed->init();

		return $feed;
	}

	/**
	 * determines if a feed item has previously been imported
	 * 
	 * @param type $item
	 * @return boolean
	 */
	public function isAlreadyImported($item) {
		// normalize subtype for pages
		$subtype = $this->import_into;
		if ($subtype == 'pages') {
			$subtype = 'page';
		}

		// look for id first - less resource intensive
		// this will filter out anything that has already been imported
		$entities = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => $subtype,
			'container_guid' => $this->container_guid,
			'metadata_name_value_pairs' => array(
				'name' => 'rssimport_id',
				'value' => $item->get_id()
			),
			'count' => true
		));

		if ($entities) {
			return true;
		}

		// look for permalink
		// this will filter out anything that has already been imported
		$entities = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => $subtype,
			'container_guid' => $this->container_guid,
			'metadata_name_value_pairs' => array(
				'name' => 'rssimport_permalink',
				'value' => $item->get_permalink()
			),
			'count' => true
		));

		if ($entities) {
			return true;
		}

		//check by token - this will filter out anything that was a repost on the feed
		$token = $this->getComparisonToken($item);

		$entities = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => $subtype,
			'container_guid' => $this->container_guid,
			'metadata_name_value_pairs' => array(
				'name' => 'rssimport_token',
				'value' => $token
			),
			'count' => true
		));

		if ($entities) {
			return true;
		}

		return false;
	}

	/**
	 * get a comparison token for a feed item
	 * 
	 * @param type $item
	 * @return type
	 */
	public function getComparisonToken($item) {
		$author = $item->get_author();
		$pretoken = $item->get_title();
		$pretoken .= $item->get_content();
		if (is_object($author)) {
			$pretoken .= $author->get_name();
		}

		return md5($pretoken);
	}

	/**
	 * check if an item has been blacklisted
	 * 
	 * @param type $item
	 * @return bool
	 */
	public function isBlacklisted($item) {
		$options = array(
			'annotation_names' => array('rssimport_blacklist'),
			'annotation_values' => array($item->get_id(true)),
			'guids' => $this->guid,
			'count' => true
		);

		return (bool) elgg_get_annotations($options);
	}

	/**
	 * Import an item from this feed
	 * 
	 * @param type $item
	 * @return type
	 */
	public function importItem($item) {

		// give other plugins a chance to import it first
		// return true to indicate the item has been imported
		elgg_push_context('rssimport');
		$params = array(
			'entity' => $this,
			'item' => $item
		);
		$imported = elgg_trigger_plugin_hook('rssimport', 'import', $params, false);

		if ($imported) {
			elgg_pop_context();
			return true;
		}

		switch ($this->import_into) {
			case "pages":
				$history = $this->importPage($item);
				break;
			case "bookmarks":
				$history = $this->importBookmark($item);
				break;
			case "blog":
			default: // when in doubt, send to a blog
				$history = $this->importBlog($item);
				break;
		}

		elgg_pop_context();
		return $history;
	}

	/**
	 * Record a history of imports
	 * 
	 * @param type $history
	 */
	public function addToHistory($history) {
		if (is_array($history)) {
			if (count($history) > 0) {
				$ia = elgg_set_ignore_access(true);
				$history = implode(',', $history);
				$this->annotate('rssimport_history', $history, ACCESS_PRIVATE, $this->owner_guid);
				elgg_set_ignore_access($ia);
			}
		}
	}

	/**
	 * blacklist an item to prevent importing
	 * 
	 * @param array $item
	 */
	public function addToBlacklist($items) {
		if (is_array($items)) {
			foreach ($items as $item_id) {
				$this->annotate('rssimport_blacklist', $item_id);
			}
		}
	}

	/**
	 * remove items from the blacklist
	 * 
	 * @param array $items
	 */
	public function removeFromBlacklist($items) {
		if (!is_array($items) || !$items) {
			return false;
		}

		$options = array(
			'annotation_names' => array('rssimport_blacklist'),
			'annotation_values' => $items,
			'guids' => $this->guid
		);

		$annotations = elgg_get_annotations($options);

		foreach ($annotations as $annotation) {
			$annotation->delete();
		}

		return true;
	}

	/**
	 * is the content for this rssimport allowed to be imported by the system?
	 * 
	 * @return bool
	 */
	static function isContentImportable($import_into = null) {
		$return = true;

		if (!elgg_is_active_plugin($import_into)) {
			$return = false;
		}

		if (elgg_get_plugin_setting($import_into . '_enable', PLUGIN_ID) == 'no') {
			$return = false;
		}

		$params = array(
			'import_into' => $import_into,
			'entity' => Self
		);
		return elgg_trigger_plugin_hook('rssimport', 'content:importable', $params, $return);
	}

	/**
	 * import a feed item into a page
	 * 
	 * @param type $item
	 * @return int
	 */
	private function importPage($item) {
		//check if we have a parent page yet
		$options = array(
			'type' => 'object',
			'subtype' => 'page_top',
			'container_guid' => $this->container_guid,
			'metadata_name_value_pairs' => array(
				array(
					'name' => 'rssimport_feedpage',
					'value' => $this->title
				),
				array(
					'name' => 'rssimport_url',
					'value' => $this->description
				)
			)
		);

		$testpage = elgg_get_entities_from_metadata($options);

		if (!$testpage) {
			//create our parent page
			$parent = new \ElggObject();
			$parent->subtype = 'page_top';
			$parent->container_guid = $this->container_guid;
			$parent->owner_guid = $this->owner_guid;
			$parent->access_id = $this->defaultaccess;
			$parent->parent_guid = 0;
			$parent->write_access_id = ACCESS_PRIVATE;
			$parent->title = $this->title;
			$parent->description = $this->description;
			//set default tags
			$parent->tags = string_to_tag_array($this->defaulttags);
			$parent->save();

			$parent->annotate('page', $parent->description, $parent->access_id, $parent->owner_guid);

			$parent_guid = $parent->guid;

			//add our identifying metadata
			$parent->rssimport_feedpage = $this->title;
			$parent->rssimport_url = $this->description;

			// this should be all we need to identify
			$parent->rssimport_guid = $this->guid;
		} else {
			$parent_guid = $testpage[0]->guid;
		}

		//initiate our object
		$page = new \ElggObject();
		$page->subtype = 'page';
		$page->container_guid = $this->container_guid;
		$page->owner_guid = $this->owner_guid;
		$page->access_id = $this->defaultaccess;
		$page->parent_guid = $parent_guid;
		$page->write_access_id = ACCESS_PRIVATE;
		$page->title = $item->get_title();

		$author = $item->get_author();
		$pagebody = $item->get_content();
		$pagebody .= "<br><br>";
		$pagebody .= "<hr><br>";
		$pagebody .= elgg_echo('rssimport:original') . ": <a href=\"" . $item->get_permalink() . "\">" . $item->get_permalink() . "</a> <br>";
		if (is_object($author)) {
			$pagebody .= elgg_echo('rssimport:by') . ": " . $author->get_name() . "<br>";
		}

		$pagebody .= rssimport_add_source($item);
		$date_format = elgg_echo('rssimport:date:format');
		$pagebody .= elgg_echo('rssimport:posted') . ": " . $item->get_date($date_format);

		$page->description = $pagebody;

		//set default tags
		$tagarray = string_to_tag_array($this->defaulttags);
		$categories = $item->get_categories();
		if (is_array($categories)) {
			foreach ($categories as $category) {
				$tagarray[] = $category->get_label();
			}
		}
		$tagarray = array_unique($tagarray);
		$tagarray = array_values($tagarray);

		if (is_array($tagarray)) {
			$page->tags = $tagarray;
		}

		$page->save();

		$page->annotate('page', $page->description, $page->access_id, $page->owner_guid);

		//add our identifying metadata
		$token = $this->getComparisonToken($item);
		$page->rssimport_token = $token;
		$page->rssimport_id = $item->get_id();
		$page->rssimport_permalink = $item->get_permalink();
		$page->time_created = strtotime($item->get_date()) ? strtotime($item->get_date()) : time();
		$page->save(); // save again to set proper time_created
		// let other plugins have a say in things
		$params = array(
			'rssimport' => $this,
			'item' => $item
		);

		$page = elgg_trigger_plugin_hook('rssimport', 'import:content', $params, $page);
        
        $add_river = $this->getAddRiverSetting();
        
        if ($add_river) {
            elgg_create_river_item(array(
				'view' => 'river/object/page/create',
				'action_type' => 'create',
				'subject_guid' => $page->owner_guid,
				'object_guid' => $page->guid,
			));
        }

		return $page->guid;
	}

	/**
	 * import content into a bookmark
	 * 
	 * @param type $item
	 */
	private function importBookmark($item) {

		$bookmark = new \ElggObject;
		$bookmark->subtype = "bookmarks";
		$bookmark->owner_guid = $this->owner_guid;
		$bookmark->container_guid = $this->container_guid;
		$bookmark->title = $item->get_title();
		$bookmark->address = $item->get_permalink();

		$author = $item->get_author();
		$pagebody = $item->get_content();
		$pagebody .= "<br><br>";
		$pagebody .= "<hr><br>";
		$pagebody .= elgg_echo('rssimport:original') . ": <a href=\"" . $item->get_permalink() . "\">" . $item->get_permalink() . "</a> <br>";
		if (is_object($author)) {
			$pagebody .= elgg_echo('rssimport:by') . ": " . $author->get_name() . "<br>";
		}

		$pagebody .= rssimport_add_source($item);
		$date_format = elgg_echo('rssimport:date:format');
		$pagebody .= elgg_echo('rssimport:posted') . ": " . $item->get_date($date_format);

		$bookmark->description = $pagebody;

		$bookmark->access_id = $this->defaultaccess;

		// merge default tags with any from the feed
		$tagarray = string_to_tag_array($this->defaulttags);
		$categories = $item->get_categories();
		if (is_array($categories)) {
			foreach ($categories as $category) {
				$tagarray[] = $category->get_label();
			}
		}
		$tagarray = array_unique($tagarray);
		$tagarray = array_values($tagarray);
		$bookmark->tags = $tagarray;

		$bookmark->save();

		//add metadata
		$token = $this->getComparisonToken($item);
		$bookmark->rssimport_token = $token;
		$bookmark->rssimport_id = $item->get_id();
		$bookmark->rssimport_permalink = $item->get_permalink();
		$bookmark->time_created = strtotime($item->get_date()) ? strtotime($item->get_date()) : time();
		$bookmark->save(); // save again to set time_created
		// let other plugins have a say in things
		$params = array(
			'rssimport' => $this,
			'item' => $item
		);

		$bookmark = elgg_trigger_plugin_hook('rssimport', 'import:content', $params, $bookmark);
        
        $add_river = $this->getAddRiverSetting();
        
        if ($add_river) {
            elgg_create_river_item(array(
				'view' => 'river/object/bookmarks/create',
				'action_type' => 'create',
				'subject_guid' => $bookmark->owner_guid,
				'object_guid' => $bookmark->guid,
			));
        }

		return $bookmark->guid;
	}

	/**
	 * import a feed item into a blog
	 * 
	 * @param type $item
	 * @return type
	 */
	private function importBlog($item) {
		$blog = new \ElggBlog();
		$blog->excerpt = elgg_get_excerpt($item->get_content());
		$blog->owner_guid = $this->owner_guid;
		$blog->container_guid = $this->container_guid;
		$blog->access_id = $this->defaultaccess;
		$blog->title = $item->get_title();

		//	build content of blog post
		$author = $item->get_author();
		$pagebody = $item->get_content();
		$pagebody .= "<br><br>";
		$pagebody .= "<hr><br>";
		$pagebody .= elgg_echo('rssimport:original') . ": <a href=\"" . $item->get_permalink() . "\">" . $item->get_permalink() . "</a> <br>";
		if (is_object($author)) {
			$pagebody .= elgg_echo('rssimport:by') . ": " . $author->get_name() . "<br>";
		}

		$pagebody .= rssimport_add_source($item);
		$date_format = elgg_echo('rssimport:date:format');
		$pagebody .= elgg_echo('rssimport:posted') . ": " . $item->get_date($date_format);

		$blog->description = $pagebody;

		//add feed tags to default tags and remove duplicates
		$tagarray = string_to_tag_array($this->defaulttags);
		$categories = $item->get_categories();
		if (is_array($categories)) {
			foreach ($categories as $category) {
				$tagarray[] = $category->get_label();
			}
		}
		$tagarray = array_unique($tagarray);
		$tagarray = array_values($tagarray);

		// Now let's add tags. We can pass an array directly to the object property! Easy.
		if (is_array($tagarray)) {
			$blog->tags = $tagarray;
		}

		//whether the user wants to allow comments or not on the blog post
		// do we want to make this selectable?
		$blog->comments_on = true;
		// Now save the object
		$blog->save();

		//add metadata
		$token = $this->getComparisonToken($item);
		$blog->rssimport_token = $token;
		$blog->rssimport_id = $item->get_id();
		$blog->rssimport_permalink = $item->get_permalink();
		$blog->status = 'published';

		$blog->time_created = strtotime($item->get_date()) ? strtotime($item->get_date()) : time();
		$blog->save(); // have to save again to set the new time_created
		// let other plugins have a say in things
		$params = array(
			'rssimport' => $this,
			'item' => $item
		);

		$blog = elgg_trigger_plugin_hook('rssimport', 'import:content', $params, $blog);
        
        $add_river = $this->getAddRiverSetting();
        
        if ($add_river) {
            elgg_create_river_item(array(
				'view' => 'river/object/blog/create',
				'action_type' => 'create',
				'subject_guid' => $blog->owner_guid,
				'object_guid' => $blog->guid,
			));
        }
        
        elgg_trigger_event('publish', 'object', $blog);

		return $blog->guid;
	}

    /**
     * Determine if a river entry should be added for an import
     * 
     * @staticvar type $add_river
     * @return bool
     */
    private function getAddRiverSetting() {
        static $add_river;
        
        if (!is_null($add_river)) {
            return $add_river;
        }
        
        $setting = elgg_get_plugin_setting('add_river', PLUGIN_ID);
        
        $add_river = ($setting === 'yes');
        
        return $add_river;
    }
}
