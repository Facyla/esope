<?php
/**
 * tags input view
 *
 * @package Elggtags
 *
 * @uses $vars['entity'] The entity being edited or created
 */

// Référentiel
// checkboxes want Label => value, so in our case we need tag_label => tag
$referentiel = array(
		elgg_echo('dossierdepreuve:referentiel:1') . ' : ' . elgg_echo('dossierdepreuve:referentiel:1:description') => 'D1', 
		elgg_echo('dossierdepreuve:referentiel:2') . ' : ' . elgg_echo('dossierdepreuve:referentiel:2:description') => 'D2', 
		elgg_echo('dossierdepreuve:referentiel:3') . ' : ' . elgg_echo('dossierdepreuve:referentiel:3:description') => 'D3', 
		elgg_echo('dossierdepreuve:referentiel:4') . ' : ' . elgg_echo('dossierdepreuve:referentiel:4:description') => 'D4', 
		elgg_echo('dossierdepreuve:referentiel:5') . ' : ' . elgg_echo('dossierdepreuve:referentiel:5:description') => 'D5', 
	);

if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
	$selected_tags = $vars['entity']->referentiel_tags;
}


if (empty($selected_tags)) {
	$selected_tags = array();
}

if (!empty($referentiel)) {
	?>
	<div class="referentiel">
		<label><?php echo elgg_echo('dossierdepreuve:referentiel:domaine'); ?></label><br />
		<?php
			echo elgg_view('input/checkboxes', array(
				'options' => $referentiel,
				'value' => $selected_tags,
				'name' => 'referentiel_tags',
				'align' => 'vertical',
			));
		?>
	</div>
	<?php
}

