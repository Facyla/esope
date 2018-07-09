<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package ElggBookmarks
 */

elgg_set_context('members');
elgg_push_context('search');

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb($owner->name);
*/
elgg_push_breadcrumb(elgg_echo('search'));


$title = '';
$content = '';
$sidebar = '';


$hide_directory = elgg_get_plugin_setting('hide_directory', 'esope');
if ($hide_directory == 'yes') { gatekeeper(); }

//elgg_require_js('elgg/spinner'); // @TODO make spinner work...

$sidebar .= elgg_view('esope/users/search', $vars);


// Invite external members - Inria only
$profile_type = esope_get_user_profile_type($user);
if ($profile_type == 'inria') {
	$sidebar .= '<div class="clearfloat"></div>';
	$sidebar .= '<div class="iris-invite-external">
			<ul class="elgg-menu elgg-menu-page elgg-menu-page-invite">
				<li class="elgg-menu-item-invite">
					<a href="' . elgg_get_site_url() . 'inria/invite" class="elgg-menu-content"><i class="fa fa-user-plus"></i>&nbsp;' . elgg_echo('theme_inria:invite_external') . '</a>
				</li>
			</ul>
		</div>';
	//		<p><a href="' . elgg_get_site_url() . 'inria/invite" class="elgg-button elgg-button-action elgg-menu-content">' . elgg_echo('theme_inria:invite_external') . '</a>
	// If using the page menu, normalize it first !
	//$sidebar .= elgg_view_menu('page', $vars);
} else {
	// No directory for guests (TransAlgo)
	forward(REFERER);
}


$content .= '<div class="iris-search-sort">';
	/*
	$num_members = esope_get_number_users();
	$content .= '<span class="iris-search-count">' . $num_members . ' ' . elgg_echo('members') . '</span>';
	*/
	$order_opt = array(
			'alpha' => elgg_echo('members:order:alpha'),
			'desc' => elgg_echo('members:order:desc'),
			'asc' => elgg_echo('members:order:asc'),
		);
	$content .= '<span class="iris-search-order">' . elgg_echo('members:order:select') . ' ' . elgg_view('input/select', array('name' => 'iris_members_search_order', 'options_values' => $order_opt, 'value' => get_input('order_by'))) . '</span>';
$content .= '</div>';

//$content .= '<div id="esope-search-results">' . elgg_echo('esope:search:nosearch') . '</div>';
$content .= '<div id="esope-search-results"></div>';



$body = elgg_view_layout('iris_search', array(
	'title' => false,
	'content' => $content,
	'sidebar' => $sidebar,
	'q' => get_input('q'),
	//'filter_context' => 'all',
	'filter' => 'search',
));

echo elgg_view_page($title, $body);

