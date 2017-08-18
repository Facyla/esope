<?php
/**
 * Elgg long text input
 * Displays a long text input field that can use WYSIWYG editor
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['value']    The current value, if any - will be html encoded
 * @uses $vars['disabled'] Is the input field disabled?
 * @uses $vars['class']    Additional CSS class
 */

/* Notes Esope : éditeurs de texte :
 * Pour démarrer sans l'éditeur :
 *  - appeler input/longtext avec la propriété data-cke-init => true
 * 
 * Pour utiliser différentes configs lors de l'activation manuelle de l'éditeur :
 *  - les définir dans js/elgg/ckeditor/config.js.php : toolbar_basic: [...] où 'basic' est le nom (libre) de la toolbar
 *  - puis les associer aux classes CSS dans le toggle de js/elgg/ckeditor.js
 * Note : marche bien si on démarre sans l'éditeur, mais ne charge pas le bon éditeur au démarrage automatique
 * 
 * Pour utiliser les configs au démarrage automatique de l'éditeur : dans ckeditor/init
 *  - ajouter un désélecteur pour ne pas charger l'éditeur par défaut
 *  - puis charger la bonne config d'éditeur selon la classe CSS (l'objet de config doit être cloné sans référence)
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-longtext';

$defaults = array(
	'value' => '',
	'rows' => '10',
	'cols' => '50',
	//'id' => 'elgg-input-' . rand(), //@todo make this more robust
	'id' => 'elgg-input-' . esope_unique_id(''), // Esope : this is more robust !
);

$vars = array_merge($defaults, $vars);

$value = htmlspecialchars($vars['value'], ENT_QUOTES, 'UTF-8');
unset($vars['value']);

echo elgg_view_menu('longtext', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
	'id' => $vars['id'],
));

echo elgg_format_element('textarea', $vars, $value);
