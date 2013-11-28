<?php
global $CONFIG;
$guid = (int) get_input("guid");
$export_subpages = get_input("subpages", 'yes');
if ($export_subpages != 'yes') $export_subpages = false;


if (!empty($guid) && ($page = get_entity($guid)) && (elgg_instanceof($page, 'object', 'page_top') || elgg_instanceof($page, 'object', 'page'))) {
	elgg_load_library('elgg:pages');
	set_time_limit(0);
	$content = "";
	
	// Sommaire
	$summary = '<h3>Sommaire</h3>';
	
	if ($export_subpages) {
		// Export des sous-pages, forcément avec sommaire
		
		// On regarde où est publié ce wiki..
		$container = get_entity($page->container_guid);
		// ..et on change le nom en rapport
		$filename = $filename = elgg_get_friendly_title($CONFIG->site->name) . '_' . elgg_get_friendly_title($container->name) . '_' . date("YmdHis", time());
		
		// Listing des pages du container
		$toppages = esope_get_top_pages($container);
		if ($toppages) foreach ($toppages as $parent) {
			// Sommaire
			$summary .= '<li>' . elgg_view("output/url", array("text" => $parent->title, "href" => "#page_" . $parent->guid, "title" => $parent->title));
			$summary .= esope_list_subpages($parent, 'internal', false);
			$summary .='</li>';
			// Contenu
			$content .= '<h3>' . elgg_view("output/url", array("text" => $parent->title, "href" => false, "name" => "page_" . $parent->guid)) . '</h3>' . elgg_view("output/longtext", array("value" => $parent->description));
			$content .= esope_list_subpages($parent, false, true);
			$content .= '<p style="page-break-after:always;"></p>';
		}
		// Mise en page
		$content = '<div class="elgg-output"><ul>' . $summary . '</ul></div><hr />' . $content;
		
	} else {
		// Sinon export de la page courante seulement
		$filename = $filename = elgg_get_friendly_title($CONFIG->site->name) . '_' . elgg_get_friendly_title($page->title) . '_' . date("YmdHis", time());
		$content .= '<h3>' . elgg_view("output/url", array("text" => $page->title, "href" => false, "name" => "page_" . $page->guid)) . '</h3>' . elgg_view("output/longtext", array("value" => $page->description)) . '<p style="page-break-after:always;"></p>';
	}
	
	
	// Pour rendu dans iframe
	//$content = elgg_render_embed_content($content, $title, 'iframe');
	
	// Envoi du fichier
	header("Content-type: text/html; charset=utf-8");  
	header("Cache-Control: no-store, no-cache");  
	header('Content-Disposition: attachment; filename="'.$filename.'.html"');
	echo $content;
	
	exit;
	
} else {
	register_error(elgg_echo("pages:export:error:invalidguid"));
}

forward(REFERER);

