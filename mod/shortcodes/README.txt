## Author information
 *	Elgg Shortcodes integration
 *	Author : Mohammed Aqeel | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package Collections of Shortcodes for Elgg
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015


## Instructions:
 *	Drop into mod, enable in the admin panel and use.


## DESCRIPTION
More shortcodes ideas, implementable :

Use shortcodes as a way to :
	- *embed external content* : videos, iframes, paypal, GChart, GDrive viewer, Twitter, etc.
	- *ease syntax* for complex content: portfolio, slideshow; RSS feed...
	- *embed dynamic content* : posts lists, search results, various requests, related posts, author info...
	- *use templates* and complex models (perfect for cmspages) : blocks, notes, dynamic elements...
	- *use libraries* for various usages : JS, CSS..
	- *private content* : parts of posts can be limited to certain access levels/collections
	- *lorem ipsum*
	- *data tables* for structured data rendering
	- *tabs*

=> Add visual editor for shortcodes configuration : set params (field type + value + help)

=> Add visual page editor : use blocks, columns... in a drag'n'drop interface



## HOW TO ADD A NEW SHORTCODE ?
=> Add it to the shortcode library, OR include it via a new plugin

1. Define e new shortcode function : 
	function embed_pdf_function($attributes, $content = ') {
		// Extract params + add defaults
		extract(
			elgg_shortcode_atts(
				array(
						'url' => 'http://',
						'width' => '640',
						'height' => '480'
					), 
				$attributes)
			);
		// Return shortcode rendering (replaces the shortcode)
		return '<iframe src="http://docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' .$width. '; height:' .$height. ';">Your browser does not support iframes</iframe>';
	}

2. Register the new shortcode : elgg_add_shortcode($shortcode_tag, $function);
	elgg_add_shortcode('embedpdf', 'embed_pdf_function');

3. Optionally extend shortcode embed with new shortcode instructions :
 - create a view with new shortcodes details : myplugin/views/default/myplugin/extend_shortcodes_embed.php
 - add shortcodes details, eg.: <li class="elgg-item embed-item"><strong><?php echo elgg_echo('shortcodes:available:embedpdf');?>&nbsp;:</strong><br /><span class="embed-insert">[embedpdf width="600px" height="500px" url='PDF_URL']</span><br /><br /></li>
 - add to start.php : elgg_extend_view('shortcodes/embed/extend', 'myplugin/extend_shortcodes_embed');


## DOCUMENTATION & EXAMPLES :
* Simplest example of a shortcode tag using the API:
*
* <code>
* // [footag foo="bar"]
* function footag_func($attributes) {
* 	return "foo = {$attributes[foo]}";
* }
* elgg_add_shortcode('footag', 'footag_func');
* </code>


* Example with nice attribute defaults:
*
* <code>
* // [bartag foo="bar"]
* function bartag_func($attributes) {
* 	extract(elgg_shortcode_atts(array(
* 		'foo' => 'no foo',
* 		'baz' => 'default baz',
* 	), $attributes));
*
* 	return "foo = {$foo}";
* }
* elgg_add_shortcode('bartag', 'bartag_func');
* </code>


* Example with enclosed content:
*
* <code>
* // [baztag]content[/baztag]
* function baztag_func($attributes, $content='') {
* 	return "content = $content";
* }
* elgg_add_shortcode('baztag', 'baztag_func');
* </code>


