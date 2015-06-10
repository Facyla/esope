<?php
if (elgg_instanceof($vars['entity'], 'object', 'dossierdepreuve')) {
	// Mini-vue graphique
	$picto = '';
	// Référentiel
	$referentiel_b2iadultes = array(
			'1' => array('1', '2', '3', '4'), 
			'2' => array('1', '2', '3', '4'), 
			'3' => array('1', '2', '3'), 
			'4' => array('1', '2', '3', '4'), 
			'5' => array('1', '2', '3'), 
		);
	// Affichage du référentiel

	$picto .= '<div style="float:left; border:1px solid #000; border-right:0; border-bottom:0; background:#000;">';
	foreach (array('learner', 'tutor', 'evaluator') as $profiletype) {
		$picto .= '<div style="float:left; clear:left; margin-bottom:1px;" title="'.$profiletype.'">';
		foreach ($referentiel_b2iadultes as $domaine => $competences) {
			$picto .= '<div style="float:left; margin-right:1px;" title="Domaine ' . $domaine . '">';
			foreach ($competences as $competence) {
				$meta_basename = 'b2iadultes_' . $domaine . '_' . $competence . '_value_' . $profiletype;
				$val = (int) $vars['entity']->$meta_basename;
				$green = intval(255 * ($val / 100)); // Il faut avoir un entier car la CSS rgba supporte mal un float
				$red = 255 - $green;
				$picto .= '<div style="float:left; height:6px; width:6px; border-right:1px solid rgba(255,255,255,0.5); background-color:rgba('.$red.', '.$green.', 0, 1);" title="Compétence D1-'.$competence.' : acquis à '.$val.'%"></div>';
			}
			$picto .= '</div>';
		}
		$picto .= '</div>';
	}
	$picto .= '<div class="clearfloat"></div>';
	$picto .= '</div>';
	
	echo $picto;
}

