<?php
/**
 * Elgg dossierdepreuve edit form
 * 
 * @package Elggdossierdepreuve
 * @author Facyla
 * @copyright Items International 2013
 * @link http://items.fr/
 */

global $CONFIG;

// Selon les types de profil
if (elgg_is_admin_logged_in()) {
	$profile_type = 'admin';
} else {
	$profile_type = dossierdepreuve_get_rights('edit', elgg_get_logged_in_user_entity());
}

if (isset($vars['entity'])) {
  $pagetitle = sprintf(elgg_echo("dossierdepreuve:edit"),$title);
  $action = "dossierdepreuve/edit";
  // Entity variables
  $title = $vars['entity']->title;
  $description = $vars['entity']->description;
  $owner_guid = $vars['entity']->owner_guid;
  $container_guid = $vars['entity']->container_guid;
  $access_id = $vars['entity']->access_id;
  $typedossier = $vars['entity']->typedossier;
  $status = $vars['entity']->status;
  
} else {
	$vars['entity'] = new ElggObject;
	$vars['entity']->subtype = 'dossierdepreuve';
  $pagetitle = elgg_echo("dossierdepreuve:new");
  $action = "dossierdepreuve/new";
  $owner_guid = get_input('owner_guid', elgg_get_logged_in_user_guid());
  $container_guid = $owner_guid;
  $access_id = 1; // Default is members
  $write_access_id = ACCESS_PRIVATE; // Default is private
  $status = 'open';
  $typedossier = 'b2iadultes';
}

$owner = get_entity($owner_guid);
$editor = elgg_get_logged_in_user_entity();


// Si on demande de créer un dossier et qu'il y a déjà un dossier pour cette personne => redirection
if (!isset($vars['entity']->guid)) {
	$existing_dossier = dossierdepreuve_get_user_dossier($owner_guid);
	if ($existing_dossier) {
		register_error($owner->name . " a déjà un dossier de suivi. Vous avez été redirigé sur la page d'édition de son dossier.");
		$edit_url = $vars['url'] . 'dossierdepreuve/edit/' . $existing_dossier->guid;
		forward($edit_url);
	}
}


// Input data : update data & pre-selections
$update_autopositionnement = get_input('update_autopositionnement');
$autopositionnement_data = get_input('autopositionnement_data');


?>
<script type="text/javascript">
$(function() {
	$('#import-autopositionnement-report').accordion({ header:'h3', autoHeight:false, collapsible:true, active:false });
});
</script>
<style>
.ui-widget { font-size:1em; }
.ui-state-active .ui-icon, .ui-state-default .ui-icon { float: left; margin-right: 10px; }
</style>

<?php
if ($update_autopositionnement == 'true') {
	echo '<div id="import-autopositionnement-report">';
	//echo '<hr /><p>Données de votre autopositionnement : ' . print_r($autopositionnement_data, true) . '</p><hr />';
	echo "<h3>Mise à jour de l'autopositionnement</h3>";
	echo '<div>';
	echo '<p>Les données du positionnement ont été mises à jour à partir des informations que vous avez fournies&nbsp;:</p>';
	echo '<p><em>Ancienne valeur => nouvelle valeur<em></p>';
	
	// Extraction et traitement des données d'autopositionnement récupérées
	$autopositionnement_data = unserialize($autopositionnement_data);
	foreach ($autopositionnement_data as $domaine => $competences) {
		foreach ($competences as $competence => $questions) {
			// Pour chacune des questions définies/sélectionnées
			$score_competence = 0;
			$valid_data = false;
			foreach ($questions as $i => $q) {
				if (@strlen($q) > 0) {
					$valid_data = true;
					$score_competence += $q;
				}
			}
			// $i étant positionné au dernier numéro de question, on peut faire simple : total/$i = score sur la compétence
			$score_competence = round($score_competence/$i);
			if ($valid_data) {
				echo "D$domaine.$competence&nbsp;: ";
				echo $vars['entity']->{$typedossier . '_' . $domaine . '_' . $competence . '_' . 'value_learner'};
				// Discrétisation des valeurs
				if ($score_competence < 30) $score_competence = 0;
				else if ($score_competence >= 65) $score_competence = 100;
				else $score_competence = 50;
				echo ' => ' . $score_competence . ' ';
				// Mise à jour effective du dossier de suivi : uniquement si on a des données valides
				$vars['entity']->{$typedossier . '_' . $domaine . '_' . $competence . '_' . 'value_learner'} = $score_competence;
				echo ' autopositionnement mis à jour';
				echo '<br />';
			}
		}
	}
	echo '</div>';
	echo '</div>';
	echo '<br />';
}



// Liste de valeur des sélecteurs
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
?>

<style>
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

<div id="dossierdepreuve_edit">
  <?php
  // Infos d'édition
  echo "<blockquote>Vous éditez ce dossier de preuve en tant que {$editor->name}, " . elgg_echo('profile:types:' . $profile_type) . " ($profile_type).</blockquote><br />";
  //if (!isset($vars['entity']) && ($owner_guid != elgg_get_logged_in_user_guid())) echo "Vous êtes en train de créer le dossier de " . $owner->name;
  
  // Le formulaire proprement dit
  echo '<form id="dossierdepreuve_'.$profile_type.'_edit" action="' . $vars['url'] . 'action/' . $action . '" enctype="multipart/form-data" method="post">';
  
  echo elgg_view('input/securitytoken');

  echo '<p><label for="dossierdepreuve_title">' . elgg_echo('dossierdepreuve:title') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:title:help') . elgg_view('input/text', array('name' => 'title', 'id' => 'dossierdepreuve_title', 'value' => $title)) . '</p>';
  
  echo '<p><label for="dossierdepreuve_status">' . elgg_echo('dossierdepreuve:status') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:status:help') . ' &nbsp; ' . elgg_view('input/dropdown', array('name' => 'status', 'id' => 'dossierdepreuve_status', 'value' => $status, 'options_values' => $status_values)) . '</p>';
  
  echo '<p><label for="dossierdepreuve_type">' . elgg_echo('dossierdepreuve:typedossier') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:typedossier:help') . ' &nbsp; ' . elgg_view('input/dropdown', array('name' => 'typedossier', 'id' => 'dossierdepreuve_type', 'value' => $typedossier, 'options_values' => $typedossier_values)) . '</p>';
  ?>
  
  <div class="clearfloat"></div>
  
  <?php
  echo '<p><label for="dossierdepreuve_description">' . elgg_echo('dossierdepreuve:description') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:description:help') . elgg_view('input/longtext', array('name' => 'description', 'id' => 'dossierdepreuve_description', 'value' => $description)) . '</p>';
  ?>
  <div class="clearfloat"></div>
  <?php
  /*
  De vues et des données différentes selon les profils :
  - apprenant : modification auto-évaluation
  - formateur : modification formation
  - évaluateur : modification formation + évaluation
  */
  // Référentiel
  $referentiel_b2iadultes = array(
  		'1' => array('1', '2', '3', '4'), 
  		'2' => array('1', '2', '3', '4'), 
  		'3' => array('1', '2', '3'), 
  		'4' => array('1', '2', '3', '4'), 
  		'5' => array('1', '2', '3'), 
		);
	echo '<h3>' . elgg_echo('dossierdepreuve:referentiel:b2i:title') . '</h3>';
	echo '<strong>' . elgg_echo('dossierdepreuve:referentiel:legende') . '</strong><br />';
	echo '<p>' . elgg_echo('dossierdepreuve:referentiel:legende:description') . '</p>';
	// Affichage du référentiel
	foreach ($referentiel_b2iadultes as $domaine => $competences) {
		echo '<h4>' . elgg_echo('dossierdepreuve:referentiel:' . $domaine) . '</h4>';
		foreach ($competences as $competence) {
			$meta_basename = $typedossier . '_' . $domaine . '_' . $competence . '_';
			echo '<a href="javascript:void(0);" style="float:right;" title="';
			// @TODO mettre un toggle à la place de l'infobulle
			echo str_replace('<br />', "\n", elgg_echo('dossierdepreuve:referentiel:' . $domaine . ':' . $competence . ':aide'));
			echo '">Aide</a>';
			echo '<h5>' . elgg_echo('dossierdepreuve:referentiel:' . $domaine . ':' . $competence) . ' : ';
			echo '<em>' . elgg_echo('dossierdepreuve:referentiel:' . $domaine . ':' . $competence . ':description') . '</em>';
			echo '</h5>';
			
			// Eléments de preuve : manuels + ceux cochés via les articles (et non modifiables ici mais juste un lien vers nouvelle fenêtre)
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
				//echo '<div>+ ' . count($blog_proofs) . ' fichier(s) et article(s) pour ' . $tag_name . ': ';
				foreach ($blog_proofs as $ent) {
					$proofs_auto_elements .= '<a href="' . $ent->getURL() . '" target="_new" style="background:transparent;" title="Nouvelle fenêtre. Pour retirer cet élément de preuve, modifiez l\'article ou le fichier en cliquant sur ce lien, et décochez la compétence ' . $tag_name . '.">' . $ent->title . '</a> &nbsp; ';
				}
			}
			
			echo '<div class="learner" style="float:left; width:62%;">';
			if (($profile_type == 'learner') || elgg_is_admin_logged_in()) {
				if (!empty($proofs_auto_elements)) $proofs_auto_elements = ' &nbsp; <span style="background:transparent; font-size:0.9em;">' . $proofs_auto_elements . '</span>';
				echo '<label for="' . $meta_basename . 'proof' . '">Eléments de preuve' . '</label>' . $proofs_auto_elements . elgg_view('input/plaintext', array('name' =>  $meta_basename . 'proof', 'id' =>  $meta_basename . 'proof', 'value' =>  $vars['entity']->{$meta_basename . 'proof'}, 'js' => ' style="height:6.4ex;"'));
			} else {
				echo '<strong>Eléments de preuve :</strong> &nbsp; ' . $proofs_auto_elements . elgg_view('output/longtext', array('value' =>  $vars['entity']->{$meta_basename . 'proof'}));
			}
			echo '</div>';
			
			echo '<div style="float:right; width:36%;">';
			switch ($profile_type) {
				
				// Seul l'auteur peut modifier les infos auto-évaluatives
				case 'learner':
					echo '<div class="learner" title="Auto-positionnement du candidat"><label>Auto-positionnement ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_learner', 'value' => $vars['entity']->{$meta_basename . 'value_learner'}, 'options_values' => $autopositionnement_values)) . '</label></div>';
					echo '<div class="tutor" title="Suivi par le formateur"><label>Suivi <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_tutor'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					echo '<div class="evaluator" title="Evaluation par l\'habilitateur"><label>Evaluation <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_evaluator'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					break;
					
				// Le formateur peut modifier les infos formatives
				case 'tutor':
					echo '<div class="learner" title="Auto-positionnement du candidat"><label>Auto-positionnement <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_learner'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					echo '<div class="tutor" title="Suivi par le formateur"><label>Suivi ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_tutor', 'value' => $vars['entity']->{$meta_basename . 'value_tutor'}, 'options_values' => $competence_values)) . '</label></div>';
					echo '<div class="evaluator" title="Evaluation par l\'habilitateur"><label>Evaluation <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_evaluator'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					break;
					
				// L'évaluateur peut modifier les infos formatives + évaluer le dossier
				case 'evaluator':
				echo '<div class="learner" title="Auto-positionnement du candidat"><label>Auto-positionnement <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_learner'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					echo '<div class="tutor" title="Suivi par le formateur"><label>Suivi ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_tutor', 'value' => $vars['entity']->{$meta_basename . 'value_tutor'}, 'options_values' => $competence_values)) . '</label></div>';
					echo '<div class="evaluator" title="Evaluation par l\'habilitateur"><label>Evaluation ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_evaluator', 'value' => $vars['entity']->{$meta_basename . 'value_evaluator'}, 'options_values' => $competence_values)) . '</label></div>';
					break;
					
				// L'admin peut modifier toutes les infos
				case 'admin':
					echo '<div class="learner" title="Auto-positionnement du candidat"><label>Auto-positionnement ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_learner', 'value' => $vars['entity']->{$meta_basename . 'value_learner'}, 'options_values' => $autopositionnement_values)) . '</label></div>';
					echo '<div class="tutor" title="Suivi par le formateur"><label>Suivi ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_tutor', 'value' => $vars['entity']->{$meta_basename . 'value_tutor'}, 'options_values' => $competence_values)) . '</label></div>';
					echo '<div class="evaluator" title="Evaluation par l\'habilitateur"><label>Evaluation ' . elgg_view('input/dropdown', array('name' => $meta_basename . 'value_evaluator', 'value' => $vars['entity']->{$meta_basename . 'value_evaluator'}, 'options_values' => $competence_values)) . '</label></div>';
					break;
					
				// Les autres ne peuvent rien modifier
				case 'other_administrative':
				default:
					echo '<div class="learner" title="Auto-positionnement du candidat"><label>Auto-positionnement <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_learner'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					echo '<div class="tutor" title="Suivi par le formateur"><label>Suivi <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_tutor'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
					echo '<div class="evaluator" title="Evaluation par l\'habilitateur"><label>Evaluation <input value="' . elgg_echo('dossierdepreuve:competence:'.$vars['entity']->{$meta_basename . 'value_evaluator'}) . '" style="width:20ex;" disabled="disabled" /></label></div>';
			}
			echo '</div>';
			echo '<div class="clearfloat"></div>';
			echo '<br />';
			
		}
	}
	
	
	// Access rights
	/*
	echo '<div class="clearfloat"></div>';
	echo '<p><label for="dossierdepreuve_access_id">' . elgg_echo('dossierdepreuve:readaccess') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'id' => 'dossierdepreuve_access_id', 'value' => $access_id)) . '</label></p>';
	*/

	// Hidden fields & submit
	echo '<div class="clearfloat"></div>';
	if (isset($vars['entity'])) echo '<input type="hidden" name="dossierdepreuve_guid" value="' . $vars['entity']->getGUID() . '" />';
	echo '<input type="hidden" name="owner_guid" value="' . $owner_guid . '" />';
	echo '<input type="hidden" name="container_guid" value="' . $container_guid . '" />';
	echo '<p>';
		echo elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:save"))) . '<br /><br />';
	echo '</p>';
	?>
	</form>
</div>

