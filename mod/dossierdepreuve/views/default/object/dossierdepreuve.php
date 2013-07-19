<?php
/**
 * Elgg dossierdepreuve object view
 * 
 * @package Elggdossierdepreuve
 * @author Facyla
 * @copyright Items International 2010-2012
 * @link http://items.fr/
 */

global $CONFIG;

$dossierdepreuve = $vars['entity'];
if (!elgg_instanceof($dossierdepreuve, 'object', 'dossierdepreuve')) { return true; }
// Vérification de l'accès à ce dossier
if (!dossierdepreuve_dossier_gatekeeper($dossierdepreuve->guid, false)) { return true; }

// Generic data for both resume and full view
$title = $dossierdepreuve->title;
$dossierdepreuve_guid = $dossierdepreuve->guid;
$container_guid = $dossierdepreuve->container_guid;
$owner_guid = $dossierdepreuve->owner_guid;
$access_id = $dossierdepreuve->access_id;

$owner = get_entity($owner_guid);
$owner_name = $owner->name;
$owner_username = $owner->username;
$time_created = elgg_view_friendly_time($vars['entity']->time_created);
$time_updated = elgg_view_friendly_time($vars['entity']->time_updated);
$status = elgg_echo('dossierdepreuve:status:' . $vars['entity']->status);
$user_blogs_count = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $owner_guid, 'count' => true));
$user_files_count = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'owner_guid' => $owner_guid, 'count' => true));

if ($dossierdepreuve->canEdit()) {
	$edit_links = '<div class="dossierdepreuve_controls">';
	$edit_links .= '<a href="' . $vars['url'] . 'dossierdepreuve/edit/' . $dossierdepreuve->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('dossierdepreuve:update') . '</a>&nbsp; ';
	if (elgg_is_admin_logged_in()) {
	$edit_links .= elgg_view('output/confirmlink',array(
			'href' => $vars['url'] . "action/dossierdepreuve/delete?dossierdepreuve=" . $dossierdepreuve->getGUID(),
			'text' => elgg_echo("delete"), 'confirm' => elgg_echo("dossierdepreuve:delete:confirm"),
			'class' => 'elgg-button elgg-button-delete',
		));
	}
	$edit_links .= '</div>';
}


// Mini-vue graphique
$picto = elgg_view('dossierdepreuve/picto', array('entity' => $dossierdepreuve));



// RENDU DE L'OBJET DOSSIERDEPREUVE

if (elgg_get_context() == "search") {
	// VERSION ABRÉGÉE POUR LISTING DE RECHERCHE
	// Vue galerie : on verra plus tard si c'est utile...
	// if (get_input('search_viewtype') == "gallery") {} else {}
	
	if (empty($title)) { $title = '(dossier de preuve sans titre)'; }
	$icon = '<a href="' . $dossierdepreuve->getURL() . '"><img src="' . $image . '" style="float:right; max-width:120px; max-height:80px;" /></a>';
	
	$info = '<span style="float:right; max-width:300px; margin:0 0 2px 12px; font-size:10px; font-style:italic; font-weight:bold;">' . $status . '</span>';
	$info .= '<span style="clear:right; float:right; margin-left:12px;font-weight:bold;"><br />Dossier de suivi<br />' . $picto . '</span>';
	
	$info .= '<h3><a href="' . $dossierdepreuve->getURL() . '">' . $title . '</a></h3>';
	$info .= "<p class=\"owner_timestamp\" style=\"font-size:11px;\">";
	//$info .= "Dossier de preuve de <a href=\"{$vars['url']}pg/dossierdepreuve/{$owner->username}\">{$owner->name}</a>";
	$info .= "Dossier de suivi de <a href=\"{$owner->getURL()}\">{$owner->name}</a>";
	$info .= ", créé {$time_created}";
	if ($time_created != $time_updated) { $info .= " <small>(mis à jour {$time_updated})</small>"; }
	$numcomments = $dossierdepreuve->countComments();
	if ($numcomments) $info .= ", <a href=\"{$dossierdepreuve->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	$info .= '</p>';
	$info .= '<p>';
	$info .= "Eléments du dossier de preuve&nbsp;: ";
	$info .= '<a href="' . $vars['url'] . 'blog/owner/' . $owner_username . '">' . $user_blogs_count . ' article(s) de blog</a>, ';
	$info .= '<a href="' . $vars['url'] . 'file/owner/' . $owner_username . '">' . $user_files_count . ' image(s) et fichier(s)</a>';
	$info .= '</p>';
	$info .= $edit_links;
	//$info = '<span style="float:right; margin-left:4px;">' . $picto . '</span>' . $info;
	
	// Rendu 'listing' du dossier de preuve
	echo '<div class="dossierdepreuve-list"><div style="float:left; margin:0 6px 2px 0;">' . $icon . '</div><div>' . $info . '</div><div class="clearfloat"></div></div>';


} else {
	
	// VERSION COMPLÈTE DU DOSSIER DE PREUVE
	$description = $dossierdepreuve->description;
	//$user_blogs = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $owner_guid, 'limit' => $user_blogs_count));
	//$user_files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'owner_guid' => $owner_guid, 'limit' => $user_files_count));
	// @TODO : classer par mois ?
	$user_blogs_list = elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $owner_guid, 'limit' => $user_blogs_count, 'full_view' => false));
	// @TODO : classer par mois ?
	$user_files_list = elgg_list_entities(array('type' => 'object', 'subtype' => 'file', 'owner_guid' => $owner_guid, 'limit' => $user_files_count, 'full_view' => false));
	?>
	<div class="contentWrapper">
		<div class="dossierdepreuve_dossierdepreuve">
			
			<div class="dossierdepreuve_title_owner_wrapper">
				<div class="dossierdepreuve_title">
					<?php //echo '<h2><a href="' . $dossierdepreuve->getURL() . '">' . $title . '</a></h2>'; ?>
					<?php echo '<h2>Synthèse de votre dossier de preuve</h2>'; ?>
				</div>
				<div class="dossierdepreuve-identitybox">
					<?php echo $status; ?><br />
				</div>
				<div class="clearfloat"></div>
				<?php
				echo '<p class="owner_timestamp" style="font-size:11px;">Dossier de preuve de <a href="' . $owner->getURL() . '">' . $owner->name . '</a>, créé ' . $time_created;
				if ($time_created != $time_updated) { echo " <small>(mis à jour {$time_updated})</small>"; }
				echo '</p>';
				?>
			</div>
			
			<div class="dossierdepreuve_maincontent">
				<div class="dossierdepreuve-infobox">
					<?php if ($tags) { echo '<p>' . elgg_view('output/tags',array('value' => $tags)) . '</p>'; } ?>
				</div>
				<div class="clearfloat"></div><br />
				
				<?php
				if ($description) {
					echo '<div class="description">' . parse_urls($description) . '</div><br />';
					echo '<div class="clearfloat"></div>';
				}
				echo '<h3>Suivi du dossier (positionnement, évaluations et référentiel de compétences)</h3>';
				echo $picto;
				//echo '<div class="clearfloat"></div>';
				echo elgg_echo('dossierdepreuve:picto:description');
				echo '<div class="clearfloat"></div><br />';
				
				echo '<h3><a href="' . $vars['url'] . 'dossierdepreuve/edit/' . $dossierdepreuve->guid . '" class="elgg-button elgg-button-action">Mettre à jour &laquo;&nbsp;' . $title . '&nbsp;&raquo;</a></h3>';
				echo '<div class="clearfloat"></div>';
				echo '<br /><br />';
				
				// Articles de blog
				echo '<h3><a href="' . $vars['url'] . 'blog/owner/' . $owner_username . '">Article(s) de blog (' . $user_blogs_count . ')</a></h3>';
				if ($user_blogs_list) echo '<ul>' . $user_blogs_list . '</ul>';
				echo '<br /><br />';
				
				// Fichiers joints
				echo '<h3><a href="' . $vars['url'] . 'file/owner/' . $owner_username . '">Images et fichiers (' . $user_files_count . ')</a></h3>';
				if ($user_files_list) echo '<ul>' . $user_files_list . '</ul>';
				echo '<br /><br />';
				?>
				
				<div class="clearfloat"></div><br />
				
				<?php
				// Pas de liens d'édition en vue "fullview" (on a le bouton en haut + sur le côté = déjà un de trop)
				//echo $edit_links;
				?>
			</div>
			
		</div>
		<?php
		// Pas de commentaire sur les dossiers de preuve
		//if ($vars['full']) { echo elgg_view_comments($dossierdepreuve); }
		?>
		
	</div>
	<?php
}

