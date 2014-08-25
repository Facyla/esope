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

$pagetype = elgg_get_friendly_title($vars['pagetype']); // CMS Page type - used instead of GUIDs to select cmspage entities
$url = $vars['url'] . "cmspages/?pagetype=$pagetype"; // Set the base url
$new_page = true;

// Empty pagetype or very short pagetypes are not allowed
$tooshort = (strlen($pagetype)<3) ? true : false;

// Get cmspages
$params = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'count' => true);
$cmspages_count = elgg_get_entities($params);
$params['limit'] = $cmspages_count;
$params['count'] = false;
$cmspages = elgg_get_entities($params);

if ($cmspages) {
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
		if (empty($ent->pagetitle)) $cmspage_details = ''; else $cmspage_details =	$ent->pagetitle . ', ';
		$cmspage_details .= $ent->content_type . ', access = ' . $ent->access_id;
		if (!empty($ent->display)) $cmspage_details .= ', display = ' . $ent->display;
		$page_options .= '<option value="' . $ent->pagetype . '"';
	
		if ($ent->pagetype != $pagetype) {
			$page_options .= '>' . $ent->pagetype . ' (' . $cmspage_details . ')';
		} else {
			// Current cmspage - Sélectionne la page demandée (+ marqueur pas nouvelle page)
			$new_page = false; // La page existe bien..
			$cmspage_title = $pagetype . ' (' . $cmspage_details . ')'; // Use var because it's reused
			$page_options .= ' selected="selected">&nbsp;&gt;&gt;&nbsp;' . $cmspage_title . '&nbsp;&lt;&lt;&nbsp;';
		}
		$page_options .= '</option>';
	}
}
// Si la page n'existe pas encore, ajoute l'entrée dans le menu
if ($new_page) {
	$cmspage_title = ($tooshort) ? elgg_echo('cmspages:createmenu', array($pagetype)) : elgg_echo('cmspages:newpage', array($pagetype));
	$page_options .= '<option value="' . $pagetype . '" selected="selected">&nbsp;&gt;&gt;&nbsp;' . $cmspage_title . '&nbsp;&lt;&lt;&nbsp;</option>';
}
?>

<div style="border:1px dashed #DEDEDE; padding:6px 12px;">
	<form name="cmspage_switcher">
		<?php echo elgg_echo('cmspages:pageselect'); ?> 
		<select name="pagetype"	onChange="javascript:document.cmspage_switcher.submit();" style="max-width:100%;">
			<option value="" disabled="disabled"><?php echo elgg_echo('cmspages:pageselect'); ?></option>
			<?php echo $page_options; ?>
		</select>
		<?php echo elgg_echo('cmspages:pagescreated', array($cmspages_count)); ?><br />
	</form><br />

	<form name="new_cmspage">
		<?php
		$title_value = ($tooshort) ? $pagetype : ' ' . elgg_echo('cmspages:addnewpage') . ' ';
		$tab_w = 5;
		if (empty($title_value)) $title_value = elgg_echo('cmspages:settitle');
		$tab_w = strlen($title_value); $tab_nw = ($tab_w < 40) ? 40 : $tab_w;
		?>
		<input type="text" style="border:1px solid #DEDEDE; width:<?php echo $tab_w; ?>ex;" name="pagetype" value="<?php echo $title_value; ?>" onclick="if (this.value=='<?php echo $title_value; ?>') { this.value=''; this.style.width='50ex' }" title="<?php echo elgg_echo('cmspages:newtitle'); ?>" />
		<noscript><input type="submit" style="border:0; margin:0; padding:1px 1px 3px 1px; font-size:10px; background: #0000FF;" value="<?php echo elgg_echo('cmspages:new'); ?>" /> &nbsp; </noscript>
	</form><br />
	
	<blockquote style="padding:6px 12px;">
		<a href="javascript:void(0);" class="inline_toggler" onclick="$('#cmspages_instructions').toggle();">&raquo;&nbsp;<?php echo elgg_echo('cmspages:showinstructions'); ?></a>
		<div id="cmspages_instructions" style="display:none;"><?php echo elgg_echo('cmspages:instructions'); ?></div>
	</blockquote>
	
</div>
<br />


<?php
// Edit currently selected cms page
if (!$tooshort) {
	// If page exists, link to delete - Si page existante, lien pour suppression
	if (!$new_page) {
		$options = array('metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1);
		$this_pages = elgg_get_entities_from_metadata($options);
		// Get selected page GUID
		if ($this_pages) { $this_page = $this_pages[0]; $cmspage_guid = $this_page->guid; }
		/*
		echo '<span style="float:right; font-weight:bold; color:red;" class="delete">';
		$delete_form_body = '<input type="hidden" name="cmspage_guid" value="' . $cmspage_guid . '" /><input type="submit" name="delete" value="' . elgg_echo('cmspages:delete') . '" onclick="javascript:return confirm(\'' . elgg_echo('cmspages:deletewarning') . '\');" style="border:0; font-weight:bold; color:red;" class="elgg-button delete" />';
		echo '<div style="float:right;" id="delete_group_option">' . elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/delete", 'body' => $delete_form_body, 'js' => ' style="background:transparent;"')) . '</div>';
		echo '</span>';
		*/
	}
	//echo '<h3><a href="' . $url . '">' . $cmspage_title . '</a></h3>';
}


