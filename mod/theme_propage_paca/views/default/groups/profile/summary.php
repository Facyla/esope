<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
$owner = $group->getOwnerEntity();

if (!$owner) {
	// not having an owner is very bad so we throw an exception
	$msg = elgg_echo('InvalidParameterException:IdNotExistForGUID', array('group owner', $group->guid));
	throw new InvalidParameterException($msg);
}

// Do not display presentation except from Pôle home page (= empty $rubrique)
$pole = theme_propage_paca_is_pole($group);
if ($pole) {
	// Pas de listing des sous-groupes dans les Pôles (car ce sont les Départements, déjà présents dans interface)
	elgg_unextend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
	
	// Tabs <=> rubrique dans l'accueil du groupe (publish|groups)
	$rubrique = get_input('rubrique', false);
	if ($rubrique) { return; }
}

?>
<div class="groups-profile clearfix elgg-image-block">
	<div class="elgg-image">
		<div class="groups-profile-icon">
			<?php
				// we don't force icons to be square so don't set width/height
				echo elgg_view_entity_icon($group, 'large', array(
					'href' => '',
					'width' => '',
					'height' => '',
				)); 
			?>
		</div>
		<div class="groups-stats">
			<?php
			echo elgg_view('group/elements/group_admins', $vars);
			/*
			<p>
				<b><?php echo elgg_echo("groups:owner"); ?>: </b>
				<?php
					echo elgg_view('output/url', array(
						'text' => $owner->name,
						'value' => $owner->getURL(),
						'is_trusted' => true,
					));
				?>
			</p>
			*/
			?>
		</div>
	</div>

	<div class="groups-profile-fields elgg-body">
		<?php echo elgg_view('groups/profile/fields', $vars); ?>
	</div>
</div>

<?php
if ($pole) {
	// Départements = Sous-groupes du Pôle
	echo theme_propage_paca_list_pole_departements($group);
	echo '<div class="clearfloat"></div><br />';
}


