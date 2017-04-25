<?php
/*
 * @uses $vars['value'] The text to display
 * @uses $vars['parse_urls'] Whether to turn urls into links. Default is true.
 * @uses $vars['class']
 */

$context = elgg_get_context();

elgg_load_library('elgg:content_facets');
elgg_load_library('elgg:content_facets:vendors');
/*
elgg_load_library('elgg:content_facets:essence');
elgg_load_library('elgg:content_facets:multiplayer');
*/

$Essence = new Essence\Essence();
$Multiplayer = new Multiplayer\Multiplayer();
$multiplayer_options = array(
	'autoPlay' => false,
	'foregroundColor' => 'BADA55'
);


$content = '';

$content = '<p>Contexte : ' . $context . '</p>';

// @TODO display extended information only if available
// @TODO extend only custom subtypes ?


$text = $vars['value'];
//$text = parse_urls($text);

$p_site_url = parse_url(elgg_get_site_url());

$facets = new ElggContentFacets($text);

$sorted_links = $facets->getUrls();
// @TODO sort local and remote links
// @TODO local links : sort by path, or by entity then type/subtype
// @TODO provide additonal information

if (sizeof($sorted_links) > 0) {
	/*
	$sorted_links = array();
	foreach ($links as $link) {
		$p_url = parse_url($link);
		if ($p_url['host'] == $p_site_url['host']) {
			$sorted_links['local'][] = $link;
		} else {
			$sorted_links['external'][] = $link;
		}
	}
	*/
	$content .= '<strong>' . "Liens et ressources" . '</strong>';
	$content .= '<ul class="content-facets-links">';
	foreach ($sorted_links as $link_type => $links) {
		$content .= '<li>';
			$content .= elgg_echo('content_facets:link_type:'.$link_type);
			$content .= '<ul class="content-facets-links-'.$link_type.'">';
				foreach ($links as $link) {
					if ($link_type != 'local') {
						// Detect video content
						$Media = $Essence->extract($link);
						if ($Media) {
							$videos[] = $Media;
							//$content .= '<li><span class="content-facets-type">video</span> '.elgg_view('output/url', array('href' => $link, 'text' => $link)) . '</li>';
						}
						// Detect video/image/...? content
						try{
							$info = Embed\Embed::create($link);
							//$content .= '<li><span class="content-facets-type">' . $info->type . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $info->title . ' ' . $link, 'title' => $info->description)) . '<br />' . $info->code . '</li>';
							$content .= '<li><span class="content-facets-type">' . $info->type . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $info->title . ' ' . $link, 'title' => $info->description));
						} catch (Exception $e) {
							//error_log($e->getMessage());
							$content .= '<li><span class="content-facets-type">' . "invalid link" . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . '&nbsp;: ' . $e->getMessage() . '</li>';
						}
					} else {
						$content .= '<li><span class="content-facets-type">' . "local link" . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . '</li>';
					}
				}
			$content .= '</ul>';
		$content .= '</li>';
	}
	$content .= '</ul>';
	$content .= '<br />';
}


// Elgg links
$elgg_links = $facets->getInternalLinks();
if (sizeof($sorted_links) > 0) {
	$content .= '<strong>' . "Liens Elgg" . '</strong>';
	$content .= '<ul class="content-facets-links">';
	foreach ($elgg_links as $link => $link_info) {
		switch($link_info['handler']) {
			case 'groups':
				if (($link_info['page'][0] == 'profile') && ($entity = get_entity($link_info['page'][1])) && elgg_instanceof($entity, 'group')) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $entity->name)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			case 'profile':
				if (($entity = get_user_by_username($link_info['page'][0])) && elgg_instanceof($entity, 'user')) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $entity->getURL(), 'text' => $entity->name)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			case 'file':
				if (in_array($link_info['page'][0], array('view', 'edit', 'download')) && ($entity = get_entity($link_info['page'][1])) && elgg_instanceof($entity, 'object', 'file')) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $entity->getUrl(), 'text' => $entity->title)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			case 'pages':
				if (in_array($link_info['page'][0], array('view', 'edit')) && ($entity = get_entity($link_info['page'][1])) && (elgg_instanceof($entity, 'object', 'page') || elgg_instanceof($entity, 'object', 'page_top'))) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $entity->getUrl(), 'text' => $entity->title)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			case 'discussion':
				if (in_array($link_info['page'][0], array('view', 'edit')) && ($entity = get_entity($link_info['page'][1])) && elgg_instanceof($entity, 'object', 'groupforumtopic')) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $entity->getUrl(), 'text' => $entity->title)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			case 'blog':
				if (in_array($link_info['page'][0], array('view', 'edit')) && ($entity = get_entity($link_info['page'][1])) && elgg_instanceof($entity, 'object', 'blog')) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $entity->getUrl(), 'text' => $entity->title)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			case 'bookmarks':
				if (in_array($link_info['page'][0], array('view', 'edit')) && ($entity = get_entity($link_info['page'][1])) && elgg_instanceof($entity, 'object', 'bookmarks')) {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $entity->getUrl(), 'text' => $entity->title)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
				break;
			default:
				if (in_array($link_info['page'][0], array('view', 'edit')) && ($entity = get_entity($link_info['page'][1])) && elgg_instanceof($entity, 'object')) {
					$content .= '<li><span class="content-facets-type">' . $entity->getSubtype() . '</span> ' . elgg_view('output/url', array('href' => $entity->getUrl(), 'text' => $entity->title)) . '</li>';
				} else {
					$content .= '<li><span class="content-facets-type">' . $link_info['handler'] . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . ' <pre>' . print_r($link_info, true) . '</pre></li>';
				}
		}
	}
	$content .= '</ul>';
	$content .= '<br />';
}




// Emails
$emails = $facets->getEmails();
if (sizeof($emails) > 0) {
	$content .= '<strong>' . "Emails" . '</strong>';
	$content .= '<ul class="content-facets-emails">';
		foreach ($emails as $email => $email_info) {
			$content .= '<li>' . elgg_view('output/url', array('href' => 'mailto:'.$email, 'text' => $email)) . ' &nbsp; (Sujet&nbsp;: ' . $email_info['query']['subject'] . ' &nbsp; Contenu&nbsp;: ' . $email_info['query']['body'] . ')</li>';
		}
	$content .= '</ul>';
	$content .= '<br />';
}


// Images
$sorted_images = $facets->getImages();

// Sort local and remote
if (sizeof($sorted_images) > 0) {
	$images_content = '';
	$content .= '<strong>' . "Images" . '</strong>';
	$content .= '<ul class="">';
	foreach ($sorted_images as $link_type => $images) {
		$images_content .= '<li>';
			$images_content .= elgg_echo('content_facets:link_type:'.$link_type);
			$images_content .= '<ul class="content-facets-links-'.$link_type.'">';
			foreach ($images as $src) {
				$content .= '<li><a href="' . $src . '" target="_blank">' . $src . '</a></li>';
				$images_content .= '<li>' . elgg_view('output/img', array('src' => $src)) . '</li>';
			}
			$images_content .= '</ul>';
		$images_content .= '</li>';
	}
	$content .= '</ul>';
	$content .= '<ul class="content-facets-images">' . $images_content . '</ul>';
	$content .= '<br />';
}



// Remplace les URLs des vidéos par les vidéos
//$content .= '<hr />' . $Essence->replace($vars['value']);


if (sizeof($videos) > 0) {
	$videos_content = '';
	$content .= '<strong>' . "Vidéos" . '</strong>';
	$content .= '<ul class="">';
		foreach ($videos as $media) {
			//$content .= '<li>' . $media->providerName . '&nbsp;: <strong>' . $media->title . '</strong> de ' . $media->authorName . ' - ' . $media->description . '<br />' . $media->url . '</li>';
			$content .= '<li>' . $media->providerName . '&nbsp;: <strong>' . $media->title . '</strong> de ' . $media->authorName . ' ' . $media->url . '</li>';
			$videos_content .= '<li>' . $Multiplayer->html($media->url, $multiplayer_options) . '</li>';
		}
	$content .= '</ul>';
	$content .= '<ul class="content-facets-videos">' . $videos_content . '</ul>';
	$content .= '<br />';
}




if (!empty($content)) {
	echo '<div class="content-facets-extend">';
	echo $content;
	echo '</div>';
}


