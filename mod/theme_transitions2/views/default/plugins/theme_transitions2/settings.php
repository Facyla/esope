<?php
$url = elgg_get_site_url();

// Define dropdown options
//$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Define Site menus replacement ?
$menus_options = elgg_menus_menus_opts();

//echo "Choose custom site menus";
echo "<h3>Choisissez les menus du site</h3>";

/*
echo '<p><label>Topbar menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_topbar]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_topbar)) . '</label></p>';

echo '<p><label>Page menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_page]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_page)) . '</label></p>';
*/

echo '<p><label>Site menu (main navigation) ' . elgg_view('input/dropdown', array('name' => 'params[menu_site]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_site)) . '</label> &nbsp; ';
echo '<a href="' . elgg_get_site_url() . 'admin/appearance/menus?menu_name=' . $vars['entity']->menu_site . '" target="_blank" class="elgg-button elgg-button-action">Editer le menu ' . $vars['entity']->menu_site . '</a></p>';

echo '<p><label>Footer menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_footer]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_footer)) . '</label> &nbsp; ';
echo '<a href="' . elgg_get_site_url() . 'admin/appearance/menus?menu_name=' . $vars['entity']->menu_footer . '" target="_blank" class="elgg-button elgg-button-action">Editer le menu ' . $vars['entity']->menu_footer . '</a></p>';

echo "<h3>Liste des administrateurs contenus</h3>";
echo elgg_list_entities(array(), 'theme_transitions_get_content_admins');

echo "<h3>Liste des administrateurs platforme</h3>";
echo elgg_list_entities(array(), 'theme_transitions_get_content_admins');

echo "<h3>Liste des administrateurs globaux</h3>";
echo elgg_list_entities(array(), 'elgg_get_admins');

echo '<div class="clearfloat"></div>';

// Example yes/no setting
//echo '<p><label>Test select setting "setting_name"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->setting_name)) . '</p>';


// Example text setting
//echo '<p><label>Text setting "setting_name2"</label> ' . elgg_view('input/text', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</p>';

// Example text setting
/*
for ($i=1; $i<5; $i++) {
	echo '<p><label>Accueil bloc ' . $i . '</label> ' . elgg_view('input/text', array('name' => 'params[home_text_'.$i.']', 'value' => $vars['entity']->{'home_text_'.$i})) . '</p>';
	echo '<p><label>Image ' . $i . '</label> ' . elgg_view('input/text', array('name' => 'params[home_image_'.$i.']', 'value' => $vars['entity']->{'home_image_'.$i})) . '</p>';
	echo '<p><label>Lien ' . $i . '</label> ' . elgg_view('input/text', array('name' => 'params[home_link_'.$i.']', 'value' => $vars['entity']->{'home_link_'.$i})) . '</p>';
}
*/


