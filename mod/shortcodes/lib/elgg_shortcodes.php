<?php
/**
 *	Elgg Shortcodes integration
 *	Author : Mohammed Aqeel | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info [at] webgalli [dot] com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package Collections of Shortcodes for Elgg
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */

/* NOTE : here are defined the shortcodes
 * 1. Define a shortcode behaviour with a function
 * 2. Register the new shortcode : elgg_add_shortcode('embedpdf', 'embed_pdf_function');
 */

// Allow to embed content when security options block (needs to use HTTPS if site uses HTTPS)
if (elgg_get_config('https_login')) {
	define('SHORTCODE_HTTP_PREFIX', 'https://');
} else {
	define('SHORTCODE_HTTP_PREFIX', 'http://');
}


/**
 * Embed PDF
 * [embedpdf width="600px" height="500px"]' . SHORTCODE_HTTP_PREFIX . 'infolab.stanford.edu/pub/papers/google.pdf[/embedpdf]
 */
function embed_pdf_function($atts) {
	extract(elgg_shortcode_atts(array(
			'url' => SHORTCODE_HTTP_PREFIX . '',
			'width' => '640px',
			'height' => '480px'
		), $atts));
	return '<iframe src="' . SHORTCODE_HTTP_PREFIX . 'docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' .$width. '; height:' .$height. ';">Your browser does not support iframes</iframe>';
}
elgg_add_shortcode('embedpdf', 'embed_pdf_function');


/**
 * Embed Charts 
 * [chart data="41.52,37.79,20.67,0.03" bg="F7F9FA" labels="Reffering+sites|Search+Engines|Direct+traffic|Other" colors="058DC7,50B432,ED561B,EDEF00" size="488x200" title="Traffic Sources" type="pie"]
 */ 
function chart_shortcode( $atts ) {
	extract(elgg_shortcode_atts(array(
			'data' => '',
			'colors' => '',
			'size' => '400x200',
			'bg' => 'ffffff',
			'title' => '',
			'labels' => '',
			'advanced' => '',
			'type' => 'pie'
		), $atts));
	switch ($type) {
		case 'line' :
			$charttype = 'lc'; break;
		case 'xyline' :
			$charttype = 'lxy'; break;
		case 'sparkline' :
			$charttype = 'ls'; break;
		case 'meter' :
			$charttype = 'gom'; break;
		case 'scatter' :
			$charttype = 's'; break;
		case 'venn' :
			$charttype = 'v'; break;
		case 'pie' :
			$charttype = 'p3'; break;
		case 'pie2d' :
			$charttype = 'p'; break;
		default :
			$charttype = $type; break;
	}
	if ($title) $string .= '&chtt='.$title.'';
	if ($labels) $string .= '&chl='.$labels.'';
	if ($colors) $string .= '&chco='.$colors.'';
	$string .= '&chs='.$size.'';
	$string .= '&chd=t:'.$data.'';
	$string .= '&chf='.$bg.'';
	return '<img title="'.$title.'" src="' . SHORTCODE_HTTP_PREFIX . 'chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
}
elgg_add_shortcode('chart', 'chart_shortcode');


/**
 * Snap Webpages
 * [snap url="' . SHORTCODE_HTTP_PREFIX . 'www.webgalli.com" alt="My description" w="400" h="300"]
 */ 
function webpage_snaps($atts, $content = null) {
	extract(elgg_shortcode_atts(array(
			"snap" => SHORTCODE_HTTP_PREFIX . 's.wordpress.com/mshots/v1/',
			"url" => SHORTCODE_HTTP_PREFIX . 'www.webgalli.com',
			"alt" => 'Site preview',
			"w" => '400', // width
			"h" => '300' // height
		), $atts));
	$img = '<img src="' . $snap . urlencode($url) . '?w=' . $w . '&h=' . $h . '" alt="' . $alt . '"/>';
	return $img;
}
elgg_add_shortcode("snap", "webpage_snaps");


/**
 * Embed Google Maps
 * [googlemap width="600" height="300" src="' . SHORTCODE_HTTP_PREFIX . 'maps.google.com/maps?q=Heraklion,+Greece&hl=en&ll=35.327451,25.140495&spn=0.233326,0.445976& sll=37.0625,-95.677068&sspn=57.161276,114.169922& oq=Heraklion&hnear=Heraklion,+Greece&t=h&z=12"]
 */
function googlemap_function($atts, $content = null) {
	extract(elgg_shortcode_atts(array(
			"width" => '640px',
			"height" => '480px',
			"src" => ''
		), $atts));
	return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'&output=embed" ></iframe>';
}
elgg_add_shortcode("googlemap", "googlemap_function");


/**
 * Embed Videos
 * [video site="youtube" id="dQw4w9WgXcQ" w="600" h="340"]
 */
function video_sc($atts, $content=null) {
	extract(
		elgg_shortcode_atts(array(
					'site' => 'youtube',
					'id' => '',
					'w' => '600px',
					'h' => '370px'
				), $atts)
		);
	if ( $site == "youtube" ) { $src = SHORTCODE_HTTP_PREFIX . 'www.youtube-nocookie.com/embed/'.$id; }
	else if ( $site == "vimeo" ) { $src = SHORTCODE_HTTP_PREFIX . 'player.vimeo.com/video/'.$id; }
	else if ( $site == "dailymotion" ) { $src = SHORTCODE_HTTP_PREFIX . 'www.dailymotion.com/embed/video/'.$id; }
	else if ( $site == "yahoo" ) { $src = SHORTCODE_HTTP_PREFIX . 'd.yimg.com/nl/vyc/site/player.html#vid='.$id; }
	else if ( $site == "bliptv" ) { $src = SHORTCODE_HTTP_PREFIX . 'a.blip.tv/scripts/shoggplayer.html#file=' . SHORTCODE_HTTP_PREFIX . 'blip.tv/rss/flash/'.$id; }
	else if ( $site == "veoh" ) { $src = SHORTCODE_HTTP_PREFIX . 'www.veoh.com/static/swf/veoh/SPL.swf?videoAutoPlay=0&permalinkId='.$id; }
	else if ( $site == "viddler" ) { $src = SHORTCODE_HTTP_PREFIX . 'www.viddler.com/simple/'.$id; }
	if ( $id != '' ) {
		return '<iframe width="'.$w.'" height="'.$h.'" src="'.$src.'" class="vid iframe-'.$site.'"></iframe>';
	}
}
elgg_add_shortcode('video','video_sc');


/**
 * Diaporama
 * [diaporama width="600px" height="500px" images="URL1, URL2"]
 */
function diaporama_function($atts, $content='') {
	$slider_content = '';
	extract(elgg_shortcode_atts(array(
			'width' => '640px',
			'height' => '300px',
			'images' => '',
		), $atts));
	$li_style = "width:$width !important; height:$height !important;";
	if (!empty($images)) {
		// Mode 1 : use images="URL1, URL2" attribute => works if content is not pre-parsed (eg URL are not converted to links)
		$images = strip_tags($images);
		$images = str_replace('&nbsp;', '', $images);
		$images = explode(',', $images);
	} else {
		// We can provide content params in 2 ways : URL list, or HTML content (containing images)
		$is_html = strpos($content, '<img');
		if ($is_html === false) {
			// Mode 2 : use URL list => strip tags before making an array
			$images = strip_tags($content);
			$images = str_replace(array('&nbsp;', '&amp;'), array('', '&'), $images);
			$images = explode(',', $images);
		} else {
			// Mode 3 : use plain HTML content, in that case we can use regex or DOM
			// Regex parser for src extraction
			// preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $images, $urls);
			// $images = $urls[1];
			// DOM parser, more robust and reliable, + much more appropriate for mixed content extraction (=> list)
			// IMPORTANT : les contenus des slides restent des images seules pour le moment, dont on extraie les URL
			// Le contenu HTML pose des pb de dimensions
//			$is_list = strpos($content, '<ul');
//			if ($is_list === false) {
				// Simple images slider
				$doc = new DOMDocument();
				$doc->loadHTML($content);
				$xpath = new DOMXPath($doc);
				$src = $xpath->query("//img/@src");
				foreach ($src as $href) { $images[] = $href->nodeValue; }
/*
			} else {
				// Complex HTML content slider - must be structured as a list
				$doc = new DOMDocument();
				$doc->loadHTML($content);
				$xpath = new DOMXPath($doc);
				//$list = $xpath->query("//li");
				//$list = $doc->getElementsByTagName('li');
				//foreach ($list as $item) { $slider_content .= '<li class="textSlide">' . $item->nodeValue . '</li>'; }
				$list = $doc->getElementsByTagName('li');
				foreach ($list as $item) {
					$item->setAttribute('class', 'textSlide');
					$item->setAttribute('style', $li_style);
					$slider_content .= $doc->saveXML($item);
				}
			}
*/
		}
	}
	// Use images if available, full HTML content otherwise
	if ($images) foreach ($images as $url) { $slider_content .= '<li style="'.$li_style.'"><img src="' . trim($url) . '" /></li>'; }
	$slider_params = array(
		// Param vars
		// Complete content - except the first-level <ul> tag (we could use an array instead..)
		'slidercontent' => $slider_content,
		// JS additional parameters
		'sliderparams' => "theme:'cs-portfolio', buildStartStop:false, resizeContents:false, ",
		// CSS for main ul tag
		'slidercss_main' => 'width:'.$width.'; height:'.$height.';',
		'height' => $height,
		'width' => $width,
		// CSS for li .textslide
		'slidercss_textslide' => '',
	);
	$content = elgg_view('slider/slider', $slider_params);
	return $content;
}
elgg_add_shortcode('diaporama', 'diaporama_function');


