<?php
// Note : no value means "no" setting
$yesno_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );


// LIMIT ACCESS RIGHTS
/*
echo '<h3>Configuration des droits d\'accès</h3>';
$access_options = array( 'none' => elgg_echo('theme_fing:settings:limitaccess:nolimit'), 
		'groupsonly' => elgg_echo('theme_fing:settings:limitaccess:groupsonly'), 
		'usersonly' => elgg_echo('theme_fing:settings:limitaccess:usersonly'), 
		'usersandgroups' => elgg_echo('theme_fing:settings:limitaccess:usersandgroups'), 
	);
echo '<br /><label style="clear:left;">' . elgg_echo('theme_fing:settings:limitaccess') . ' ' . elgg_view('input/pulldown', array('name' => 'params[limitaccess]', 'options_values' => $access_options, 'value' => $vars['entity']->limitaccess)) . '</label>';
echo '<p>' . elgg_echo('theme_fing:settings:limitaccess:help') . '</p><br />';
*/



// Exemple de liste valide
/*
$validlist = '';
$validentities = get_registered_entity_types('object');
foreach($validentities as $type) { $validlist .= $type.','; }
*/

echo '<p><label>Liste des types de contenus republiés dans les groupes via le tag fing_ :  ' . elgg_view('input/text', array('name' => 'params[republication_subtypes]', 'value' => $vars['entity']->republication_subtypes)) . '</label></p>';

// HOME HIGHLIGHT/OFFICIAL - admin highlighted news and items
if (elgg_is_active_plugin('pin')) {
	
	// Main setting : activation or not
	echo '<br /><label style="clear:left;">' . elgg_echo('theme_fing:settings:homehighlight') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight]', 'options_values'=>$yesno_opt, 'value'=>$vars['entity']->homehighlight)) . '</label>';
	echo '<p>' . elgg_echo('theme_fing:settings:homehighlight:help') . '</p>';
	
	// Note : on utilise les éléments highlight pour avoir une liste déroulante
	if ($vars['entity']->homehighlight == 'yes') {
		
		// Liste multisite partout car on a besoin de pouvoir mettre tout type d'article en avant
		$ents = elgg_get_entities_from_metadata(array('types' => 'object', 'limit' => 0, 'metadata_name' => 'highlight'));
		$highlight_opt = array();
		$highlight_opt['no'] = '' . elgg_echo('theme_fing:settings:disabled');
		foreach ($ents as $ent) {
			$linktext = $ent->title;
			if (empty($linktext)) $linktext = $ent->description;
			if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
			if ($ent->owner_guid == $ent->container_guid) $linktext .= ' (portfolio de ' . get_entity($ent->owner_guid)->name;
			else $linktext .= ' (' . get_entity($ent->owner_guid)->name . ', ' . get_entity($ent->container_guid)->name;
			$linktext .= ' / ' . get_entity($ent->site_guid)->name . ')';
			$highlight_opt[$ent->guid] = $linktext;
		}
		
		// Hightlight 1 (main article)
		echo '' . elgg_echo('theme_fing:settings:homehighlight1') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight1]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight1, 'js' => ' style="max-width:60%;"')) . '';
		
		// Hightlight 2
		echo '<br />' . elgg_echo('theme_fing:settings:homehighlight2') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight2]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight2, 'js' => ' style="max-width:60%;"')) . '';
		
		// Hightlight 3
		echo '<br />' . elgg_echo('theme_fing:settings:homehighlight3') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight3]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight3, 'js' => ' style="max-width:60%;"')) . '';
		
		// Hightlight 4
		echo '<br />' . elgg_echo('theme_fing:settings:homehighlight4') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight4]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight4, 'js' => ' style="max-width:60%;"')) . '';
		
		// Hightlight 5
		echo '<br />' . elgg_echo('theme_fing:settings:homehighlightN') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight5]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight5, 'js' => ' style="max-width:60%;"')) . '';
		
		// Hightlight 6
		echo '<br />' . elgg_echo('theme_fing:settings:homehighlightN') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight6]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight6, 'js' => ' style="max-width:60%;"')) . '';
		
		// Hightlight 7
		echo '<br />' . elgg_echo('theme_fing:settings:homehighlightN') . ' ' . elgg_view('input/pulldown', array('name'=>'params[homehighlight7]', 'options_values'=>$highlight_opt, 'value'=>$vars['entity']->homehighlight7, 'js' => ' style="max-width:60%;"')) . '';
		
	}
}

