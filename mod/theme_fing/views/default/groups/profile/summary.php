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

// Fing : on remplace le contenu standard par un agencement plus approprié à un accès hors-connexion
// Voir aussi les vues dans groups/profile/ et group/topmenu

?>
<div class="groups-profile clearfix elgg-image-block">
	
	<?php if (elgg_is_logged_in()) { ?>
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
			</div>
		</div>
		<div class="groups-profile-fields elgg-body">
			<?php echo elgg_view('groups/profile/fields', $vars); ?>
		</div>
		
	<?php } else { ?>
		
		<div class="groups-profile-fields elgg-body">
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
			<?php echo elgg_view('groups/profile/fields', $vars); ?>
		</div>
		
	<?php } ?>
	
</div>

