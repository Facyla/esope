<?php
/**
 * Displays HTML, with new lines converted to line breaks
 *
 * @uses $vars['value'] HTML to display
 * @uses $vars['class']
 * @uses $vars['parse_urls'] Turn urls into links? Default is true.
 * @uses $vars['parse_emails'] Turn email addresses into mailto links? Default is true.
 * @uses $vars['sanitize'] Sanitize HTML? (highly recommended) Default is true.
 * @uses $vars['autop'] Convert line breaks to paragraphs? Default is true.
 */

// Note : keep in sync with original view, besides the plugin settings

$vars['class'] = elgg_extract_class($vars, 'elgg-output');

$text = elgg_extract('value', $vars);
unset($vars['value']);

// Use custom parser
// @TODO better operate at another level (eg. create/update event) so we don't compute all at every display
if (elgg_get_plugin_setting('convert_longtext', 'content_facets') == 'yes') {
	$facets = new ElggContentFacets($text);
	$params = [
		'url' => (elgg_get_plugin_setting('render_urls', 'content_facets') == 'yes' ? true : false),
		'mention' => (elgg_get_plugin_setting('render_mentions', 'content_facets') == 'yes' ? true : false),
		'hashtag' => (elgg_get_plugin_setting('render_hashtags', 'content_facets') == 'yes' ? true : false),
		'video' => (elgg_get_plugin_setting('render_videos', 'content_facets') == 'yes' ? true : false),
		'image' => (elgg_get_plugin_setting('render_images', 'content_facets') == 'yes' ? true : false),
		'preview' => (elgg_get_plugin_setting('render_url_previews', 'content_facets') == 'yes' ? true : false),
	];
	$text = $facets->renderConvertedText($params);
} else {
	$text = elgg_format_html($text, $vars);
}

if (empty($text)) {
	return;
}

unset($vars['parse_urls'], $vars['parse_emails'], $vars['sanitize'], $vars['autop']);

echo elgg_format_element('div', $vars, $text);

