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

// Get cmspages
$cmspages = elgg_get_entities(array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'limit' => 0));

if ($cmspages) {
	$url = elgg_get_site_url() . 'cmspages/edit/';
	
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
		$page_options .= '<li class="cmspages-item cmspages-item-' . $ent->content_type . '" id="cmspages-' . $ent->guid . '">';
		
		$page_options .= '<span style="float:right;">' . elgg_view('output/access', array('entity' => $ent)) . '</span>';
		
		$page_options .= '<span class="cmspages-content_type">' . elgg_echo('cmspages:type:' . $ent->content_type) . '</span>';
		
		$page_options .= '<a href="' . $url . $ent->pagetype . '">';
		if (!empty($ent->pagetitle)) $page_options .= $ent->pagetitle . ' (' . $ent->pagetype . ')';
		else $page_options .= '(' . $ent->pagetype . ')';
		$page_options .= '</a>';
		
		if (!empty($ent->display)) $page_options .= ', display = ' . $ent->display;
		
		$page_options .= '</li>';
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
		<?php echo elgg_echo('cmspages:newtitle'); ?> <input type="text" name="title" placeholder="<?php echo elgg_echo('cmspages:pageselect'); ?>" value="" />
	</label> 
	<input type="submit" class="elgg-button elgg-button-submit" value="<?php echo elgg_echo('create'); ?>" />
</form>
<div class="clearfloat"></div><br />
<br />

<ul><?php echo $page_options; ?><ul>
<br />


