<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

elgg_load_js("lightbox");
elgg_load_css("lightbox");
//elgg_require_js("collections/embed");
elgg_load_js("collections/edit");

$value = $vars['value'];

/**
 * Add the embed menu item to the long text menu
 *
 * @param string $hook
 * @param string $type
 * @param array $items
 * @param array $vars
 * @return array
 */
	$page_owner = elgg_get_page_owner_entity();
	if (elgg_instanceof($page_owner, 'group') && $page_owner->isMember()) {
		$url = 'embed?container_guid=' . $page_owner->getGUID();
	}



echo '<a href="' . elgg_get_site_url() . 'collection/embed/' . $guid . '" class="elgg-longtext-control elgg-lightbox" rel="embed-lightbox-' . $vars['id'] . '">' . elgg_echo("collections:select_entity") . '</a>';

echo elgg_view('input/text', array('name' => 'entities[]', 'value' => $value));


