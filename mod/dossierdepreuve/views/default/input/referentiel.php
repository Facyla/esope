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
		elgg_echo('dossierdepreuve:referentiel:1:1') . ' : ' . elgg_echo('dossierdepreuve:referentiel:1:1:description') => 'D1.1', 
		elgg_echo('dossierdepreuve:referentiel:1:2') . ' : ' . elgg_echo('dossierdepreuve:referentiel:1:2:description') => 'D1.2', 
		elgg_echo('dossierdepreuve:referentiel:1:3') . ' : ' . elgg_echo('dossierdepreuve:referentiel:1:3:description') => 'D1.3', 
		elgg_echo('dossierdepreuve:referentiel:1:4') . ' : ' . elgg_echo('dossierdepreuve:referentiel:1:4:description') => 'D1.4', 
		elgg_echo('dossierdepreuve:referentiel:2:1') . ' : ' . elgg_echo('dossierdepreuve:referentiel:2:1:description') => 'D2.1', 
		elgg_echo('dossierdepreuve:referentiel:2:2') . ' : ' . elgg_echo('dossierdepreuve:referentiel:2:2:description') => 'D2.2', 
		elgg_echo('dossierdepreuve:referentiel:2:3') . ' : ' . elgg_echo('dossierdepreuve:referentiel:2:3:description') => 'D2.3', 
		elgg_echo('dossierdepreuve:referentiel:2:4') . ' : ' . elgg_echo('dossierdepreuve:referentiel:2:4:description') => 'D2.4', 
		elgg_echo('dossierdepreuve:referentiel:3:1') . ' : ' . elgg_echo('dossierdepreuve:referentiel:3:1:description') => 'D3.1', 
		elgg_echo('dossierdepreuve:referentiel:3:2') . ' : ' . elgg_echo('dossierdepreuve:referentiel:3:2:description') => 'D3.2', 
		elgg_echo('dossierdepreuve:referentiel:3:3') . ' : ' . elgg_echo('dossierdepreuve:referentiel:3:3:description') => 'D3.3', 
		elgg_echo('dossierdepreuve:referentiel:4:1') . ' : ' . elgg_echo('dossierdepreuve:referentiel:4:1:description') => 'D4.1', 
		elgg_echo('dossierdepreuve:referentiel:4:2') . ' : ' . elgg_echo('dossierdepreuve:referentiel:4:2:description') => 'D4.2', 
		elgg_echo('dossierdepreuve:referentiel:4:3') . ' : ' . elgg_echo('dossierdepreuve:referentiel:4:3:description') => 'D4.3', 
		elgg_echo('dossierdepreuve:referentiel:4:4') . ' : ' . elgg_echo('dossierdepreuve:referentiel:4:4:description') => 'D4.4', 
		elgg_echo('dossierdepreuve:referentiel:5:1') . ' : ' . elgg_echo('dossierdepreuve:referentiel:5:1:description') => 'D5.1', 
		elgg_echo('dossierdepreuve:referentiel:5:2') . ' : ' . elgg_echo('dossierdepreuve:referentiel:5:2:description') => 'D5.2', 
		elgg_echo('dossierdepreuve:referentiel:5:3') . ' : ' . elgg_echo('dossierdepreuve:referentiel:5:3:description') => 'D5.3', 
	);

if (isset($vars['entity']) && $vars['entity'] instanceof ElggEntity) {
	$selected_tags = $vars['entity']->referentiel_tags;
} else {
	$selected_tags = $vars['referentiel_tags'];
}

if (empty($selected_tags)) {
	$selected_tags = array();
}

if (!empty($referentiel)) {
	?>
	<div class="referentiel">
		<label><?php echo elgg_echo('dossierdepreuve:referentiel'); ?></label><br />
		<p><em><?php echo elgg_echo('dossierdepreuve:referentiel:selecthelp'); ?></em></p>
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

