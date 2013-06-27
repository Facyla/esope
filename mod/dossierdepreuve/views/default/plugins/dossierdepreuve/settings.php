<?php
/* Paramètres gestion de dossier de preuves
 * Pour chaque référentiel :
 * - version ?
 * - structure (domaines => compétences))
 * - liste des domaines, des compétences
 * - questions associées à chacune des compétences
 */

// Pool de questions B2i Adultes : ce serait bien d'automatiser tout ça... 
// sous forme d'objets ou de quelque chose d'un petit peu configurable au moins (settings..)
// Donc la liste ci-dessous doit être seulement une liste par défaut, réserve de contenus.
/*
Les questions doivent pouvoir être récupérées par domaine seulement, et par compétence, avec une ou plusieurs questions pour chaque.
Pour chaque compétence, on a les élements de compétence, les savoirs, et les critères qualitatifs et/ou quantitatifs de mesure, soit : elements, savoirs, criteres
*/

$url = $vars['url'];

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

// Liste des types de dossiers
$referentiels_radio = array(
		"B2i Adultes" => 'b2iadultes',
		/*
		'B2i' => "b2i",
		"Pass'Numérique" => 'passnumrra',
		*/
	);
/*
// Liste des valeurs des sélecteurs candidat (autopositionnement) et formateur/habilitateur (évaluation)
$autopositionnement_values = array(
		'' => elgg_echo ('dossierdepreuve:autopositionnement:'),
		'100' => elgg_echo ('dossierdepreuve:autopositionnement:100'),
		'50' => elgg_echo ('dossierdepreuve:autopositionnement:50'),
		'0' => elgg_echo ('dossierdepreuve:autopositionnement:0'),
	);
$competence_values = array(
		'' => elgg_echo ('dossierdepreuve:choose'),
		'100' => elgg_echo ('dossierdepreuve:competence:100'),
		'50' => elgg_echo ('dossierdepreuve:competence:50'),
		'0' => elgg_echo ('dossierdepreuve:competence:0'),
	);
*/



// SET DEFAULT VALUES
/*
if (strlen($vars['entity']->displaystats) == 0) { $vars['entity']->displaystats = 'no'; }
if (!isset($vars['entity']->footer) || ($vars['entity']->footer == 'RAZ')) {}
*/

// Dossier par défaut : B2i Adultes
if (empty($vars['entity']->referentiels)) { $vars['entity']->referentiels = 'b2iadultes'; }
// Référentiel B2i Adultes
if (empty($vars['entity']->referentiel_b2iadultes)) {
	// string = domaine1:comp1,comp2;domaine1:comp1, etc.
	/*
	$vars['entity']->referentiel_b2iadultes = array(
			'1' => array('1', '2', '3', '4'), 
			'2' => array('1', '2', '3', '4'), 
			'3' => array('1', '2', '3'), 
			'4' => array('1', '2', '3', '4'), 
			'5' => array('1', '2', '3'), 
		);
	*/
	$vars['entity']->referentiel_b2iadultes = '1,2,3,4;1,2,3,4;1,2,3;1,2,3,4;1,2,3';
}

if (empty($vars['entity']->threshold_low)) $vars['entity']->threshold_low = 30;
if (empty($vars['entity']->threshold_high)) $vars['entity']->threshold_high = 65;
if (empty($vars['entity']->threshold_validation)) $vars['entity']->threshold_validation = 50;


// Calcul du référentiel sous forme d'array
$referentiel_b2iadultes_domaines = explode(';', $vars['entity']->referentiel_b2iadultes);
foreach ($referentiel_b2iadultes_domaines as $k => $domaine) {
	$referentiel_b2iadultes_competences = explode(',', $domaine);
	$referentiel_b2iadultes[$k] = $referentiel_b2iadultes_competences;
}
?>

<script type="text/javascript">
$(function() {
	$('#settings-accordion').accordion({ header: 'h3', autoHeight: false });
});
</script>

<div id="settings-accordion">
	<p><?php echo elgg_echo('dossierdepreuve:settings'); ?></p>

		<?php /*
		<p><label><?php echo elgg_echo('dossierdepreuve:settings:redirect'); ?></label><br />
		  <?php echo $url . elgg_view('input/text', array( 'name' => 'params[redirect]', 'value' => $vars['entity']->redirect, 'js' => 'style="width:50%;"' )); ?>
		</p>
		<p><label><?php echo elgg_echo('dossierdepreuve:home:displaystats'); ?></label>
		  <?php echo elgg_view('input/dropdown', array( 'name' => 'params[displaystats]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->displaystats )); ?>
		</p>
		  <p><label><?php echo elgg_echo('dossierdepreuve:dashboardheader'); ?></label>
		    <?php echo elgg_view('input/longtext', array( 'name' => 'params[dashboardheader]', 'value' => $vars['entity']->dashboardheader )); ?>
		  </p><br />
		<p><label><?php echo elgg_echo('dossierdepreuve:settings:publicpages'); ?></label><br />
		  <?php echo elgg_echo('dossierdepreuve:settings:publicpages:help'); ?>
		  <?php // un nom de pages par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
		  echo elgg_view('input/plaintext', array( 'name' => 'params[publicpages]', 'value' => $vars['entity']->publicpages ));
		  ?>
		</p>
		<p><label><?php echo elgg_echo('dossierdepreuve:color13:color'); ?></label>
		  <?php echo elgg_view('input/color', array( 'name' => 'params[color13]', 'value' => $vars['entity']->color13 )); ?>
		</p>
		*/
		?>
	
	
	<br />
	<?php // Pour une liste à la volée : un nom de référentiel par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
	// Type de questionnaire :radio (choix obligatoire)
	echo '<p><label for="dossierdepreuve_referentiels">' . elgg_echo('dossierdepreuve:settings:referentiels') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:settings:referentiels:help') . elgg_view('input/radio', array('name' => 'referentiels', 'id' => 'dossierdepreuve_referentiels', 'options' => $referentiels_radio, 'value' => $vars['entity']->referentiels)) . '</p>';
	?>
	<br />
	
	
	<?php
	// Note : l'array servira si on veut définir plusieurs référentiels, pour le moment, plus simple avec un seul
	// if (!empty($vars['entity']->referentiels)) foreach ($vars['entity']->referentiels as $referentiel) {
	if (!empty($vars['entity']->referentiels)) {
		?>
		<h3>REFERENTIEL B2i Adultes</h3>
		<div>
			<p>Pour éditer les questions et critères du référentiel :<br />
				une question / réponse / critère par ligne.<br />
				Utiliser des &lt;br&gt; en HTML pour les retours à la ligne dans une même question.<br />
				Pour réinitialiser, vider le contenu.</p>
			
			<?php
			echo '<p><label for="dossierdepreuve_referentiel_b2iadultes">' . elgg_echo('dossierdepreuve:settings:referentiel:b2iadultes') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:settings:referentiel:b2iadultes:help') . elgg_view('input/plaintext', array( 'name' => 'params[referentiel_b2iadultes]', 'value' => $vars['entity']->referentiel_b2iadultes )) . '</p>';
			
			echo '<h4>' . elgg_echo('dossierdepreuve:settings:thresholds') . '</h4>';
			echo elgg_echo('dossierdepreuve:settings:thresholds:help') . '<br />';
			echo 	'<p><label>' . elgg_echo('dossierdepreuve:settings:threshold_low') . '</label>' . elgg_view('input/text', array( 'name' => 'params[threshold_low]', 'value' => $vars['entity']->threshold_low, 'js' => 'style="width:50%;"' )) . '</p>';
			echo 	'<p><label>' . elgg_echo('dossierdepreuve:settings:threshold_high') . '</label>' . elgg_view('input/text', array( 'name' => 'params[threshold_high]', 'value' => $vars['entity']->threshold_high, 'js' => 'style="width:50%;"' )) . '</p>';
			echo 	'<p><label>' . elgg_echo('dossierdepreuve:settings:threshold_validation') . '</label>' . elgg_view('input/text', array( 'name' => 'params[threshold_validation]', 'value' => $vars['entity']->threshold_validation, 'js' => 'style="width:50%;"' )) . '</p>';
			
		echo '</div>';
		
		// Parcours du référentiels
		// Affichage du référentiel (attention décalage de 1 pour les domaines)
		foreach ($referentiel_b2iadultes as $k => $competences) {
			$domaine = $k + 1;
			$domaine_basename = 'dossierdepreuve:referentiel:' . $domaine;
			// Un onglet par domaine sinon c'est illisible...
			echo '<h3>' . elgg_echo($domaine_basename) . '</h3><div>';
			foreach ($competences as $competence) {
				$competence_basename = $domaine_basename . ':' . $competence;
				$basename = $vars['entity']->referentiels . ':' . $domaine . ':' . $competence . ':';
				$property_basename = str_replace(':', '_', $basename);
				
				// Valeurs par défaut
				if (empty($vars['entity']->{$property_basename  . 'elements'})) 
					$vars['entity']->{$property_basename  . 'elements'} = str_replace('	', '', elgg_echo($basename . 'elements'));
				if (empty($vars['entity']->{$property_basename  . 'savoirs'})) 
					$vars['entity']->{$property_basename  . 'savoirs'} = str_replace('	', '', elgg_echo($basename . 'savoirs'));
				if (empty($vars['entity']->{$property_basename  . 'criteres'})) 
					$vars['entity']->{$property_basename  . 'criteres'} = str_replace('	', '', elgg_echo($basename . 'criteres'));
				
				// Edition des valeurs : une question par ligne (multiligne avec des <br />)
				$textfields_style = ' style="font-size: 10px;"';
				$label_style = ' style="font-size: 12px;"';
				echo '<h4>' . elgg_echo($competence_basename) . '</h4>';
				// Description de la compétence et Aide générale
				echo '<div style="float:left; width:28%; font-size:10px;"><label '.$label_style.'>Description :</label> ' . elgg_echo($competence_basename . ':description') . '</div>';
				echo '<div style="float:right; width:70%; font-size:10px;"><label>Aide :</label> ' . str_replace(array('<br />', '<br>', '\n'), ' &nbsp; ', elgg_echo($competence_basename . ':aide')) . '</div>';
				echo '<div class="clearfloat"></div>';
				
				// Eléments de compétence et Savoirs = Questions pour l'autopositionnement
				echo '<div style="float:left; width:38%;"><label '.$label_style.'>Eléments ' . elgg_view('input/plaintext', array('name' => 'params[' . $property_basename  . 'elements]', 'value' => $vars['entity']->{$property_basename  . 'elements'}, 'js' => $textfields_style)) . '</label></div>';
				echo '<div style="float:right; width:60%;"><label '.$label_style.'>Savoirs (Je sais...) ' . elgg_view('input/plaintext', array('name' => 'params[' . $property_basename  . 'savoirs]', 'value' => $vars['entity']->{$property_basename  . 'savoirs'}, 'js' => $textfields_style)) . '</label></div>';
				echo '<div class="clearfloat"></div>';
				
				// Critères d'évaluation associés aux éléments de compétence et Aide Visuelle des savoirs/questions d'autopositionnement
				echo '<div style="float:left; width:38%;"><label '.$label_style.'>Critères ' . elgg_view('input/plaintext', array('name' => 'params[' . $property_basename  . 'criteres]', 'value' => $vars['entity']->{$property_basename  . 'criteres'}, 'js' => $textfields_style)) . '</label></div>';
				echo '<div style="float:right; width:60%;"><label '.$label_style.' title="Coller ici le ou les codes embed de la vidéo LSF (HTML ou texte simple possibles aussi). ATTENTION : un seul par ligne !">Aide visuelle (embed)&nbsp;: ' . elgg_view('input/plaintext', array('name' => 'params[' . $property_basename  . 'visualhelp]', 'value' => $vars['entity']->{$property_basename  . 'visualhelp'}, 'js' => $textfields_style)) . '</label></div>';
				echo '<div class="clearfloat"></div>';
				echo '<br />';
			}
			echo '</div>';
		}
		
	}
	echo '<br />';
	?>
	
	<br />
	<br />
	
</div>

