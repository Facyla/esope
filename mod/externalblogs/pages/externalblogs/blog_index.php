<?php
/**
 * Elgg externalblogs plugin render page
 *
 * @package Elggexternalblogs
 */
global $CONFIG;
$url = elgg_get_site_url();
$CONFIG->walled_garden = false;

//elgg_set_context('externalblogs');
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('externalblogs'));
elgg_set_context('externalblog');

// On affiche le blog tel qu'il est vu publiquement ou tel qu'il est pour les éditeurs dans l'intranet ?
// Par défaut, public si non connecté (et on ne peut pas forcer autrement), 
// non public si connecté, sauf si forcé
if (elgg_is_logged_in()) {
	$public_view = get_input('public', false);
	if (!empty($public_view)) $public_view = true;
} else {
	$public_view = true;
}

$months = array(1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre');

//$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = full_url();
$request_uri = explode('?', $request_uri);
$request_url = $request_uri[0];
$request_params = $request_uri[1];
$request_url = explode($url, $request_url);
$request_url = explode('/', $request_url[1]);
// Données utiles : blog, article/rubrique/recherche, titre article/tag/critère
$blogname = $request_url[0];
$url_param_1 = $request_url[1];
//$url_param_1 = urldecode($request_url[1]);
$url_param_2 = urldecode($request_url[2]);


// Récupération du blog demandé + son URL
$externalblogs = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'blogname', 'value' => $blogname)));
$externalblog = $externalblogs[0];
$blog_base_url = $url . $externalblog->blogname;


// CONTRÔLE D'ACCÈS
if (!$public_view) {
	if (!$externalblog) { register_error('externalblogs:unknown'); forward(); }
} else {
	// Blog externe non valide ou blog non public => exit
	if (!$externalblog || ($externalblog->access_id != 2)) { register_error('externalblogs:unknown'); forward(); }
}

// Contrôle de mot de passe du blog, si défini
if (!empty($externalblog->password)) {
	$logout = get_input('logout', false);
	if ($logout == 'yes') {
		unset($_SESSION['externalblog']);
		//if (logout())
		system_message('externalblogs:sessiondestroyed');
	}
	$passhash = md5($url . $externalblog->password);
	if ($_SESSION['externalblog'][$externalblog->guid]['passhash'] !== $passhash) {
		$input_password = get_input('password', false);
		$hash_input_password = md5($url . $input_password);
		if ($input_password && ($hash_input_password == $passhash)) {
			$_SESSION['externalblog'][$externalblog->guid]['passhash'] = $passhash;
		} else {
			$content = '<form method="POST" action="">' . elgg_view('input/password', array('name' => 'password')) . elgg_view('input/submit', array('value' => 'login')) . '</form>';
			$title = elgg_echo('externalblogs:passwordprotected');
			$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'filter' => ''));
			echo elgg_view_page($title, $body);
			exit;
		}
	}
}
// Bouton de déconnexion si accès restreint par mot de passe
if (isset($_SESSION['externalblog'])) {
	// Si connecté via mot de passe de blog : Bouton de déconnexion
	$unset_session = '<form method="post" action="">' . elgg_view('input/hidden', array('name' => 'logout', 'value' => 'yes')) . elgg_view('input/submit', array('value' => 'Fermer ma session')) . '</form>';
	$unset_session = $unset_session . '<br />';
	//$unset_session = '<span style="float:right; font-weight:bold; font-size:80%;">' . $unset_session . '</span>';
}



// @TODO : PAGINATION !!!	on peut pas charger X Mo d'un seul coup sur l'accueil !!!

// Ordre de tri des articles
// @TODO : réglage pour chaque blog ?
if (elgg_is_active_plugin('theme_sfprojex')) $ordering = array('name' => 'publication_startdate', 'direction' => 'DESC');
// Liste de tous les articles du blog (utile pour divers filtres)
$all_articles_count = elgg_get_entities_from_relationship(array('relationship_guid' => $externalblog->guid, 'relationship' => 'attached', 'inverse_relationship' => false, 'count' => true));
$all_articles = elgg_get_entities_from_relationship(array('relationship_guid' => $externalblog->guid, 'relationship' => 'attached', 'inverse_relationship' => false, 'limit' => $all_articles_count, 'order_by_metadata' => $ordering));

// Classement Données des index par date de publiction annoncée (et pas celle sur Elgg)
foreach ($all_articles as $ent) {
	if ($ent->publication_startdate) {
		$article_dates = explode('-', $ent->publication_startdate);
		$y = (int)$article_dates[0]; $m = (int)$article_dates[1]; $d = (int)$article_dates[2];
	} else {
		$y = date('Y', $ent->time_created); $m = date('n', $ent->time_created); $d = date('j', $ent->time_created);
	}
	if (empty($m)) $m = 1;
	if (empty($d)) $d = 1;
	// Index des articles par date : [$year][$month][$day][] = array(title, url, guid);
	//$article_index[$y][$m][$d][] = array('title' => $article->title, 'url' => $article_url, 'guid' => $article->guid);
	$article_index[$y][$m][$d][] = $ent;
	// Comptage des articles par date
	if (!isset($dates_index[$y][$m])) {
		$dates_index[$y][$m] = 1;
	} else {
		$dates_index[$y][$m] = (int)$dates_index[$y][$m] + 1;
	}
}
/*
// Index des articles par date
//$article_index[$y][$m][] = array('title', 'url', 'guid');
$summary = '';
$summary .= 'Index des articles par date : ' . print_r($article_index, true);
foreach ($article_index as $y => $year_index) {
	$summary .= '<h4>' . $y . '</h4>';
	foreach ($year_index as $m => $month_index) {
		$summary .= '<h5>' . $months[$m] . '</h5>';
		foreach ($month_index as $day_index => $index) {
			foreach ($day_index as $i => $index) {
				$summary .= '<a href="' . $index['url'] . '">' . $index['title'] . '</a><br />';
			}
		}
	}
}
*/
// Index des archives par date
$dates_summary = '';
$archives_url = $url . $blogname . '/archives/';
//$dates_summary .= print_r($dates_index, true);
foreach ($dates_index as $y => $year_index) {
	$dates_summary .= '<strong><a href="' . $archives_url . $y .'" title="Afficher tous les articles de ' . $y . '">' . $y . '</a></strong>';
	$dates_summary .= '<ul style="margin-top:0;">';
	foreach ($year_index as $m => $count) {
		if (strlen($m) == 1) $mm = '0' . $m; else $mm = $m;
		$archive_url = $archives_url . $y . $mm;
		$dates_summary .= '<li><a href="' . $archive_url . '" title="Afficher ';
		if ($count > 1) $dates_summary .= $count . ' articles publiés en ' . $months[$m] . ' ' . $y;
		else $dates_summary .= $count . ' article publié en ' . $months[$m] . ' ' . $y;
		$dates_summary .= '">' . $months[$m] . ' (' . $count . ')</a></li>';
	}
	$dates_summary .= '</ul>';
}


// Listing des articles ou 1 article sélectionné
if (empty($url_param_1)) {
	// Accueil du blog : édito
	//$content .= elgg_view('externalblogs/blog_home', array('entity' => $externalblog)) . '<br />';
	//$content .= $externalblog->description . '<br />';
	$title = $externalblog->title;
	//$title = elgg_echo('externalblogs:blog');
	$externalblog_context = "externalblog_home";
	// Tous les articles
	$articles = $all_articles;
	//$articles = get_attachments($externalblog->guid, 'object');
	//$articles = get_entity_relationships($externalblog->guid, false);
	
} else {
	// Pour confrontation à la liste des résultats obtenue / filtrage
	//$count_articles = elgg_get_entities_from_relationship(array('relationship_guid' => $externalblog->guid, 'relationship' => 'attached', 'inverse_relationship' => false, 'count' => true));
	//$all_articles = elgg_get_entities_from_relationship(array('relationship_guid' => $externalblog->guid, 'relationship' => 'attached', 'inverse_relationship' => false, 'limit' => $count_articles, 'order_by_metadata' => $ordering));
	
	if (in_array($url_param_1, array('categorie', 'category', 'rubrique'))) {
		// Si catégorie = rubriques pré-définies
		$externalblog_context = "externalblog_category";
		if ($url_param_2) {
			$search_tag = $url_param_2;
			/*
			$search_tag = explode(' ', $url_param_2);
			$search_tag = implode('+', $search_tag);
			*/
			// Liste des articles de la catégorie
			$articles_count = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'tags', 'value' => $search_tag), 'types' => 'object', 'count' => true));
			$articles = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'tags', 'value' => $search_tag), 'types' => 'object', 'limit' => $articles_count, 'order_by_metadata' => $ordering));
		}
		/* @TODO filtrage des résultats
		foreach ($results as $ent) {
			//if (in_array($ent->guid, $articles))
		}
		*/
		$title = '<a href="' . $url . $externalblog->blogname . '">' . $externalblog->title . '</a> : rubrique &laquo;&nbsp;'.$url_param_2.'&nbsp;&raquo;';
		
	} else if (in_array($url_param_1, array('galerie', 'gallery'))) {
		// Si listing = recherche
		$externalblog_context = "externalblog_gallery";
		if ($url_param_2) {
			// Liste des articles de la galerie
			$articles_count = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'tags', 'value' => $url_param_2), 'types' => 'object', 'count' => true, 'order_by_metadata' => $ordering));
			$articles = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'tags', 'value' => $url_param_2), 'types' => 'object', 'limit' => $articles_count, 'order_by_metadata' => $ordering));
		}
		$title = '<a href="' . $url . $externalblog->blogname . '">' . $externalblog->title . '</a> : recherche &laquo;&nbsp;'.$url_param_2.'&nbsp;&raquo;';
		
	} else if (in_array($url_param_1, array('search', 'tag', 'listing'))) {
		// Si listing = recherche
		$externalblog_context = "externalblog_listing";
		if ($url_param_2) {
			// @TODO Lister les articles correspondant à la recherche
			// Search se fait via plugin hooks :	'search', "<type>:<subtype>"	-	'search', 'tags'	-	'search', <type>
			$articles = trigger_plugin_hook('search','object', array('tag' => $url_param_2), array()); // hook, type, params, returnvalue
			// @TODO : filtrer les résultats correspondant au site externes
			// @TODO : au passage, faire un autre hook pour ne considérer que les publications du blog visualisé
		}
		$title = '<a href="' . $url . $externalblog->blogname . '">' . $externalblog->title . '</a> : recherche &laquo;&nbsp;'.$url_param_2.'&nbsp;&raquo;';
		
	} else if (in_array($url_param_1, array('page'))) {
		// Si page CMS = layout spécial
		$externalblog_context = "externalblog_cmspages";
		// @TODO ? Si le nom contient celui du layout, on peut l'omettre : nom_blog-nom_page_cms ou nom_page_cms
		if ($url_param_2) { $content .= elgg_view('cmspages/view', array('pagetype' => $url_param_2)); }
		
	} else if (in_array($url_param_1, array('archives'))) {
		if (strlen($url_param_2) < 4) {
			// Aucun filtre => Sommaire seulement
			$content .= '<h2>Archives par date</h2>' . $dates_summary;
		} else {
			/*
			$content .= '<div id="article-index"><h2>Archives</h2>' . $dates_summary . '</div>';
			$content .= '<style>
				#article-index { position: absolute; right: 0; top:0; bottom:90%; overflow:hidden; background: white; }
				#article-index:active, #article-index:focus, #article-index:hover { bottom:auto; overflow:none; }
				#article-index h2 { padding:2px 0; margin:2px 0; }
				#article-index h3 { padding:2px 0; margin:2px 0; background: black; color:white; }
				</style>';
			*/
			$year = substr($url_param_2, 0, 4);
			if (strlen($url_param_2) > 5) $month = substr($url_param_2, 4, 2);
			if (strlen($url_param_2) > 7) $day = substr($url_param_2, 6, 2);
			$content .= "<h2>Archives &nbsp;: $day {$months[(int)$month]} $year</h2>";
			//$externalblog_context = "externalblog_listing";
			$externalblog_context = "externalblog_category";
			foreach($article_index as $y => $year_index) {
				if ($year && ($year != $y)) continue;
				foreach($year_index as $m => $month_index) {
					if ($month && ($month != $m)) continue;
					foreach($month_index as $d => $day_index) {
					 if ($day && ($day != $d)) continue;
						foreach($day_index as $ent) {
							//$article_index[$y][$m][$d][] = $article;
							$articles[] = $ent;
						}
					}
				}
			}
		}
		
	} else {
		// Article normal (appelé par son GUID)
		$externalblog_context = "externalblog_fullview";
		// Article choisi en pleine page
		$article = get_entity($url_param_1);
		$title = '<a href="' . $url . $externalblog->blogname . '">' . $externalblog->title . '</a> : ' . $article->title;
		$articles = array($article);
	}
}


// AFFICHAGE DU OU DES ARTICLES
// @TODO : pagination
$display_limit = get_input('limit', 6);
$offset = get_input('offset', 0);
$article_index = 0;
$displayed_index = 0;
$articles_count = count($articles);
/*
 * @uses int		$vars['offset']		 The offset in the list
 * @uses int		$vars['limit']			Number of items per page
 * @uses int		$vars['count']			Number of items in list
 * @uses string $vars['base_url']	 Base URL to use in links
 * @uses string $vars['offset_key'] The string to use for offset in the URL
*/
$pagination = elgg_view('navigation/pagination', array('count' => $articles_count, 'offset' => $offset, 'limit' => $display_limit, 'base_url' => '?', 'offset_key' => 'offset'));
$pagination = '<div class="pagination">' . $pagination . '</div><div class="clearfloat">';
//$content .= $pagination;
foreach ($articles as $article) {
	//$content .= "$display_limit $offset : $displayed_index $article_index<br />"; // Debug info
	// Pagination : arrêt si on a atteint le maximum
	if ($displayed_index >= $display_limit) { break; }
	
	// @todo Mettre en place une vue pour l'affichage homogène des contenus
	//$content .= elgg_view('externalblog/blog_article', array('full_view' => true));

	// Dédoublonnage - normalement ce n'est pas utile - @TODO à vérifier
	if (isset($listed_article) && in_array($article->guid, $listed_article)) { continue; } 
	else { $listed_article[] = $article->guid; }
	
	// Pagination : on passe à la suite si on n'est pas au bon index
	$article_index++;
	if ($article_index < $offset + 1) { continue; }
	$displayed_index++;
	
	// Article URL
	$article_url = $url . $blogname . '/' . $article->guid . '/' . friendly_title($article->title);
	// Dates
	$article_dates = explode('-', $article->publication_startdate);
	$publication_dates = '<div style="font-size:80%;">';
	if ($article->publication_startdate) $publication_dates .= '<span style="color:grey;">Publié le ' . $article_dates[2] . ' ' . $months[(int)$article_dates[1]] . ' ' . $article_dates[0] . '</span>';
	// Tags
	$publication_tags = '';
	if ($article->tags) foreach ($article->tags as $tag) {
		if (empty($publication_tags)) $publication_tags .= ' &nbsp; <a class="tags" href="' . $blog_base_url . '/category/' . $tag . '">#' . $tag . '</a>';
		else $publication_tags .= ' <a class="tags" href="' . $blog_base_url . '/category/' . $tag . '">#' . $tag . '</a>';
	}
	if (!empty($publication_tags)) $publication_dates .= $publication_tags;
	$publication_dates .= '</div>';
	// Share links
	$share_links = '';
	if (elgg_is_active_plugin('addthis_share')) $share_links = elgg_view('addthis_share/addthis', array('entity' => $article, 'full_view' => true, 'share_url' => $article_url)) . '<div class="clearfloat"></div>';

	if ($externalblog_context == "externalblog_fullview") {
		$content .= '<h2>' . $article->title . '</h2>';
		$content .= $share_links;
		$content .= $publication_dates;
		$content .= '<div>' . $article->description . '</div>';
	} else if ($externalblog_context == "externalblog_gallery") {
		$content .= '<div>' . $article->description . '</div>';
		$content .= $share_links;
		$content .= $publication_dates;
		$content .= '<div class="separator"></div>';
	} else if ($externalblog_context == "externalblog_category") {
		$content .= '<h3><a href="' . $article_url . '">' . $article->title . '</a></h3>';
		$content .= $share_links;
		$content .= $publication_dates;
		$content .= '<div>' . $article->description . '</div>';
		$content .= '<div class="separator"></div>';
	} else {
		$content .= '<h3><a href="' . $article_url . '">' . $article->title . '</a></h3>';
		$content .= $share_links;
		$content .= $publication_dates;
		//$content .= '<div>' . elgg_get_excerpt($article->description) . '</div>';
		$content .= '<div>' . $article->description . '</div>';
		$content .= '<div class="separator"></div>';
	}
	
	if (elgg_is_admin_logged_in()) $content .= '<a href="' . $url . 'blog/edit/' . $article->guid . '">[&nbsp;Modifier&nbsp;]</a>';
	
}
$content .= $pagination;


// Menu latéral
$sidebar = elgg_view('externalblogs/sidebar');



// RENDU DE LA PAGE

// Vue interne pour les membres
if (!$public_view) {
	$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter' => ''));
	// Pour afficher dans le pageshell standard
	echo elgg_view_page($title, $body);
}

// Vue "publique" du blog externe
// Affichage du blog externe, selon les paramètres choisis
if ($public_view) {
	
	if ($externalblog->template == 'custom') {
		// "Custom" : layout prédéfini avec blocs personnalisables
		// Pour afficher dans un pageshell spécifique
		//echo elgg_view_page($title, $body, 'externalblog');
		
		// Sinon on le construit directement ici..
		$layout_header = $externalblog->layout_header;
		$layout_css = $externalblog->layout_css;
		$layout_footer = $externalblog->layout_footer;
		header("Content-type: text/html; charset=UTF-8");
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<?php
	echo '<style>'
		. "\n" . $layout_css . "\n" 
		. '</style>';
	?>
	
</head>
<body>
	<?php echo $layout_header; ?>
	<?php echo $content; ?>
	<?php echo $layout_footer; ?>
</body>
</html>
		<?php
		
	} else if ($externalblog->template == 'zones') {
		// "Zones" : mode expert construction de layout via cmspages notamment
		$zones_css = $externalblog->zones_css;
		header("Content-type: text/html; charset=UTF-8");
		?>
<?php /* @TODO : permettre de remplacer les entêtes par défaut si des entêtes personnalisés sont définis */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<?php /* @TODO : permettre d'insérer des balises dans le head */ ?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Patrick+Hand|Fjalla+One">
	<?php
	echo '<style>'
		. "\n" . $zones_css . "\n" 
		. '</style>';
	?>
</head>
<body>
	<?php
	switch($externalblog_context) {
		case 'externalblog_category':
			$layout = $externalblog->zones_category_layout;
			$layout_config = $externalblog->zones_category;
			break;
		case 'externalblog_listing':
			$layout = $externalblog->zones_listing;
			$layout_config = $externalblog->zones_listing_layout;
			break;
		case 'externalblog_fullview':
			$layout = $externalblog->zones_fullview_layout;
			$layout_config = $externalblog->zones_fullview;
			break;
		case 'externalblog_cmspages':
			$layout = $externalblog->zones_cmspages_layout;
			$layout_config = $externalblog->zones_cmspages;
			break;
		case 'externalblog_home':
		default:
			$layout = $externalblog->zones_home_layout;
			$layout_config = $externalblog->zones_home;
			break;
	}
	echo externalblog_compose_layout($layout, $layout_config, $externalblog_context, $content);
	?>
</body>
</html>
		<?php
		
	} else {
		// Mode par défaut = même layout que le site
		$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter' => ''));
		echo elgg_view_page($title, $body);
	}
}

