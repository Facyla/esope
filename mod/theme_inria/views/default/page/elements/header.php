<?php
/* Esope replaces topbar + header by a single header
 * See page/elements/topbar view for topbar content
 *
 * The main navigation menu is defined and customized here
 *
 * Header can be broken in 2 separate blocks by breaking out the enclosing div, then re-opening a new one
 * 	<div class="elgg-page-header">
 * 		<div class="elgg-inner">
 * 			$header
 * 		</div>
 * 	</div>
 */

$url = elgg_get_site_url();
$urlicon = $url . 'mod/esope/img/theme/';
$urlimg = $url . 'mod/theme_inria/graphics/';

$site = elgg_get_site_entity();
$title = $site->name;
$prev_q = get_input('q', '');

$lang = get_language();

if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;
	
	
	// Non-inria cannot create new groups
	$profile_type = esope_get_user_profile_type();
}


// SVG Icons
$svg_actus = '<svg id="iris-actus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M7 5.2v9.4H2.7V22a3 3 0 0 0 3 3H21.9a3 3 0 0 0 3-3V5.2ZM5.7 23a1 1 0 0 1-1-1V16.6H6.9V22a1 1 0 0 1-1 1Zm17.2-1a1 1 0 0 1-1 1H9V7.2H22.8Z"/><path d="M11.4 11.6h0l7.6 0a1 1 0 0 0 0-2h0l-7.5 0a1 1 0 0 0 0 2Z"/><path d="M11.4 16.1h8.4a1 1 0 1 0 0-2H11.4a1 1 0 1 0 0 2Z"/><path d="M11.4 20.5H16.9a1 1 0 1 0 0-2H11.4a1 1 0 0 0 0 2Z"/></svg>';
$svg_groupes = '<svg id="iris-groupes"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M25.54,3.17H9.66a1,1,0,0,0-1,1v5h-5a1,1,0,0,0-1,1V26a1,1,0,0,0,1.51.86L8.95,24H19.58a1,1,0,0,0,1-1V18.23L25,20.9A1,1,0,0,0,26.54,20V4.17A1,1,0,0,0,25.54,3.17ZM18.58,22H8.67a1,1,0,0,0-.51.14L4.71,24.23V11.12h4v5.94a1,1,0,0,0,1,1h8.92Zm6-3.74-3.45-2.07a1,1,0,0,0-.51-.14H10.66V5.17H24.54Z"/><circle cx="21.07" cy="10.61" r="0.99"/><circle cx="17.6" cy="10.61" r="0.99"/><circle cx="14.13" cy="10.61" r="0.99"/></svg>';
$svg_membres = '<svg id="iris-membres" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M25.7 15A10.7 10.7 0 1 0 7.4 22.5l0 0.1a10.7 10.7 0 0 0 15.1 0l0.1 0A10.6 10.6 0 0 0 25.7 15ZM15 6.4a8.6 8.6 0 0 1 7 13.8 8.9 8.9 0 0 0-3.6-2.6 4.6 4.6 0 1 0-6.6 0 8.9 8.9 0 0 0-3.6 2.7A8.6 8.6 0 0 1 15 6.4Zm2.6 8A2.6 2.6 0 1 1 15 11.8 2.6 2.6 0 0 1 17.6 14.4ZM9.5 21.7a7 7 0 0 1 11 0 8.6 8.6 0 0 1-11 0Z"/></svg>';
$svg_agenda = '<svg id="iris-agenda" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M19.6 15.6H17.1a1 1 0 0 0 0 2h2.5a1 1 0 0 0 0-2Z"/><path d="M19.6 19.5H17.1a1 1 0 0 0 0 2h2.5a1 1 0 1 0 0-2Z"/><path d="M12.7 15.6H10.2a1 1 0 0 0 0 2h2.5a1 1 0 0 0 0-2Z"/><path d="M12.6 19.5H10.2a1 1 0 1 0 0 2h2.5a1 1 0 1 0 0-2Z"/><path d="M21.1 7.1h-1v-2a1 1 0 0 0-2 0v2h-6v-2a1 1 0 0 0-2 0v2h-1a4 4 0 0 0-4 4V22.5a4 4 0 0 0 4 4h12a4 4 0 0 0 4-4V11.1A4 4 0 0 0 21.1 7.1Zm-12 2h12a2 2 0 0 1 2 2h-16A2 2 0 0 1 9.1 9.1Zm12 15.4h-12a2 2 0 0 1-2-2V13.1h16V22.5A2 2 0 0 1 21.1 24.5Z"/></svg>';



// MAIN NAVIGATION MENU
if (elgg_is_logged_in()) {
	
	// Compute open/closed tabs (makes menu more clear)
	$current_url = current_page_url();
	// Remove parameters for easier comparison (not really needed as the strpos method is preferable for RESTful URLs)
	if (strpos($current_url, '?')) $current_url = substr($current_url, 0, strpos($current_url, '?'));
	
	$selected_wire = $selected_activity = $selected_home = false;
	if (strpos($current_url, $url.'activity') === 0) { $selected_activity = true; }
	if (strpos($current_url, $url.'thewire') === 0) { $selected_wire = true; }
	if (($current_url == $url) || $selected_activity || $selected_wire) { $selected_home = true; }
	
	$selected_groups = $selected_groupsearch = false;
	if (elgg_in_context('groups') || elgg_instanceof(elgg_get_page_owner_entity(), 'group')) { $selected_groups = true; }
	if (($current_url == $url.'groups') || (strpos($current_url, $url.'groups?') === 0)) { $selected_groupsearch = true; }
	
	$selected_members = false;
	if (elgg_in_context('members') || elgg_in_context('profile') || elgg_in_context('friends') || (strpos($current_url, $url.'members') === 0)) { $selected_members = true; }
	
	$selected_event_calendar = false;
	if ((elgg_in_context('event_calendar') && !elgg_in_context('groups')) || (strpos($current_url, $url.'event_calendar') === 0)) { $selected_event_calendar = true; }
	
	?>
	<div class="menu-navigation-toggle hidden" style="color:white;"><i class="fa fa-compress"></i> <?php echo elgg_echo('hide') . ' ' . elgg_echo('esope:menu:navigation'); ?></div>
	<ul class="elgg-menu elgg-menu-navigation elgg-menu-navigation-alt">
		
		<li class="home <?php if ($selected_home) { echo 'elgg-state-selected'; } ?>">
			<a href="javascript:void(0);" <?php if ($selected_home) { echo 'class="active elgg-state-selected"'; } ?> title="<?php echo theme_inria_get_link_title('actualites'); ?>" >
				<?php echo $svg_actus . elgg_echo('theme_inria:topbar:news'); ?> <i class="fa fa-angle-down"></i></a>
			<ul class="hidden">
				<?php if (elgg_is_active_plugin('dashboard')) { ?>
					<li<?php if ($selected_wire) { echo ' class="elgg-state-selected"'; } ?>><a href="<?php echo $url; ?>thewire/all"><?php echo elgg_echo('theme_inria:home:wire'); ?></a></li>
					<li class="home<?php if ($selected_activity) { echo ' elgg-state-selected'; } ?>"><a href="<?php echo $url; ?>activity"><?php echo elgg_echo('theme_inria:home:river'); ?></a></li>
				<?php } ?>
			</ul>
		</li>

		<?php if (elgg_is_active_plugin('groups')) { ?>
		<li class="groups <?php if ($selected_groups) { echo ' elgg-state-selected'; } ?>">
			<a <?php if ($selected_groups) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);" title="<?php echo theme_inria_get_link_title('groupes'); ?>" >
				<?php echo $svg_groupes . elgg_echo('groups'); ?> <i class="fa fa-angle-down"></i></a>
			<ul class="hidden">
				<li<?php if ($current_url == $url.'groups/member') { echo ' class="elgg-state-selected"'; } ?>><a href="<?php echo $url . 'groups/member'; ?>" title="<?php echo theme_inria_get_link_title('mes-groupes'); ?>" ><?php echo elgg_echo('theme_inria:mygroups'); ?></a></li>
				<li<?php if ($current_url == $url.'groups/discover') { echo ' class="elgg-state-selected"'; } ?>><a href="<?php echo $url . 'groups/discover'; ?>" title="<?php echo theme_inria_get_link_title('groupes-a-decouvrir'); ?>" ><?php echo elgg_echo('theme_inria:groups:discover'); ?></a></li>
				<li<?php if ($selected_groupsearch) { echo ' class="elgg-state-selected"'; } ?>><a href="<?php echo $url . 'groups'; ?>" title="<?php echo theme_inria_get_link_title('tous-les-groupes'); ?>" ><?php echo elgg_echo('groups:all'); ?></a></li>
				<?php if ($profile_type == 'inria') { ?>
					<li<?php if ($current_url == $url.'groups/add') { echo ' class="elgg-state-selected"'; } ?>><a href="<?php echo elgg_get_site_url() . 'groups/add'; ?>" title="<?php echo theme_inria_get_link_title('creer-un-groupe'); ?>" ><?php echo elgg_echo('theme_inria:groups:add'); ?></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>

		<?php if (elgg_is_active_plugin('members')) {
			// Guests have no access to directory (TransAlgo)
			if ($profile_type == 'inria') {
				?>
				<li class="members <?php if ($selected_members) { echo ' elgg-state-selected'; } ?>">
					<a <?php if ($selected_members) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'members'; ?>" title="<?php echo theme_inria_get_link_title('membres'); ?>" >
						<?php echo $svg_membres . elgg_echo('theme_inria:members'); ?></a>
				</li>
				<?php
			}
		} ?>

		<?php if (elgg_is_active_plugin('event_calendar')) { ?>
			<li class="agenda <?php if ($selected_event_calendar) { echo ' elgg-state-selected'; } ?>">
				<a href="<?php echo $url; ?>event_calendar/list/" title="<?php echo theme_inria_get_link_title('agenda'); ?>" >
					<?php echo $svg_agenda . elgg_echo('theme_inria:agenda'); ?></a>
			</li>
		<?php } ?>
	</ul>
	<?php
}


