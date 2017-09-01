<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

gatekeeper();

// Liste manuelle.. ou metadata spécifique ?
$own = elgg_get_logged_in_user_entity();
/*
if (elgg_is_admin_logged_in() || in_array($own->username, explode(',', elgg_get_plugin_setting('animators', 'theme_inria'))) ) {
} else {
	forward();
	register_error(elgg_echo('error:noaccess'));
}
*/

$content = '';
$sidebar = '';

// Composition de la page
$content .= '<div id="twitter-url-generator" class="">';
$content .= "<p>Cette page vous permet de générer des liens de partage sur Twitter.</p>";
$content .= '<div class="clearfloat"></div><br />';


// Compose share link
// See https://dev.twitter.com/docs/intents#tweet-intent
//$img = '<img src="' . $imgurl . 'twitter/bird_blue_32.png" alt="Twitter" />';
$share_url = get_input('url', '');
$share_tags = get_input('tags', array('inria'));
$share_via = get_input('via', 'inria');
$share_text = get_input('text', '');
//$share_title = get_input('title', '');
//$share_label = get_input('label', 'Partager sur Twitter');

// Build share link
$share_label = $share_text;
if (!empty($share_url)) { $share_label .= ' ' . str_replace(array('http://', 'https://'), '', $share_url); }
if (!empty($share_tags)) { $share_label .= ' #' . implode(' #', (array)$share_tags); }
if (!empty($share_via)) { $share_label .= ' via @' . implode(' @', (array)$share_via); }

$share_params = array();
if (!empty($share_text)) { $share_params[] = "text=$share_text"; }
if (!empty($share_tags)) { $share_params[] = "hashtags=" . implode(',', (array)$share_tags); }
if (!empty($share_via)) { $share_params[] = "via=$share_via"; }
if (!empty($share_url)) { $share_params[] = "url=$share_url"; }
$share_href = 'https://twitter.com/intent/tweet?' . implode('&', $share_params);

$share_link = '<span class="inria-twitter-intent"><a target="_blank" href="' . $share_href . '"';
if (!empty($share_title)) { $share_link .= ' title="' . $share_title . '"'; }
$share_link .= '>' . $share_label . '</a>';
$share_link .= '<br /><a class="inria-twitter-intent-click" target="_blank" href="' . $share_href . '">' . elgg_echo('theme_inria:clicktotweet') . '</a></span>';


// Compose form
$content .= '<h3>Eléments pour construire le lien de partage</h3>';
$content .= '<form method="POST">';
$content .= '<p><em>Note&nbsp;: tous les champs sont facultatifs</em></p>';
$content .= '<p><label>URL à partager ' . elgg_view('input/url', array('name' => 'url', 'value' => $share_url, 'placeholder' => "http://...")) . '</label></p>';
$content .= '<p><label>Message ' . elgg_view('input/text', array('name' => 'text', 'value' => $share_text, 'placeholder' => "Texte du tweet")) . '</label></p>';
$content .= '<p><label>Hashtags (sans le #), ex. tag1, tag2 ' . elgg_view('input/tags', array('name' => 'tags', 'value' => $share_tags, 'placeholder' => "tag1, tag2, tag3")) . '</label></p>';
$content .= '<p><label>Via (nom du compte sans le @) ' . elgg_view('input/text', array('name' => 'via', 'value' => $share_via)) . '</label></p>';
/*
$content .= '<p><label>Titre du lien ' . elgg_view('input/text', array('name' => 'title', 'value' => $share_title, 'placeholder' => "Texte de l'infobulle affichée au survol du lien")) . '</label></p>';
$content .= '<p><label>Texte du lien de partage ' . elgg_view('input/text', array('name' => 'label', 'value' => $share_label)) . '</label></p>';
*/
$content .= '<p>' . elgg_view('input/submit', array('value' => 'Créer le lien de partage')) . '</p>';
$content .= '</form>';
$content .= '<div class="clearfloat"></div><br />';


$content .= '<h3>Lien de partage</h3>';
$content .= '<p>' . $share_link . '</p>';
$content .= 'Code à copier-coller pour insérer le lien de partage&nbsp;: <textarea readonly>' . htmlentities($share_link) . '</textarea>';
$content .= '<div class="clearfloat"></div><br />';




$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));

// Affichage
echo elgg_view_page($title, $body);

