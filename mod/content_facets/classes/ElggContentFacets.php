<?php
/**
 * Extended class to override the time_created
 * 
 * @property string $comments_on Whether commenting is allowed (Off, On)
 * @property string $excerpt     An excerpt of the content_facets post used when displaying the post
 */
class ElggContentFacets {
	
	// Constants
	//const SUBTYPE = "plugin_template";
	
	// Cached vars
	private $text = false;
	
	private $images = false;
	
	private $links = false;
	private $emails = false;
	private $elgg_links = false;
	private $elgg_content = false;
	
	
	function __construct($text = '') {
		$this->text = $text;
		// Note : alternate method can be to transform plain text links to HTML links, and use 1 single extract function afterwards
		//$this->text = parse_urls($text);
		
		// @TODO : process each links and sort them, then provide access functions based on filters
		$this->getImages();
		$this->images = $this->sortLocalExternal($this->images);
		
		$this->getUrls();
		$this->getEmails();
		$this->links = $this->sortLocalExternal($this->links);
		$this->getInternalLinks();
	}
	
	
	/* Wrapper function that extracts all links from text, using various methods
	 */
	public function getUrls() {
		if ($this->links) { return $this->links; }
		
		// Get site host from site url (without trailing slash)
		$p_site_url = explode('/', elgg_get_site_url());
		$site_host = $p_site_url[0] . '//' . $p_site_url[2];
		
		$this->links = array();
		// This extracts only URI that are not HTML links
		$nonlinks = $this->getPlaintextLinks();
		if (sizeof($nonlinks) > 0) {
			foreach($nonlinks as $link) {
				// Normalize relative URL
				$link = elgg_normalize_url($link);
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
	public function getLinks() {
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
	public function getPlaintextLinks() {
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
	public function getImages() {
		if ($this->images) { return $this->images; }
		
		$this->images = array();
		$dom = new DOMDocument;
		@$dom->loadHTML($this->text);
		$nodes = $dom->getElementsByTagName('img');
		foreach ($nodes as $node){
			$this->images[] = $node->getAttribute("src");
		}
		return $this->images;
	}
	
	
	// Extract emails (and remove found emails from links)
	public function getEmails() {
		if ($this->emails) { return $this->emails; }
		
		$this->emails = array();
		if (sizeof($this->links) > 0) {
			foreach($this->links as $k => $link) {
				//error_log("LINK = ".print_r($link, true));
				if (strpos($link, 'mailto:') === 0) {
					$link = substr($link, 7);
				}
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
	
	// Sort links or images urls
	public function sortLocalExternal($urls) {
		$links = array();
		if (sizeof($urls) > 0) {
			$p_site_url = parse_url(elgg_get_site_url());
			foreach ($urls as $url) {
				$p_url = parse_url($url);
				if ($p_url['host'] == $p_site_url['host']) {
					$links['local'][] = $url;
				} else {
					$links['external'][] = $url;
				}
			}
		}
		return $links;
	}
	
	// Get internal links (Elgg URLs)
	public function getInternalLinks() {
		if ($this->elgg_links) { return $this->elgg_links; }
		
		$this->elgg_links = array();
		if (sizeof($this->links['local']) > 0) {
			$site_url = elgg_get_site_url();
			foreach ($this->links['local'] as $k => $link) {
				if (strpos($link, $site_url) === 0) {
					$url = substr($link, strlen($site_url));
					$p_url = explode('?', $url);
					$path = $p_url[0];
					$query = $p_url[1];
					$segments = explode('/', $path);
					$handler = array_shift($segments);
					$this->elgg_links[$link] = array('url' => $link, 'handler' => $handler, 'query' => $query, 'page' => $segments);
					unset($this->links['local'][$k]);
				}
			}
		}
		return $this->elgg_links;
	}
	
	// Return Elgg data from absolute url - if any
	public function detectElggContent($url) {
		$site_url = elgg_get_site_url();
		if (!strpos($url, $site_url) === 0) { return false; }
		
		
		
		return array('guid' => '', 'handler' => '', 'url' => $url);
	}
	
	
	
}

