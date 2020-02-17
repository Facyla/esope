<?php
/**
 * Extract relevant content from text, and process it depending on plugin settings
 *  - @username : convert to link to ElggUser profile
 *  - #tags : convert to link to tag search
 *  - URL / online resource : convert to link + extract and sort resources
 *  - display identified resources: video, audio, image...
 *  - URL preview
 *  - save results to original entity to avoid further outgoing calls (facets_{meta_name})
 *  - ensure saved data is up to date (timestamp must be >= time_updated meta)
 * @TODO: process all URLs, then sort them all to feed private vars. 
 * 
 * @TODO permettre de convertir -et conserver- tout type de champ
 * - function ->saveConvertedField($entity, $field_name = 'description') {}
 * - function ->getConvertedField($entity, $field_name = 'description') {}
 */
class ElggContentFacets {
	
	// Constants
	//const SUBTYPE = "plugin_template";
	
	// Cached vars
	
	// Source Elgg Entity
	private $entity = false;
	
	// Original text
	private $text = false;
	// Converted text
	private $text_converted = false;
	// Extended text
	private $text_extended = false;
	
	// All links
	private $links = false;
	// External links
	private $links_external = false;
	// Internal links
	private $links_internal = false;
	
	// Mentions
	private $mentions = false;
	// Tags
	private $hashtags = false;
	// Emails
	private $emails = false;
	
	// Extracted resources from URLs
	// Images
	private $images = false;
	// Videos
	private $videos = false;
	// Audio files
	private $audios = false;
	// Other URLs
	private $others = false;
	
	
	/* Extract information from entity
	 * Construct from entity (using ->description or custom metadata name) OR from text
	 */
	function __construct($params = []) {
		$defaults = ['entity' => false, 'text' => false, 'meta_name' => 'description'];
		$params = $params + $defaults;
		if ($params['entity'] instanceof ElggEntity) {
			$this->entity = $params['entity'];
			$this->text = $params['entity']->{$params['meta_name']};
		} else {
			// Assume we've passed plain text
			$this->text = $params['text'];
		}
		
		//if ($entity instanceof ElggEntity) { echo "entity OK<br>"; }
		//if (isset($entity->facets_time_updated) && ($entity->facets_time_updated >= $entity->time_updated)) { echo "time OK: {$entity->facets_time_updated} >= {$entity->time_updated}<br>"; }
		//if (isset($entity->facets_text_converted) && strlen($entity->facets_text_converted) > 4) { echo "y'a du cont'nu !<br>"; } else { echo "vide !<br>"; }
		/*
		if (
			$entity instanceof ElggEntity 
			&& isset($entity->facets_time_updated) && ($entity->facets_time_updated >= $entity->time_updated)
			&& isset($entity->facets_text_converted) && (strlen($entity->facets_text_converted) > 4)
		) {
		*/
		// Checks if update or saving to entity is needed
		if (!$this->requiresUpdate()) {
			// Use cached data if we can (linked to an existing entity + already saved + latest computation update newer than last edition)
			//echo "FACETS : class cache used ";
			$metadata_names = ['text_converted', 'text_extended', 'links', 'links_external', 'links_internal', 'mentions', 'hashtags', 'emails', 'images', 'videos', 'audios', 'others'];
			//echo "<hr>LOADED FROM ENTITY : <br>";
			foreach($metadata_names as $name) {
				$this->{$name} = unserialize($this->entity->{"facets_$name"});
				//echo " - $name = {$this->entity->{"facets_$name"}}<br>";
			}
			return true;
		}
		
		// Compute all resources
		//echo "FACETS : new computation ";
		// Note : alternate method can be used to transform plain text links to HTML links, and use 1 single extract function afterwards
		//$this->text = parse_urls($text);
		if (!empty($this->text)) {
			// @TODO : process each links and sort them, then provide access functions based on filters
			$this->getImages();
			$this->images = $this->sortLocalExternal($this->images);
			// Extract all links + sort (internal / external)
			$this->extractUrls();
			$this->extractEmails();
			$this->links = $this->sortLocalExternal($this->links);
			$this->extractInternalLinks();
			
			// Optionally save to entity
			if ($this->entity instanceof ElggEntity) { $this::saveToEntity(); }
		}
		
	}
	
	
	// GETTERS: return extracted data
	
	// Get @mentions (usernames)
	public function getMentions() {
		if ($this->mentions !== false) { return $this->mentions; }
		//$regex = "/@+([a-zA-Z0-9_]+)/";
		$regex = "/(?:\s|^)@([^\s]+)/"; // extracts usernames (but not emails)
		//$text = preg_replace($regex, '<a href="profile/$1">$0</a>', $this->text);
		preg_match_all($regex, $this->text, $matches, PREG_PATTERN_ORDER);
		foreach($matches[1] as $match) {
			if (!empty($match)) {
				$mentions[] = $match;
			}
		}
		return $this->mentions = $mentions;
	}
	// Get #hashtags
	public function getHashtags() {
		if ($this->hashtags !== false) { return $this->hashtags; }
		//$regex = "/#+([a-zA-Z0-9_]+)/"; // basic regex
		//$regex = "/(?:\B|\b|\|\s|^)#[^\s|\b|\)|\W]+/"; // Extract hashtags (including contained in brackets, ponctuation, *including inlined#tags)
		$regex = "/(?:\B|\|\s|^)#([^\s|\b|\)|\W]+)/"; // Extract hashtags (including contained in brackets, ponctuation, but not inlined#tag)
		//$text = preg_replace($regex, '<a href="search?q=$1">$0</a>', $this->text);
		preg_match_all($regex, $this->text, $matches, PREG_PATTERN_ORDER);
		//foreach($matches[0] as $match) {   // #hashtag
		foreach($matches[1] as $match) {   // hashtag
			if (!empty($match)) {
				$hashtags[] = $match;
			}
		}
		return $this->hashtags = $hashtags;
	}
	
	// Get all links from text
	public function getUrls() {
		if ($this->links === false) { $this->extractUrls(); }
		return $this->links;
	}
	// Get images
	public function getImages() {
		if (!$this->images === false) { $this->extractImages(); }
		return $this->images;
	}
	// Get emails
	public function getEmails() {
		if ($this->emails === false) { $this->extractEmails(); }
		//if (!is_array($this->emails)) { $this->extractEmails(); }
		return $this->emails;
	}
	// Get external links (Elgg URLs)
	public function getExternalLinks() {
		if ($this->links_external === false) {
			$this->links_external = $this->links['external'];
		}
		return $this->links_external;
	}
	// Get internal links (Elgg URLs)
	public function getInternalLinks() {
		if ($this->links_internal === false) { $this->extractInternalLinks(); }
		return $this->links_internal;
	}
	
	
	
	// RENDERERS: render converted / extended content
	
	// Renders the text with enriched links / media (inlined)
	public function renderConvertedText($processors = []) {
		$defaults = ['url' => true, 'mention' => true, 'hashtag' => true, 'video' => true, 'image' => true, 'preview' => false];
		$processors = $processors + $defaults;
		if (!$processors) {
			// Use plugin setting
			$processors = [
				'url' => (elgg_get_plugin_setting('render_urls', 'content_facets') == 'yes' ? true : false),
				'mention' => (elgg_get_plugin_setting('render_mentions', 'content_facets') == 'yes' ? true : false),
				'hashtag' => (elgg_get_plugin_setting('render_hashtags', 'content_facets') == 'yes' ? true : false),
				'video' => (elgg_get_plugin_setting('render_videos', 'content_facets') == 'yes' ? true : false),
				'image' => (elgg_get_plugin_setting('render_images', 'content_facets') == 'yes' ? true : false),
				'preview' => (elgg_get_plugin_setting('render_url_previews', 'content_facets') == 'yes' ? true : false),
			];
		}
		
		$text = $this->text;
		
		// Inline replacement
		if ($processors['mention']) {
			$text = $this->renderMentions($text);
		}
		if ($processors['hashtag']) {
			$text = $this->renderHashtags($text);
		}
		// @TODO use better parser
		if ($processors['url']) {
			$text = parse_urls($text);
		}
		
		// Extended content (added after main content)
		// Rich content e.g. players after the content
		if ($processors['video']) {
			$text .= $this->renderVideos();
		}
		if ($processors['preview']) {
			$text .= $this->renderPreviews();
		}
		// @TODO Lightbox slideshow from extracted images
		if ($processors['image']) {
			$text .= $this->renderImages();
		}
		
		$this->text_converted = $text;
		
		/*
		if (
			$this->entity instanceof ElggEntity 
			&& (
				isset($this->entity->facets_time_updated) && ($this->entity->facets_time_updated <= $this->entity->time_updated) 
				|| empty($this->facets_text_converted)
			)
		) {
		*/
		if ($this->requiresUpdate()) {
			$this::saveToEntity();
		}
		
		return $this->text_converted;
	}
	
	// Render inline @mentions (usernames)
	// @TODO ajout images ne marche pas ??
	public function renderMentions($text) {
		//$regex = "/@+([a-zA-Z0-9_]+)/";
		$regex = "/(?:\s|^)@([^\s]+)/"; // extracts usernames (but not emails)
		
		//return preg_replace($regex, '<a href="' . elgg_get_site_url() . 'profile/$1">$0</a>', $text);
		// note: use [$this, 'function'] inste&ad of 'function' for class functions
		return preg_replace_callback($regex, [$this, 'renderUserMention'], $text);
		/* Alternate method using anonymous function
		return preg_replace_callback(
			$regex, function($matches) {
				// some code
			}, $text);
		*/
	}
	
	// Render inline #hashtags
	public function renderHashtags($text) {
		//$regex = "/#+([a-zA-Z0-9_]+)/"; // basic regex
		//$regex = "/(?:\B|\b|\|\s|^)#[^\s|\b|\)|\W]+/"; // Extract hashtags (including contained in brackets, ponctuation, *including inlined#tags)
		$regex = "/(?:\B|\|\s|^)#([^\s|\b|\)|\W]+)/"; // Extract hashtags (including contained in brackets, ponctuation, but not inlined#tag)
		return preg_replace($regex, '<a href="' . elgg_get_site_url() . 'search?q=$1">$0</a>', $text);
	}
	
	// Convert video links to embedded player
	public function renderVideos() {
		$video_content = '';
		$external_links = $this->getExternalLinks();
		if ($external_links && sizeof($external_links) > 0) {
			foreach ($external_links as $link) {
				$video = $this->renderVideoEmbed($link);
				if ($video) {
					$video_content .= '<div class="facets-video">' . $video . '</div>';
				}
			}
			if (!empty($video_content)) {
				return '<div class="facets-videos">' . $video_content . '</div>';
			}
		}
		return false;
	}
	
	// Extracts all images and display them in a lightbox slideshow
	// @TODO Use systematic content extratcor and sort before using this, so we can rely on pure URL and not HTML tags
	public function renderImages() {
		$images = $this->getImages();
		$elgg_files = []; // @TODO
		
		$slideshow = '';
			// Add images from ElggFile array
			foreach ($elgg_files as $file) {
				$slideshow .= '<li class="pam">';
					$slideshow .= elgg_view('output/url', [
						'text' => elgg_view('output/img', ['src' => $file->getIconURL('small'), 'alt' => $file->getDisplayName()]),
						'href' => $file->getIconURL('large'),
						'rel' => 'lightbox-gallery',
					]);
				$slideshow .= '</li>';
			}
			// Add images from images SRC array
			foreach ($images as $url) {
				$slideshow .= '<li class="pam">';
					$slideshow .= elgg_view('output/url', [
						'text' => elgg_view('output/img', ['src' => $url, 'alt' => '']),
						'href' => $url,
						'rel' => 'lightbox-gallery',
					]);
				$slideshow .= '</li>';
			}
		
		// Render slideshow
		if (!empty($slideshow)) {
			$slideshow = "SLIDESHOW >> ".elgg_view('output/url', [
				'text' => 'Open photo lightbox',
				//'href' => elgg_get_download_url($elgg_files[0]),
				'href' => $images[0],
				'class' => 'elgg-lightbox-photo mll',
			]) . '<ul class="elgg-gallery elgg-gallery-fluid">' . $slideshow . '</ul>';
		}
		return $slideshow;
	}
	
	// Convert non-video links to preview
	// @TODO : performs a single, initial sort of resources types so we can get theses easily
	public function renderPreviews() {
		$preview_content = '';
		//$urls = $this->getUrls();
		$urls = $this->getExternalLinks();
		if ($urls && sizeof($urls) > 0) {
			foreach ($urls as $link) {
				$is_video = $this->renderVideoEmbed($link);
				if (!$is_video) {
					//$preview_content .= "<br />$link is NOT A VIDEO";
					
					// Lightbox / iframe (fails because CORS)
					/*
					$ds_link = substr($link, strpos($link, '//'));
					$preview_content .= elgg_view('output/url', [
						'text' => ' (preview)',
						'title' => 'Preview link content',
						'href' => $ds_link,
						'class' => 'elgg-lightbox-iframe mll',
						'data-colorbox-opts' => json_encode(['width' => '80%', 'height' => '80%']),
					]);
					*/
					
					// Preview based on meta extraction
					$preview_content .= $this->renderUrlPreview($link);
					
					/*
					$preview_content .= '<iframe src="' . $link . '" />';
					*/
				}
			}
			if (!empty($preview_content)) {
				return '<div class="facets-previews">' . $preview_content . '</div>';
			}
		}
		return false;
	}
	
	// Displays details about an external URLs
	// @TODO exclude non-HTML resources (eg images)
	public function renderUrlPreview($url) {
		// Based on https://www.webslake.com/article/generating-link-preview-using-php/
		$url = htmlspecialchars(trim($url),ENT_QUOTES,'ISO-8859-1',TRUE);
		if (empty($url)) { return false; }
		
		$host = '';
		$url_data = parse_url($url);
		$host = $url_data['host'];
		$file = fopen($url,'r');
		if (!$file) { return false; }
		
		// Skip images
		//if (getimagesize($url)) { return false; }
		$headers = get_headers($url, 1);
		$content_types = implode($headers['Content-Type']); // note: can be an array
		if (strpos($content_types['Content-Type'], 'image') !== false) { return false; }
		
		$content = '';
		while(!feof($file)) { $content .= fgets($file,1024); }
		
		$meta_tags = get_meta_tags($url);
		
		// Get the title
		$title = '';
		if (array_key_exists('og:title',$meta_tags)) {
			$title = $meta_tags['og:title'];
		} else if (array_key_exists('twitter:title',$meta_tags)) {
			$title = $meta_tags['twitter:title'];
		} else {
			$title_pattern = '/<title>(.+)<\/title>/i';
			preg_match_all($title_pattern,$content,$title,PREG_PATTERN_ORDER);
			if (!is_array($title[1])) {
				$title = $title[1];
			} else {
				if (count($title[1]) > 0) {
					$title = $title[1][0];
				} else {
					$title = 'Title not found!';
				}
			}
		}
		$title = ucfirst($title);

		// Get the description
		$desc = '';
		if (array_key_exists('description',$meta_tags)) {
			$desc = $meta_tags['description'];
		} else if (array_key_exists('og:description',$meta_tags)) {
			$desc = $meta_tags['og:description'];
		} else if (array_key_exists('twitter:description',$meta_tags)) {
			$desc = $meta_tags['twitter:description'];
		} else {
			$desc = 'Description not found!';
		}
		$desc = ucfirst($desc);

		// Get url of preview image
		$img_url = '';
		if (array_key_exists('og:image',$meta_tags)) {
			$img_url = $meta_tags['og:image'];
		} else if (array_key_exists('og:image:src',$meta_tags)) {
			$img_url = $meta_tags['og:image:src'];
		} else if (array_key_exists('twitter:image',$meta_tags)) {
			$img_url = $meta_tags['twitter:image'];
		} else if (array_key_exists('twitter:image:src',$meta_tags)) {
			$img_url = $meta_tags['twitter:image:src'];
		} else {
			// Image not found in meta tags so find it from content
			$img_pattern = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
			$images = '';
			preg_match_all($img_pattern,$content,$images,PREG_PATTERN_ORDER);

			$total_images = count($images[1]);
			if ($total_images > 0 ) { $images = $images[1]; }

			for($i=0; $i<$total_images; $i++) {
				if ((strpos($images[$i], '://') === false) && (substr($images[$i], 0, 2) != '//')) { continue; }
				if(getimagesize($images[$i])) {
				//if(getimagesize($images[$i])) {
					list($width,$height,$type,$attr) = getimagesize($images[$i]);
					// Select an image of width greater than 600px
					if ($width > 600) {
						$img_url = $images[$i];
						break;
					}
				}
			}
		}
		
		if (!empty($img_url)) {
			$image = '<div class="elgg-image"><img src="' . $img_url . '" alt="Preview image"></div>';
		}
		
		// Render preview
		return <<<PREVIEW
			<div class="facets-preview">
				$image
				<div class="elgg-content">
					<strong>$title ($host)</strong><br />
					<a href="$url" rel="nofollow" target="_blank">$url</a>
					<p><em>$desc</em></p>
				</div>
			</div>
PREVIEW;
	}
	
	// Returns embedded video players from an (external) URL
	public function renderVideoEmbed($link) {
		$Essence = new Essence\Essence();
		$Multiplayer = new Multiplayer\Multiplayer();
		$multiplayer_options = ['autoPlay' => false, 'foregroundColor' => 'BADA55'];
		
		// Detect video content using Essence library
		$Media = $Essence->extract($link);
		if ($Media) {
			//$content .= '<li><span class="content-facets-type">video</span> '.elgg_view('output/url', array('href' => $link, 'text' => $link)) . '</li>';
			//$content .= " MEDIA Essence : " . print_r($Media, true) . '</pre>';
			if ($Media->type == 'video') {
				//$Media->width = "100%";
				//$Media->height = "400px";
				/*
				$options = array(
					'autoPlay' => true,
					'foregroundColor' => 'BADA55'
				);
				return $Multiplayer->html($link, $options, function($playerUrl) {
					return '<iframe src="' . $playerUrl . '" class="video-player" style="width: 100%; height: 30rem;">';
				});
				*/
				/*
				$Multiplayer->html($Media->url, [
					'autoPlay' => true,
					'highlightColor' => 'BADA55',
					'width' => "100%", 
					'height' => "400px",
				]);
				*/
				
				return $Media->html;
			}
		}
		
		// Alternate library: detect video content using Embed library
		try{
			$info = Embed\Embed::create($link);
			//$content .= '<li><span class="content-facets-type">' . $info->type . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $info->title . ' ' . $link, 'title' => $info->description)) . '<br />' . $info->code . '</li>';
			//$content .= '<li><span class="content-facets-type">' . $info->type . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $info->title . ' ' . $link, 'title' => $info->description));
			//$content .= " MEDIA Embed : <pre>" . print_r($info, true) . '</pre>';
			
			if ($info->type == 'video') {
				return $info->code;
			}
		} catch (Exception $e) {
			//error_log($e->getMessage());
			//$content .= '<li><span class="content-facets-type">' . "invalid link" . '</span> ' . elgg_view('output/url', array('href' => $link, 'text' => $link)) . '&nbsp;: ' . $e->getMessage() . '</li>';
		}
		return false;
	}
	
	
	// Return Elgg data from absolute url - if any
	public function detectElggContent($url) {
		$site_url = elgg_get_site_url();
		if (!strpos($url, $site_url) === 0) { return false; }
		
		return array('guid' => '', 'handler' => '', 'url' => $url);
	}
	
	
	
	// EXTRACTORS: specialized data extractors
	
	/* Wrapper function that extracts all links from text, using various methods
	 */
	private function extractUrls() {
		$this->links = array();
		
		// Get site host from site url (without trailing slash)
		$p_site_url = explode('/', elgg_get_site_url());
		$site_host = $p_site_url[0] . '//' . $p_site_url[2];
		
		
		// This extracts only URI that are not HTML links (plain text URI)
		$nonlinks = $this->getPlaintextLinks();
		if (sizeof($nonlinks) > 0) {
			foreach($nonlinks as $link) {
				// Normalize relative URL
				$link = elgg_normalize_url($link);
				echo $link; 
				if (!in_array($link, $this->links)) { $this->links[] = $link; }
			}
		}
		// HTML links
		$links = $this->getLinks();
		if (sizeof($links) > 0) {
			foreach($links as $link) {
				// Normalize relative URL (from site host - cannot use elgg_normalize_url because uses site base and not site host)
				if ((substr($link, 0, 1) == '/') && (substr($link, 1, 1) != '/')) {
					$link = $site_host . $link;
				}
				//$link = elgg_normalize_url($link);
				if (!in_array($link, $this->links)) { $this->links[] = $link; }
			}
		}
		
		return $this->links;
	}
	
	/**
	 * Extract links URLs from HTML
	 * @return array
	 */
	private function getLinks() {
		$links = array();
		
		// DOMDocument method
		//$html = file_get_contents('bookmarks.html');
		$dom = new DOMDocument; // Create a new DOM document

		// Parse the HTML. The @ is used to suppress any parsing errors that will be thrown if the $html string isn't valid XHTML.
		@$dom->loadHTML($this->text);

		//Get all links. You could also use any other tag name here,
		//like 'img' or 'table', to extract other tags.
		$nodes = $dom->getElementsByTagName('a');
		
		//Iterate over the extracted links and display their URLs
		foreach ($nodes as $node){
			//Extract and show the "href" attribute.
			$links[] = $node->getAttribute("href");
		}
		
		return $links;
	}
	
	/* Extract non-links URLs from plain text
	 * uses same parser as Elgg parse_urls function
	 * Important note : does not extract links from HTML links : only non-HTML links
	 */
	private function getPlaintextLinks() {
		$urls = array();
		
		// URI specification: http://www.ietf.org/rfc/rfc3986.txt
		// This varies from the specification in the following ways:
		//  * Supports non-ascii characters
		//  * Does not allow parentheses and single quotes
		//  * Cuts off commas, exclamation points, and periods off as last character

		// @todo this causes problems with <attr = "val">
		// must be in <attr="val"> format (no space).
		// By default htmlawed rewrites tags to this format.
		// if PHP supported conditional negative lookbehinds we could use this:
		// $r = preg_replace_callback('/(?<!=)(?<![ ])?(?<!["\'])((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\!\(\),]+)/i',
		$pattern = '/(?<![=\/"\'])((ht|f)tps?:\/\/[^\s\r\n\t<>"\']+)/i';
		preg_match_all($pattern, $this->text, $matches, PREG_PATTERN_ORDER);
		foreach($matches[0] as $href) {
			$urls[] = $href;
		}

		/*
		$r = preg_replace_callback('/(?<![=\/"\'])((ht|f)tps?:\/\/[^\s\r\n\t<>"\']+)/i',
		create_function(
			'$matches',
			'
			$url = $matches[1];
			$punc = "";
			$last = substr($url, -1, 1);
			if (in_array($last, array(".", "!", ",", "(", ")"))) {
			$punc = $last;
			$url = rtrim($url, ".!,()");
			}
			$urltext = str_replace("/", "/<wbr />", $url);
			return "<a href=\"$url\" rel=\"nofollow\">$urltext</a>$punc";
			'
		), $text);
		*/
		return $urls;
	}
	
	
	// Extract images
	// @TODO: base on resources extractor, or URLs extractor, or at least converted text, so we can rely on <img> tags
	private function extractImages() {
		$dom = new DOMDocument;
		if ($this->text_converted) {
			@$dom->loadHTML($this->text);
		} else {
			@$dom->loadHTML($this->text);
		}
		$nodes = $dom->getElementsByTagName('img');
		if (sizeof($nodes) > 0) {
			$this->images = array();
			foreach ($nodes as $node){
				$this->images[] = $node->getAttribute("src");
			}
			return $this->images;
		}
		return false;
	}
	
	
	// Extract emails (and remove found emails from links)
	private function extractEmails() {
		$this->emails = array();
		if (sizeof($this->links) > 0) {
			foreach($this->links as $k => $link) {
				//error_log("LINK = ".print_r($link, true));
				if (strpos($link, 'mailto:') === 0) { $link = substr($link, 7); }
				$email = explode('?', $link);
				$email = $email[0];
				if (is_email_address($email)) {
					//$this->emails[] = substr($link, strlen('mailto:'));
					if (!isset($this->emails[$email])) {
						$p_email = parse_url($link);
						parse_str($p_email['query'], $p_params);
						$this->emails[$email] = array('email' => $email, 'link' => $link, 'query' => $p_params);
					}
					unset($this->links[$k]);
				}
			}
		}
		return $this->emails;
	}
	
	
	
	// SORT & FILTER
	
	// Sort internal (same domain | relative URL) vs external links
	private function sortLocalExternal($urls) {
		$links = [];
		if ($urls && sizeof($urls) > 0) {
		
			$p_site_url = parse_url(elgg_get_site_url());
			foreach ($urls as $url) {
				$p_url = parse_url($url);
				if ($p_url['host'] == $p_site_url['host']) {
					// Explicit internal links
					$links['local'][] = $url;
				} else if ((strpos($url, '://') === false) && (substr($url, 0, 2) != '//')) {
					// Relative links <> not absolute (internal) - do not contain :// nor start by //
					$links['internal'][] = $url;
				} else {
					// Other links (absolute)
					$links['external'][] = $url;
				}
			}
		}
		return $links;
	}
	
	
	// Extract internal links (Elgg URLs)
	private function extractInternalLinks() {
		$this->links_internal = array();
		if ($this->links['local'] && sizeof($this->links['local']) > 0) {
			$site_url = elgg_get_site_url();
			foreach ($this->links['local'] as $k => $link) {
				if (strpos($link, $site_url) === 0) {
					$url = substr($link, strlen($site_url));
					$p_url = explode('?', $url);
					$path = $p_url[0];
					$query = $p_url[1];
					$segments = explode('/', $path);
					$handler = array_shift($segments);
					$this->links_internal[$link] = array('url' => $link, 'handler' => $handler, 'query' => $query, 'page' => $segments);
					unset($this->links['local'][$k]);
				}
			}
		}
		return $this->links_internal;
	}
	
	// Returns an array of ElggUsers from @mentions
	// @unused yet
	private function extractUsersFromMentions() {
		$mentions = $this->getMentions();
		$mentions_users = [];
		// Build better mentions (icon + link + name)
		foreach($mentions as $i => $username) {
			$user = get_user_by_username($username);
			if ($user instanceof ElggUser) {
				$mentions_users[$username] = $user;
			}
		}
		return $mentions_users;
	}
	
	// Returns a formatted mention link from the username
	// Link to profile on icon + name if user is accessible
	// Basic link if user not found
	private function renderUserMention($matches) {
		$user = get_user_by_username($matches[1]);
		if ($user instanceof ElggUser) {
			$icon = elgg_view('output/img', ['src' => $user->getIconUrl(['size' => 'tiny', 'alt' => $user->name])]);
			//$icon = $user->getIcon('tiny', 'icon');
			return '<a href="' . $user->getURL() . '" title="' . $user->name . '" class="facets-mention">' . $icon . '@' . $user->username . '</a>';
		}
		// Default link to profile
		return '<a href="' . elgg_get_site_url() . 'profile/' . $matches[1] . '">' . $matches[0] . '</a>';
	}
	
	
	// Should original entity be updated ?
	// Checks if saved data is up to date
	private function requiresUpdate() {
		// No entity : no saving to entity, but text needs to be processed
		if (!$this->entity instanceof ElggEntity) { return true; }
		// Last Facets update is older than latest entity update
		if (!isset($this->entity->facets_time_updated) || ($this->entity->facets_time_updated < $this->entity->time_updated)) { return true; }
		// No content (strlen of empty array is 4)
		if (!isset($this->entity->facets_text_converted) || (strlen($this->entity->facets_text_converted) <= 4)) { return true; }
		return false;
	}
	
	
	// Save computed data to entity
	private function saveToEntity($metadata_names = ['text_converted', 'text_extended', 'links', 'links_external', 'links_internal', 'mentions', 'hashtags', 'emails', 'images', 'videos', 'audios', 'others']) {
		if (!$this->entity instanceof ElggEntity) { return false; }
		
		//echo "<hr>FACETS : Entity OK : SAVING<hr>";
		// ensure data is up to date (compare to latest data update)
		//if ($entity->facets_time_updated >= $entity->time_updated) { return true; }
		
		// Note : save as individual metadata for quicker and more direct access
		
		foreach($metadata_names as $name) {
			$this->entity->{"facets_$name"} = serialize($this->{$name});
			//echo " - $name = {$this->entity->{"facets_$name"}}<br>";
		}
		
		$this->entity->facets_time_updated = time();
		
		// This should not be required ?
		//$this->entity->save();
		//echo print_r($this->entity, true);
		
		return true;
	}
	
	
	
	// Saves converted custom field to entity
	// note : setting $value to null remove field from entity
	// defaults to class entity if 
	public function saveConvertedField($value = null, $field_name = 'description', $entity = null, $custom_target_field_name = false) {
		if ($entity !== false && !$entity instanceof ElggEntity) { $entity = $this->entity; }
		if (!$entity instanceof ElggEntity) { return false; }
		
		$target_field_name = 'facets_' . $field_name;
		if (!empty($custom_target_field_name)) { $target_field_name = $custom_target_field_name; }
		$entity->{$target_field_name} = $value;
		return true;
	}
	
	// Gets converted custom field from entity
	public function getConvertedField($field_name = 'description', $entity = null, $custom_target_field_name = false) {
		if ($entity !== false && !$entity instanceof ElggEntity) { $entity = $this->entity; }
		if (!$entity instanceof ElggEntity) { return false; }
		
		$target_field_name = 'facets_' . $field_name;
		if (!empty($custom_target_field_name)) { $target_field_name = $custom_target_field_name; }
		return $entity->{$target_field_name};
	}
	
}

