<?php
/**
* Elgg CMS pages menu
* 
* @package ElggCMSpages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.net/
* 
*/

$access_opt = array(
	ACCESS_PUBLIC => elgg_echo('PUBLIC'), 
	ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'), 
	ACCESS_PRIVATE => elgg_echo('PRIVATE'), 
	//ACCESS_DEFAULT => elgg_echo('default_access:label'), //("accès par défaut")
);


// Get cmspages
$cmspages = elgg_get_entities(array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'limit' => 0));

if ($cmspages) {
	$url = elgg_get_site_url() . 'cmspages/edit/';
	
	// @TODO Filtrer par content_type, access_id, et regrouper par rubrique le cas échéant + organiser page parentes/enfant
	
	
	// Tri alphabétique des pages (sur la base du pagetype)
	usort($cmspages, create_function('$a,$b', 'return strcmp($a->pagetype,$b->pagetype);'));

	// Build select menu - Construit le menu, et détermine au passage si la page existe ou non
	foreach ($cmspages as $ent) {
		// Correct old URL pagetypes
		if (strpos($ent->pagetype, '_')) {
			$reload_marker = true;
			$ent->pagetype = str_replace('_', '-', $ent->pagetype);
		}
		if ($reload_marker) { register_error(elgg_echo('cmspages:error:updatedpagetypes')); }
		
		//$ent->delete(); // DEBUG/TEST : uncomment and run cmspages menu once to clean delete all cmspages (appears on page reload) - don't forget to comment again !
	
		// Useful infos
		$content .= '<li class="cmspages-item cmspages-item-' . $ent->content_type . '" id="cmspages-' . $ent->guid . '">';
		
		// Statut et visibilité
		//$content .= '<span style="float:right;">' . elgg_view('output/access', array('entity' => $ent)) . '</span>';
		$content .= '<span style="float:right; min-width:20ex;">';
			$content .= elgg_view('output/access', array('entity' => $ent, 'hide_text' => true)) . $access_opt[$ent->access_id];
		$content .= '</span>';
		// Statut = Publié ou Brouillon
		$content .= '<span style="float:right; margin-right:2ex;">';
			if ($cmspage->access_id === 0) {
				$content .= '<span class="cmspages-unpublished">' . elgg_echo('cmspages:status:notpublished') . '</span>';
			} else {
				$content .= '<span class="cmspages-published">' . elgg_echo('cmspages:status:published') . '</span>';
			}
		$content .= '</span>';
		
		
		
		$content .= '<span class="cmspages-content_type">' . elgg_echo('cmspages:type:' . $ent->content_type) . '</span>';
		
		$content .= '<a href="' . $url . $ent->pagetype . '">';
		if (!empty($ent->pagetitle)) $content .= $ent->pagetitle . ' (' . $ent->pagetype . ')';
		else $content .= '(' . $ent->pagetype . ')';
		$content .= '</a>';
		
		if (!empty($ent->display)) $content .= ', display = ' . $ent->display;
		
		$content .= '</li>';
	}
}
?>

<p><blockquote style="padding:6px 12px;">
	<a href="javascript:void(0);" class="inline_toggler" onclick="$('#cmspages_instructions').toggle();">&raquo;&nbsp;<?php echo elgg_echo('cmspages:showinstructions'); ?></a>
	<div id="cmspages_instructions" style="display:none;"><?php echo elgg_echo('cmspages:instructions'); ?></div>
</blockquote></p>

<h3><?php echo elgg_echo('cmspages:pageselect'); ?></h3>

<form action="<?php echo elgg_get_site_url() . 'cmspages/edit/';?>" name="new_cmspage" id="cmspages-form-new">
	<label>
		<?php echo elgg_echo('cmspages:newtitle'); ?> <input type="text" name="title" placeholder="<?php echo elgg_echo('cmspages:pageselect'); ?>" value="" style="width:30ex; max-width:100%;" />
	</label> 
	<input type="submit" class="elgg-button elgg-button-submit" value="<?php echo elgg_echo('create'); ?>" />
</form>
<div class="clearfloat"></div><br />
<br />


<h3><?php echo elgg_echo('cmspages:pageselect:filter'); ?></h3>

<form name="cmspage-search" id="cmspages-form-search">
	DEV - A VENIR
	<label><?php echo elgg_echo('cmspages:content_type'); ?> <input type="text" name="content_type" value="" style="width:30ex; max-width:100%;" /></label> 
	<label>
		<?php
		echo '<p><label>Visibilité' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => "", 'options' => $access_opt)) . '</label>';
		echo '</p>';
		?>
	</label> 
	<input type="submit" class="elgg-button elgg-button-submit" value="<?php echo elgg_echo('search'); ?>" />
</form>
<div class="clearfloat"></div><br />
<br />

<ul><?php echo $content; ?><ul>
<br />


