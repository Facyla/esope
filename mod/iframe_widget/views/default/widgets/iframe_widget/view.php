<div class="contentWrapper">
	<?php
	global $CONFIG;
	
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');
	
	$iframe_url = $vars['entity']->iframe_url;
	$iframe_title = $vars['entity']->iframe_title;
	//if (empty($iframe_title)) { $iframe_title = $iframe_url; }
	$iframe_height = $vars['entity']->iframe_height;  // ajouter dans params possibilité de modifier la taille de l'iframe (en hauteur seulement), avec valeur par défaut - ou reprendre cette idée de fullscreen-on-hover -via case à cocher)
	if (empty($iframe_height)) { $iframe_height = '600'; }
	if (is_int($iframe_height)) { $iframe_height .= 'px'; }
	
	// Rendu de l'iframe
	if (!empty($iframe_url)) {
		echo '<div class="iframe_item">';
		if ($iframe_title) {
			echo '<div class="iframe_title"><h4><a href="' . $iframe_url . '">' . $iframe_title . '</a></h4></div>';
		}
		// Lightbox : version manuelle.. (pas le mieux)
		//echo '<a rel="nofollow" class="elgg-lightbox iframe" href="#elgg-lightbox-' . $vars['entity']->guid . '" >Afficher en plein écran</a><br />';
		//echo '<iframe class="iframe-widget" id="elgg-lightbox-' . $vars['entity']->guid . '" src="' . $iframe_url . '" style="width:100%; height:' . $iframe_height . '"></iframe>';
		// Lien fullscreen avec lightbox - cf. http://fancybox.net/howto
		echo '<a rel="nofollow" class="elgg-lightbox" href="' . $iframe_url . '?iframe" >Afficher en plein écran</a><br />';
		echo '<iframe src="' . $iframe_url . '" style="width:100%; height:' . $iframe_height . '"></iframe>';
		echo '</div>';
	} else {
		if (elgg_get_logged_in_user_guid () == elgg_get_page_owner_guid()) {
			echo '<p>' . elgg_echo('iframe:notset') . '</p>';
		}
	}
	?>
</div>
