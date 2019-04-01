<?php
/**
 * Update subtypes
 *
 * @package ElggPages
 */


// Pour autoriser les modifications, veuillez modifier la valeur par "true". Une fois les modificaitons terminées, veuillez remettre à "false""
$allow = false;

admin_gatekeeper();

$title = "Mise à jour des subtypes";
$content = '';
$sidebar = '';

$type_opt = ['site' => 'site', 'group' => 'group', 'user' => 'user', 'object' => 'object'];


// Perform actual updates : requires code edit to perform changes
if ($allow) {
	$type = get_input('type');
	$subtype = get_input('subtype');
	$class = get_input('class');
	if (in_array($type, $type_opt)) {
		//if (is_registered_entity_type($type, $subtype)) {
		//get_subtype_class
		if (!empty($class)) {
			update_subtype($type, $subtype, $class);
		} else {
			update_subtype($type, $subtype);
		}
	} else {
		register_error("Type d'entité invalide.");
	}
} else {
	register_error("Pour mettre à jour un subtype, veuillez modifier le fichier et autoriser temporairement les modifications.");
	$content .= '<blockquote>' . "Pour mettre à jour un subtype, veuillez modifier le fichier et autoriser temporairement les modifications." . '</blockquote>';
}




// Update subtype form
$content .= '<form>
	<label>Type d\'entité ' . elgg_view('input/select', array('name' => "type", 'value' => $type, 'options_values' => $type_opt)) . '</label>
	<label>Sous-type ' . elgg_view('input/text', array('name' => 'subtype', 'value' => $class, 'style' => "max-width:20ex;")) . '</label>
	<label>Classe ' . elgg_view('input/text', array('name' => 'class', 'value' => $class, 'style' => "max-width:20ex;")) . '</label>
	<input type="submit" value="Mettre à jour le type d\'entité" class="elgg-button elgg-button-submit" />
	</form>';
$content .= '<div class="clearfloat"></div><br /><br />';


// Liste known entities types / subtypes
$registered = get_registered_entity_types();
$content .= '<table style="width:100%;">';
$content .= '<thead><tr><th>Type</th><th>Subtype</th><th>Class</th></tr></thead>';
$content .= '<tbody>';
foreach ($registered as $t => $t_a) {
	$content .= '<tr><th colspan="3">' . $t . '</th></tr>';
	if ($t_a) {
		foreach ($t_a as $i => $st) {
			$content .= '<tr><td>' . $t . '</td><td>' . $st . '</td><td>' . get_subtype_class($t, $st) . '</td></tr>';
		}
	} else {
		$content .= '<tr><td>' . $t . '</td><td></td><td></td></tr>';
	}
}
$content .= '</tbody>';
$content .= '</table>';



$params = array(
		'content' => '<div class="elgg-output">' . $content . '</div>',
		'title' => $title,
		'sidebar' => $sidebar,
	);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


