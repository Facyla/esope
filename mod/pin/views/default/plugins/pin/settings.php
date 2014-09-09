<?php
// Note : no value means "no" setting
$yesno_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

// Exemple de liste valide
$validlist = '';
$validentities = get_registered_entity_types('object');
foreach($validentities as $type) { $validlist .= $type.','; }


// Paramètres du plugin
echo '<p><strong><em>' . elgg_echo('pin:settings') . '</em></strong>/p>';

if (!isset($vars['entity']->extendfullonly)) $vars['entity']->extendfullonly = 'yes';
echo '<p><label>' . elgg_echo('pin:settings:extendfullonly')
	. elgg_view('input/pulldown', array( 'name' => 'params[extendfullonly]', 'value' => $vars['entity']->extendfullonly, 'options_values' => $yesno_opt ))
	. '</label><br />' . elgg_echo('pin:settings:extendfullonly:help')
	. '</p>';


echo '<p><label>' . elgg_echo('pin:settings:highlight')
	. elgg_view('input/pulldown', array( 'name' => 'params[highlight]', 'value' => $vars['entity']->highlight, 'options_values' => $yesno_opt ))
	. '</label></p>';

echo '<p><label>' . elgg_echo('pin:settings:validhighlight') 
	. elgg_view('input/text', array( 'name' => 'params[validhighlight]', 'value' => $vars['entity']->validhighlight ))
	. '</label><br />' . $validlist . '</p>';


