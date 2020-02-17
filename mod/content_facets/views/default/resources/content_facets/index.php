<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

$title = elgg_echo('content_facets:title');

elgg_push_breadcrumb(elgg_echo('content_facets'), 'content_facets');
elgg_push_breadcrumb($title);


$sidebar = "";

$content = '';

$guids = [169, 181, 182];

foreach($guids as $guid) {
	$entity = get_entity($guid);
	//$content .= elgg_view_entity($entity) . '<hr />';
	//$content .= print_r($test, true) . '<hr />';
	
	$text = $entity->description;

	// Rich content extraction
	$facets = new ElggContentFacets($text);
	// All links
	$sorted_links = $facets->getUrls();
	// Elgg (internal) links
	$elgg_links = $facets->getInternalLinks();
	// External links
	$external_links = $facets->getExternalLinks();
	// Images
	$elgg_links = $facets->getImages();
	// Emails
	$emails = $facets->getEmails();
	// Tags
	$hashtags = $facets->getHashtags();
	// Mentions
	$mentions = $facets->getMentions();
	
	
	// Parse # and @
	//$text .= "<hr>NC parse : " . naturalconnect_parse_hashtags_usernames($text);

	// Parse remaining URLs (not embedded)
	//$text .= "<hr>Elgg parse_urls : " . parse_urls($text);
	
	// Content facets parser
	//$text .= "<hr>CF render: " . $facets->renderConvertedText();
	$text = $facets->renderConvertedText();
	
	// Tags
	//if ($hashtags) { $text .= '<p>Tags&nbsp;: #' . implode(' #', $hashtags). '</p>'; }
	
	// Mentions
	//if ($mentions) { $text .= '<p>Mentions&nbsp;: @' . implode(' @', $mentions). '</p>'; }
	// Vidéos
	
	
	
	
	//$content .= "GUID $guid => " . print_r($external_links, true);

	// @TODO convert non-video links to embedded content
	// @TODO add transparent layer on top of iframe to avoid clicks on uncrontrolled external resources
	/*
	$text .= $link . '<br />';
	$link = str_replace(['http://', 'https://'], '//', $link);
	$text .= $link . '<br />';
	$text .= '<div class="iframe-preview" style="width: 10rem; height:8rem;">';
		$text .= '<div class="iframe-preview-overlay"></div>';
		$text .= '<iframe src="' . $link . '" style=""></iframe>';
	$text .= '</div>';
	*/
	
	
	$content .= $text;
}


//$content .= elgg_view('output/longtext', ['value' => $text]) . '<hr />';


// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

