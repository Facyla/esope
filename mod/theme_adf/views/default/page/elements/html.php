<?php
/**
 * Page shell for all HTML pages
 *
 * @uses $vars['html_attrs'] Attributes of the <html> tag
 * @uses $vars['head']       Parameters for the <head> element
 * @uses $vars['body_attrs'] Attributes of the <body> tag
 * @uses $vars['body']       The main content of the page
 */
// Set the content type
elgg_set_http_header("Content-type: text/html; charset=UTF-8");

$lang = get_current_language();

$default_html_attrs = [
	'xmlns' => 'http://www.w3.org/1999/xhtml',
	'xml:lang' => $lang,
	'lang' => $lang,
];
$html_attrs = elgg_extract('html_attrs', $vars, []);
$html_attrs = array_merge($default_html_attrs, $html_attrs);

$body_attrs = elgg_extract('body_attrs', $vars, []);

// ESOPE : Add context class, for page differenciation
$class = 'elgg-public';
if (elgg_is_logged_in()) { $class = 'elgg-loggedin'; }
foreach (elgg_get_context_stack() as $context) { $class .= ' elgg-context-' . str_replace(['/', '_', ' '], '-', $context); }
// Add page owner type
$owner = elgg_get_page_owner_entity();
if ($owner instanceof ElggEntity) {
	$class .= ' elgg-owner-' . str_replace(['/', '_', ' '], '-', $owner->getType());
}
$body_attrs['class'] .= " $class";

?>
<!DOCTYPE html>
<?php

$head = elgg_format_element('head', [], elgg_extract('head', $vars, ''));
$body = elgg_format_element('body', $body_attrs, elgg_extract('body', $vars, ''));

echo elgg_format_element('html', $html_attrs, $head . $body);
