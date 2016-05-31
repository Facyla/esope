<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );


echo '<p><label>Sujets du moment ' . elgg_view('input/text', array('name' => 'params[featured_categories]', 'value' => $vars['entity']->featured_categories)) . '</label><br /><em>Les sujets du moment sont une liste de catégories actives en ce moment. Ces sujets doivent être également ajoutés à la liste des Catégories : <a href="' . $url . 'admin/plugin_settings/categories" target="_blank">cliquez ici pour mettre à jour la liste des Catégories</a>.</em></p>';



