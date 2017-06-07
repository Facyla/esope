<?php

$group = elgg_get_page_owner_entity();
$url = elgg_get_site_url();

$content = '';

$base_url = $url . 'groups/content/' . $group->guid . '/';


// Back button
if (current_page_url() != $url . 'groups/workspace/'.$group->guid) {
	$content .= '<div class="iris-sidebar-content iris-back"><a href="' . $url . 'groups/workspace/'.$group->guid . '"><i class="fa fa-angle-left"></i> &nbsp; ' . elgg_echo('theme_inria:workspace:back') . '</a></div>';
}


$content .= '<div class="iris-sidebar-content">';

	//if ($group->file_enable == 'yes') {
	if (true) {
		$options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'file/all',
				//'href' => "file/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:file', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('file')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
			$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

	if ($group->blog_enable == 'yes') {
		$options = array('type' => 'object', 'subtype' => 'blog', 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'blog/all',
				//'href' => "blog/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:blog', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('blog')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
			$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

	if ($group->pages_enable == 'yes') {
		$options = array('type' => 'object', 'subtype' => array('page', 'page_top'), 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'pages/all',
				//'href' => "pages/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:pages', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('pages')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
		$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

	if ($group->bookmarks_enable == 'yes') {
		$options = array('type' => 'object', 'subtype' => 'bookmarks', 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'bookmarks/all',
				//'href' => "bookmarks/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:bookmarks', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('bookmarks')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
			$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

	if ($group->newsletter_enable == 'yes') {
		$options = array('type' => 'object', 'subtype' => 'newsletter', 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'newsletter/all',
				//'href' => "newsletter/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:newsletter', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('newsletter')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
			$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

	if ($group->poll_enable == 'yes') {
		$options = array('type' => 'object', 'subtype' => 'poll', 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'poll/all',
				//'href' => "poll/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:poll', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('poll')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
			$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

	if ($group->event_calendar_enable == 'yes') {
		$options = array('type' => 'object', 'subtype' => 'event_calendar', 'container_guid' => $group->guid, 'limit' => 8);
		$count = elgg_get_entities($options + array('count' => true));
		$link = elgg_view('output/url', array(
				'href' => $base_url . 'event_calendar/all',
				//'href' => "event_calendar/group/$group->guid/all",
				'text' => elgg_echo('theme_inria:sidebar:event_calendar', array($count)) . ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
				'class' => (elgg_in_context('event_calendar')) ? 'elgg-state-selected':'',
			));
		$content .= '<div class="workspace-subtype-header">';
			$content .= '<h3>' . $link . '</h3>';
		$content .= '</div>';
	}

$content .= '</div>';




if (!empty($vars['sidebar'])) {
	$content .= '<div class="iris-sidebar-content">';
	$content .= $vars['sidebar'];
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
}



echo '<div class="menu-sidebar-toggle"><i class="fa fa-th-large"></i> ' . elgg_echo('esope:menu:sidebar') . '</div>
	<div class="elgg-sidebar iris-group-sidebar">
		' . $content . '
	</div>';

