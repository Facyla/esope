/* Newsletter PRINT styles */

/* Using @media for in inline mode */
@media print {
	
	html *, body * { min-height:0 !important; }
	
	html, body, section { background:white !important; }
	* { background-color: white !important; color: black !important; font-family:"Inria Serif",times,serif; }
	a:link { text-decoration: underline; }
	
	/* Conversion des URL relatives en URL absolues */
	/* Inria: not wanted
	a:[href^="/"]:after{  content: " <?php echo elgg_get_site_url(); ?>" attr(href); }
	*/
	
	/* URL des liens */
	/* Inria: not wanted
	a[href]:after { content: " (" attr(href) ")"; }
	*/
	
	/* Signification des abbréviations */
	/* Inria: not wanted
	abbr[title]:after { content: " (" attr(title) ") "; }
	*/
	
	/* URL des sources des citations */
	/* Inria: not wanted
	blockquote[title]:after { content: " (" attr(cite) ") "; }
	*/

	#elgg-print-message { display: block; }
	
	#newsletter_header { background: white; border: 0; }
	#newsletter_online, #newsletter_container { width: 100%; }
	
	#newsletter_header, .elgg-module-newsletter, #newsletter_footer { border: 0; }
	
}


