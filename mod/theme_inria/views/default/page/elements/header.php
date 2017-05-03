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
	
	// Groupes
	$groups = '';
	if (elgg_is_active_plugin('groups')) {
		// Liste de ses groupes
		$options = array( 'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ownguid, 'inverse_relationship' => false, 'limit' => 99, 'order_by' => 'time_created asc');
		// Cas des sous-groupes : listing avec marqueur de sous-groupe
		if (elgg_is_active_plugin('au_subgroups')) {
			// Si les sous-groupes sont activés : listing des sous-groupes sous les groupes, et ordre alpha si demandé
			$display_subgroups = elgg_get_plugin_setting('display_subgroups', 'au_subgroups');
			$display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
			$db_prefix = elgg_get_config('dbprefix');
			// Don't list subgroups here (we want to list them under parents, if listed)
			$options['wheres'] = array("NOT EXISTS ( SELECT 1 FROM {$db_prefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )");
			if ($display_alphabetically != 'no') {
				$options['joins'] = array("JOIN {$db_prefix}groups_entity ge ON e.guid = ge.guid");
				$options['order_by'] = 'ge.name ASC';
			}
	
		}
		$mygroups = elgg_get_entities_from_relationship($options);
		foreach ($mygroups as $group) {
			$groups .= '<li><a href="' . $group->getURL() . '">' 
				. '<img src="' . $group->getIconURL('tiny') . '" alt="' . str_replace('"', "''", $group->name) . ' (' . elgg_echo('esope:groupicon') . '" />' . $group->name . '</a></li>';
			// Si on liste les sous-groupes, on le fait ici si demandé
			if (elgg_is_active_plugin('au_subgroups') && ($display_subgroups == 'yes')) {
				$groups .= esope_list_groups_submenu($group, 1, true, $own);
			}
		}
	// "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
		$group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
		$invites_count = sizeof($group_invites);
		$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . elgg_echo('theme_inria:groupinvites') . '</a></li>';
		if ($invites_count == 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '">' . $invites_count . '</a></li>';
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '</a></li>';
		} else if ($invites_count > 1) {
			$invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '">' . $invites_count . '</a></li>';
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '</a></li>';
		} else {
			//$groupinvites = '<li><a href="' . $url . 'groups/invitations/' . $ownusername . '">' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '</a></li>';
		}
	}
	
}


// MAIN NAVIGATION MENU
if (elgg_is_logged_in()) {
	
		?>
		<div class="menu-navigation-toggle"><i class="fa fa-bars"></i> <?php echo elgg_echo('esope:menu:navigation'); ?></div>
		<ul class="elgg-menu elgg-menu-navigation elgg-menu-navigation-alt">
			<li class="home"><a href="javascript:void(0);" <?php if ((current_page_url() == $url) || (current_page_url() == $url . 'activity')) { echo 'class="active elgg-state-selected"'; } ?> ><i class="fa fa-file-text-o"></i> &nbsp; <?php echo elgg_echo('theme_inria:topbar:news'); ?> <i class="fa fa-angle-down"></i></a>
				<ul class="hidden">
					<?php if (elgg_is_active_plugin('dashboard')) { ?>
						<li class="home"><a href="<?php echo $url; ?>activity"><?php echo elgg_echo('river:all'); ?></a></li>
						<li><a href="<?php echo $url; ?>thewire/all"><?php echo elgg_echo('thewire:everyone'); ?></a></li>
					<?php } ?>
				</ul>
			</li>
	
			<?php /* activity : Fil d'activité du site */ ?>

			<?php if (elgg_is_active_plugin('groups')) { ?>
			<li class="groups"><a <?php if( (current_page_url() != $url . 'groups/all') && (elgg_in_context('groups') || (elgg_instanceof(elgg_get_page_owner_entity(), 'group')))) { echo 'class="active elgg-state-selected"'; } ?> href="javascript:void(0);"><i class="fa fa-comments-o"></i> &nbsp; <?php echo elgg_echo('groups'); ?> <i class="fa fa-angle-down"></i></a>
				<ul class="hidden">
					<li><a href="<?php echo $url . 'groups/member/' . $ownusername; ?>"><?php echo elgg_echo('groups:yours'); ?></a></li>
					<li><a href="<?php echo $url . 'p/groupes'; ?>"><?php echo elgg_echo('theme_inria:groups:discover'); ?></a></li>
					<li><a href="<?php echo $url . 'groups/all?filter=newest'; ?>"><?php echo elgg_echo('groups:all'); ?></a></li>
					<li><a href="<?php echo elgg_get_site_url() . 'groups/add/' . $ownguid; ?>"><?php echo elgg_echo('groups:add'); ?></a></li>
				</ul>
			</li>
			<?php } ?>
	
			<?php if (elgg_is_active_plugin('members')) { ?>
				<li class="members"><a <?php if(elgg_in_context('members') || elgg_in_context('profile') || elgg_in_context('friends')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url . 'members'; ?>"><i class="fa fa-user-circle-o"></i> &nbsp; <?php echo elgg_echo('theme_inria:members'); ?></a>
				</li>
			<?php } ?>
	
			<?php if (elgg_is_active_plugin('event_calendar')) { ?>
				<li class="agenda"><a <?php if (elgg_in_context('event_calendar') && !elgg_in_context('groups')) { echo 'class="active elgg-state-selected"'; } ?> href="<?php echo $url; ?>event_calendar/list/"><i class="fa fa-calendar"></i> &nbsp; <?php echo elgg_echo('theme_inria:event_calendar'); ?></a></li>
			<?php } ?>
		</ul>
	<?php
}


