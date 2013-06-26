<?php
/**
 * Elgg dossierdepreuve export view
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2013
 * @link http://items.fr/
 */

global $CONFIG;
$date_format = 'd/m/Y';
$gen_date_format = 'd/m/Y à H:i';

// Selon les types de profil
if (elgg_is_admin_logged_in()) {
	$profile_type = 'admin';
} else {
	$profile_type = dossierdepreuve_get_rights('edit', elgg_get_logged_in_user_entity());
}

$dossierdepreuve = $vars['entity'];
if (isset($dossierdepreuve)) {
	// Entity variables
	$title = $dossierdepreuve->title;
	$description = $dossierdepreuve->description;
	$dossierdepreuve_guid = $dossierdepreuve->guid;
	$owner_guid = $dossierdepreuve->owner_guid;
	$container_guid = $dossierdepreuve->container_guid;
	$access_id = $dossierdepreuve->access_id;
	$typedossier = $dossierdepreuve->typedossier;
	$status = $dossierdepreuve->status;
} else return;

// Check accesses again.. (for direct use as a view)
if (!elgg_instanceof($dossierdepreuve, 'object', 'dossierdepreuve')) { return; }
// Vérification de l'accès à ce dossier
if (!dossierdepreuve_dossier_gatekeeper($dossierdepreuve_guid, false)) { return; }

$pagetitle = sprintf(elgg_echo("dossierdepreuve:edit"),$title);
$owner = get_entity($owner_guid);
$owner_name = $owner->name;
$owner_username = $owner->username;
$container = get_entity($container_guid);
$editor = elgg_get_logged_in_user_entity();
$time_created = elgg_view_friendly_time($dossierdepreuve->time_created);
$time_updated = elgg_view_friendly_time($dossierdepreuve->time_updated);
$status_text = elgg_echo('dossierdepreuve:status:' . $status);

// Mini-vue graphique
$picto = elgg_view('dossierdepreuve/picto', array('entity' => $dossierdepreuve));

// Eléments du dossier de preuve (articles et fichiers)
$user_blogs = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $owner_guid, 'limit' => false));
$user_files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'owner_guid' => $owner_guid, 'limit' => false));

$user_blogs_count = count($user_blogs);
$user_files_count = count($user_files);

// @TODO : améliorer le rendu avec comme infos : titre, date, tags, compétences associées, niveau d'accès, URL de la publication, contenu, intégration du fichier (image) et son URL (tous les fichiers)
// ARTICLES DE BLOG @TODO : classer par mois ?
foreach ($user_blogs as $ent) {
	$user_blogs_list .= '<a name="#proof-' . $ent->guid . '"><h3>' . $ent->title . '</h3></a>';
	$user_blogs_list .= elgg_echo('pdfexport:publisheddate') . date($date_format, $ent->time_created);
	if ($ent->time_updated > $ent->time_created) $user_blogs_list .= ' (dernière mise à jour le ' . date($date_format, $ent->time_updated) . ')';
	$user_blogs_list .= '<br />';
	if ($ent->tags) $user_blogs_list .= 'Tags : ' . elgg_view('output/tags', array('tags' => $ent->tags));
	if ($ent->referentiel_tags) $user_blogs_list .= 'Compétences associées : ' . elgg_view('output/tags', array('tags' => $ent->referentiel_tags));
	$user_blogs_list .= elgg_view('output/longtext', array('value' => $ent->description));
	$user_blogs_list .= '<div class="clearfloat"></div><br /><hr />';
}
//$user_blogs_list = elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $owner_guid, 'limit' => $user_blogs_count, 'full_view' => true));

// FICHIERS @TODO : classer par mois ?
foreach ($user_files as $ent) {
	$mime = $ent->mimetype;
	$base_type = substr($mime, 0, strpos($mime,'/'));
	$user_files_list .= '<a name="#proof-' . $ent->guid . '"><h3>' . $ent->title . '</h3></a>';
	$user_files_list .= elgg_echo('pdfexport:publisheddate') . date($date_format, $ent->time_created);
	if ($ent->time_updated > $ent->time_created) $user_files_list .= ' (dernière mise à jour le ' . date($date_format, $ent->time_updated) . ')';
	$user_files_list .= '<br />';
	if ($ent->tags) $user_files_list .= 'Tags : ' . elgg_view('output/tags', array('tags' => $ent->tags));
	if ($ent->referentiel_tags) $user_files_list .= 'Compétences associées : ' . elgg_view('output/tags', array('tags' => $ent->referentiel_tags));
	$user_files_list .= elgg_view_entity_icon($ent, 'large');
	$user_files_list .= elgg_view('output/longtext', array('value' => $ent->description));
	if (elgg_view_exists("file/specialcontent/$mime")) {
		$user_files_list .= elgg_view("file/specialcontent/$mime", $vars);
	} else if (elgg_view_exists("file/specialcontent/$base_type/default")) {
		$user_files_list .= elgg_view("file/specialcontent/$base_type/default", $vars);
	}
	$user_files_list .= '<div class="clearfloat"></div><br /><hr />';
}
//$user_files_list = elgg_list_entities(array('type' => 'object', 'subtype' => 'file', 'owner_guid' => $owner_guid, 'limit' => $user_files_count, 'full_view' => true));


// Liste de valeurs pour le rendu des sélecteurs choisis
$status_values =  array(
		'' => elgg_echo ('dossierdepreuve:choose'),
		'open' => "Dossier ouvert (en cours)",
		'closed' => "Dossier terminé",
  );
$autopositionnement_values = array(
		'' => elgg_echo ('dossierdepreuve:autopositionnement:'),
		'100' => elgg_echo ('dossierdepreuve:autopositionnement:100'),
		'50' => elgg_echo ('dossierdepreuve:autopositionnement:50'),
		'0' => elgg_echo ('dossierdepreuve:autopositionnement:0'),
	);
$competence_values =  array(
	  '' => elgg_echo ('dossierdepreuve:choose'),
	  '100' => elgg_echo ('dossierdepreuve:competence:100'),
	  '50' => elgg_echo ('dossierdepreuve:competence:50'),
	  '0' => elgg_echo ('dossierdepreuve:competence:0'),
  );
$typedossier_values = array(
	  '' => elgg_echo ('dossierdepreuve:choose'),
		'b2iadultes' => "B2i Adultes",
		/*
		'b2i' => "B2i",
		'passnumrra' => "Pass'Numérique",
		*/
	);

// Référentiel
$referentiel_b2iadultes = array(
		'1' => array('1', '2', '3', '4'), 
		'2' => array('1', '2', '3', '4'), 
		'3' => array('1', '2', '3'), 
		'4' => array('1', '2', '3', '4'), 
		'5' => array('1', '2', '3'), 
	);

// Export : on a besoin de ne mettre que l'essentiel dedans (HTML pur, style et JS à part)
$export_type = get_input('type', '');
if (empty($export_type)) {
	if (elgg_is_active_plugin('pdf_export')) {
		echo '<p><a href="' . $vars['url'] . 'dossierdepreuve/pdfexport/' . $dossierdepreuve->guid . '" class="elgg-button elgg-button-action">Exporter le dossier complet sous forme de PDF</a></p><br />';
		/*
		echo elgg_view('pdf_export/owner_block_extend');
		echo '<form action="' . $vars['url'] . 'pdfexport/export">';
		echo '<input type="text" name="export_html" value="' . full_url() . '?type=html" />';
		echo '<input type="submit" value="Exporter en PDF" />';
		echo '</form><br />';
		*/
		// @TODO : formulaire d'envoi au générateur de PDF (passer une varaible 'html')
	} else {
		register_error("Export impossible : plugin d'export PDF non activé !");
		echo '<p>Export impossible : plugin d\'export PDF non activé !</p>';
	}
	
	?>
	<script type="text/javascript">
	$(function() {
		$('#import-autopositionnement-report').accordion({ header:'h3', autoHeight:false, collapsible:true, active:false });
	});
	</script>

	<style>
	.ui-widget { font-size:1em; }
	.ui-state-active .ui-icon, .ui-state-default .ui-icon { float: left; margin-right: 10px; }

	/* Editor styles */
	#dossierdepreuve_learner_edit { border: 3px solid #0F0; padding: 6px; }
	#dossierdepreuve_tutor_edit { border: 3px solid #00F; padding: 6px; }
	#dossierdepreuve_evaluator_edit { border: 3px solid #F00; padding: 6px; }
	#dossierdepreuve_admin_edit { border: 3px dashed #F00; padding: 6px; }
	/* Fields styles */
	.learner, .tutor, .evaluator { display: block; float: left; width: 100%; padding: 1px 2px; }
	.learner select, .learner input,  .tutor select, .tutor input, .evaluator select, .evaluator input { float:right; padding:0; }
	.learner, .learner * { background-color: rgba(0,255,0, 0.1); }
	.tutor, .tutor * { background-color: rgba(0,0,255, 0.1); }
	.evaluator, .evaluator * { background-color: rgba(255,0,0, 0.1); }
	/*
	#dossierdepreuve_edit div.learner { background-color: rgba(0,255,0, 0.2); }
	#dossierdepreuve_edit div.tutor { background-color: rgba(0,0,255, 0.2); }
	#dossierdepreuve_edit div.evaluator { background-color: rgba(255,0,0, 0.2); }
	*/
	</style>
	
	<?php
	// Infos d'export
	echo "<blockquote>Vous exportez ce dossier de preuve en tant que {$editor->name}, " . elgg_echo('profile:types:' . $profile_type) . " ($profile_type).</blockquote><br />";
	
} else {
	// Infos d'export
	echo "<blockquote>Dossier exporté par {$editor->name}, " . elgg_echo('profile:types:' . $profile_type) . " ($profile_type).</blockquote><br />";
}
?>

<div class="contentWrapper">
	
	<div class="dossierdepreuve_export">
		<div id="dossierdepreuve_<?php echo $profile_type; ?>_export">
			
			<div class="dossierdepreuve_title_owner_wrapper">
				
				<div class="dossierdepreuve-title">
					<?php echo '<h2>Synthèse du dossier de preuve de ' . $owner->name . '</h2>'; ?>
				</div>
				
				<div class="dossierdepreuve-infobox">
					<?php
					echo '<p><strong>' . elgg_echo('dossierdepreuve:title') . '&nbsp;:</strong> ' . $title . '</p>';
					
					echo '<p>Dossier de preuve de <a href="' . $owner->getURL() . '">' . $owner->name . '</a>, créé ' . $time_created . ' (dernière mise à jour ' . $time_updated . ')</p>';
					
					echo '<p><strong>' . elgg_echo('dossierdepreuve:status') . '&nbsp;:</strong> ' . $status_values[$status] . '</p>';

					echo '<p><strong>' . elgg_echo('dossierdepreuve:typedossier') . '&nbsp;:</strong> ' . $typedossier_values[$typedossier] . '</p>';
					?>
					<p><strong>URL du dossier de preuve&nbsp;:</strong> <?php echo '<a href="' . $dossierdepreuve->getURL() . '">' . $dossierdepreuve->getURL() . '</a>'; ?></p>
					<?php
					// Metadata & technical info
					// Access rights
					/*
					echo '<p><strong for="dossierdepreuve_access_id">' . elgg_echo('dossierdepreuve:readaccess') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'id' => 'dossierdepreuve_access_id', 'value' => $access_id)) . '</strong></p>';
					*/
					echo '<p><strong>Identifiant unique du dossier sur ' . $CONFIG->url . '&nbsp;:</strong> ' . $dossierdepreuve->guid . '</p>';
					echo '<p><strong>Propriétaire du dossier&nbsp;:</strong> ' . $owner->name . '</p>';
					echo '<p><strong>Emplacement du dossier&nbsp;:</strong> ' . $container->name . '</p>';
					if ($tags) { echo '<p><strong>Tags&nbsp;:</strong> ' . elgg_view('output/tags',array('value' => $tags)) . '</p>'; }
					?>
				</div>
				<div class="clearfloat"></div>
				
			</div>
			
			<div class="clearfloat"></div><br />
		
			<div class="dossierdepreuve-maincontent">
				
				<?php
				if ($description) {
					echo '<div class="description"><p><strong>' . elgg_echo('dossierdepreuve:description') . '&nbsp;:</strong> ' . elgg_view('output/longtext', array('value' => $description)) . '</p></div>';
					echo '<div class="clearfloat"></div><br /><br />';
				}
				
				
				echo '<h3>' . elgg_echo('dossierdepreuve:referentiel:b2i:title') . '</h3>';
				echo $picto;
				echo '<div class="clearfloat"></div>';
				echo '<br />';
				
				echo '<strong>' . elgg_echo('dossierdepreuve:referentiel:legende') . '</strong><br />';
				echo '<p>' . elgg_echo('dossierdepreuve:referentiel:legende:description') . '</p>';
	
				// Affichage du référentiel
				// Domaine par domaine
				foreach ($referentiel_b2iadultes as $domaine => $competences) {
					echo '<h4>' . elgg_echo('dossierdepreuve:referentiel:' . $domaine) . '</h4>';
		
					// Compétence par compétence
					foreach ($competences as $competence) {
						echo '<h5>' . elgg_echo('dossierdepreuve:referentiel:' . $domaine . ':' . $competence) . ' : <em>' . elgg_echo('dossierdepreuve:referentiel:' . $domaine . ':' . $competence . ':description') . '</em></h5>';
						$meta_basename = $typedossier . '_' . $domaine . '_' . $competence . '_';
						echo '<p><em>Contenu de la compétence&nbsp;: ' . str_replace('<br />', "\n", elgg_echo('dossierdepreuve:referentiel:' . $domaine . ':' . $competence . ':aide')) . '<em></p>';
						
						// Eléments de preuve : manuels + ceux cochés via les articles
						// On a besoin du titre et des références de chacun: cf. listés ensuite en entier
						echo '<div class="clearfloat"></div>';
						// Eléments de preuves associés automatiquement par tags
						$proofs_auto_elements = '';
						$tag_name = "D$domaine.$competence";
						$blog_proofs = elgg_get_entities_from_metadata(array(
									'types' => 'object', 'subtypes' => array('blog', 'file'), 
									'owner_guids' => $owner_guid, 
									' metadata_names' => array('tags', 'referentiel_tags'), 
									'metadata_values' => $tag_name, 
									'metadata_case_sensitive' => false, 
							));
						if ($blog_proofs) {
							$proofs_auto_elements .= '<br />';
							foreach ($blog_proofs as $ent) {
								$proofs_auto_elements .= '<a href="#proof-' . $ent->guid . '" style="background:transparent;">n°' . $ent->guid . '&nbsp;: ' . $ent->title . ' - ' . $ent->getURL() . '</a><br />';
							}
						}
						
						echo '<div class="learner">';
						echo '<strong>Eléments de preuve :</strong> &nbsp; ' . $proofs_auto_elements . elgg_view('output/longtext', array('value' =>  $dossierdepreuve->{$meta_basename . 'proof'}));
						echo '</div>';
						
						// On affiche toutes les infos
						// @TODO : à voir, on va certainement filtrer pour ne garder que les infos évaluatives
						echo '<div class="learner" title="Auto-positionnement du candidat"><strong>Auto-positionnement&nbsp;:</strong> ' . $autopositionnement_values[$dossierdepreuve->{$meta_basename . 'value_learner'}] . ' (' . $dossierdepreuve->{$meta_basename . 'value_learner'} . ')</div>';
						echo '<div class="tutor" title="Suivi par le formateur"><strong>Suivi&nbsp;:</strong> ' . $competence_values[$dossierdepreuve->{$meta_basename . 'value_tutor'}] . ' (' . $dossierdepreuve->{$meta_basename . 'value_tutor'} . ')</div>';
						echo '<div class="evaluator" title="Evaluation par l\'habilitateur"><strong>Evaluation&nbsp;:</strong> ' . $competence_values[$dossierdepreuve->{$meta_basename . 'value_evaluator'}] . ' (' . $dossierdepreuve->{$meta_basename . 'value_evaluator'} . ')</div>';
			
						echo '<div class="clearfloat"></div>';
						echo '<br />';
					}
				}
				
				
				echo '<h2>Eléments de preuve</h2><br />';
				// Articles de blog
				//echo '<h3><a href="' . $vars['url'] . 'blog/owner/' . $owner_username . '">Article(s) de blog (' . $user_blogs_count . ')</a></h3>';
				if ($user_blogs_list) echo '<ul>' . $user_blogs_list . '</ul>';
				echo '<br /><br />';
			
				// Fichiers joints
				//echo '<h3><a href="' . $vars['url'] . 'file/owner/' . $owner_username . '">Images et fichiers (' . $user_files_count . ')</a></h3>';
				if ($user_files_list) echo '<ul>' . $user_files_list . '</ul>';
				echo '<br /><br />';
				?>
			
				<div class="clearfloat"></div><br />
			
			</div>
		</div>
	</div>
	<?php
	// Pas de commentaire sur les dossiers de preuve
	//if ($vars['full']) { echo elgg_view_comments($dossierdepreuve); }
	?>
	
</div>
<?php

