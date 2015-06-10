<?php
$plugin = $vars['entity'];

// Set options
$yn_opts = array('yes' => elgg_echo('survey:settings:yes'), 'no' => elgg_echo('survey:settings:no'));
$layout_opts = cmspages_layouts_opts(false);
$pageshell_opts = cmspages_pageshells_opts(false);
$header_opts = cmspages_headers_opts(false);
$cms_menus_opt = cmspages_menus_opts(false);
$footer_opts = cmspages_footers_opts(false);

// Set defaults
//if (!isset($plugin->cms_mode)) $plugin->cms_mode = 'no';
if (!isset($plugin->layout)) $plugin->layout = 'one_column';
if (!isset($plugin->pageshell)) $plugin->pageshell = 'default';
if (!isset($plugin->cms_menu)) $plugin->cms_menu = 'cmspages_categories';
if (!isset($plugin->cms_header)) $plugin->cms_header = 'initial';
if (!isset($plugin->cms_footer)) $plugin->cms_footer = 'initial';



echo '<p>' . elgg_echo('cmspages:editurl') . ' <a href="' . $vars['url'] . 'cmspages/" class="elgg-button elgg-button-action" target="_blank">' . $vars['url'] . 'cmspages/</a></p>';

echo '<fieldset><legend>' . elgg_echo('cmspages:fieldset:access') . '</legend>';

	echo '<p><label style="clear:left;">' . elgg_echo('cmspages:settings:editors') . '</label>';
	echo elgg_view('input/text', array('name' => 'params[editors]', 'value' => $plugin->editors)) . '<br />';
	echo '<em>' . elgg_echo('cmspages:settings:editors:help') . '</em>';
	$editors = explode(',', $plugin->editors);
	// Affichage des éditeurs actuels
	$users_count = elgg_get_entities(array('types' => 'user', 'guids' => $editors, 'count' => true));
	if ($users_count > 0) {
		$users = elgg_get_entities(array('types' => 'user', 'guids' => $editors, 'limit' => 100));
		echo '<br /><strong>' . elgg_echo('cmspages:editors:list') . ' :</strong>';
		foreach ($users as $ent) {
			echo $ent->name . ' (' . $ent->guid . '), ';
		}
		if ($users_count > 100) echo '...';
	}
	echo '</p>';

	/* Auteurs */
	echo '<p><label style="clear:left;">DEV - NON OPERATIONNEL ' . elgg_echo('cmspages:settings:authors') . '</label>';
	echo elgg_view('input/text', array('name' => 'params[authors]', 'value' => $plugin->authors)) . '<br />';
	//echo elgg_view('input/userpicker', array('name' => 'params[authors]', 'id' => 'cmspages-authors', 'value' => $plugin->authors));
	$authors = explode(',', $plugin->authors);
	echo elgg_echo('cmspages:settings:authors:help');
	// Affichage des auteurs actuels
	$users_count = elgg_get_entities(array('types' => 'user', 'guids' => $authors, 'count' => true));
	if ($users_count > 0) {
		$users = elgg_get_entities(array('types' => 'user', 'guids' => $authors, 'limit' => 100));
		echo '<br /><strong>' . elgg_echo('cmspages:authors:list') . ' :</strong>';
		foreach ($users as $ent) {
			echo $ent->name . ' (' . $ent->guid . '), ';
		}
		if ($users_count > 100) echo '...';
	}
	echo '</p>';

echo '</fieldset>';



echo '<fieldset><legend>' . elgg_echo('cmspages:fieldset:categories') . '</legend>';

	// CMSPAGES TREE CATEGORIES
	echo '<p><label>' . elgg_echo('cmspages:settings:categories') . ' ';
	echo elgg_view('input/plaintext', array('name' => 'params[categories]', 'value' => $plugin->categories));
	echo '</label>';
	echo '<br /><em>' . elgg_echo('cmspages:settings:categories:details') . '</em>';
	echo '</p>';

	// Categories : arborescence par indentation avec des tirets...
	// On pré-traite le contenu pour générer un array PHP qu'on va stocker (sérialisé), 
	// au lieu de devoir tout reconstruire à chaque appel
	// Returns : array prêt pour construire un menu <=> array d'entrées avec un parent_name
	if ($plugin->categories) {
		$menu_categories = array();
		$menu_cats = esope_get_input_array($plugin->categories, "\n");
		if (count($menu_cats) > 0) {
			$parents = array(); // dernier parent pour chaque niveau de l'arborescence
			$i = 0; // Used to avoid duplicates
			foreach ($menu_cats as $key => $cat) {
				$i++;
				// Niveau dans l'arborescence
				$level = 0;
				while($cat[0] == '-') {
					$cat = substr($cat, 1);
					$level++;
				}
				// Correction auto des sous-niveaux utilisant trop de tirets (saut de 3 à 5 par ex.)
				// eg. level = 3 avec sizeof(parent) = 1 (soit niveau 0) => level corrigé à 1
				// Note : pour la première entrée, on aura toujours level == 0
				if ($level > sizeof($parents)) { $level = sizeof($parents); }
				// Gestion des nouvelles entrées et sous-niveaux, après la 1ère entrée
				if (sizeof($parents) > 0) {
					// Niveau supérieur : 
					while((sizeof($parents) > 1) && ($level < (sizeof($parents) - 1))) {
						// Suppression du dernier sous-niveau
						array_pop($parents);
					}
				}
				// Vérification du nom
				$name = elgg_get_friendly_title($cat);
				// Limitation des doublons
				if (isset($menu_categories[$name])) {
					$name .= $i;
					register_error(elgg_echo('cmspages:error:duplicate'));
				}
				// Dernier parent connu pour le niveau courant
				$parents["$level"] = $name;
				
				$menu_cat = array('name' => $name, 'title' => $cat);
				// Get immediate parent
				if ($level > 0) {
					$parent_name = $parents[(int) ($level-1)];
					$menu_cat['parent'] = $parent_name;
				}
				$menu_categories[$name] = $menu_cat;
			}
		}
		$menu_categories_data = serialize($menu_categories);
		elgg_set_plugin_setting('menu_categories', $menu_categories_data, 'cmspages');
	}
	//echo '<pre>' . print_r($menu_categories, true) . '</pre>';
	//cmspages_set_categories_menu();
	echo elgg_view_menu('cmspages_categories', array('sort_by' => 'weight', 'class' => "elgg-menu-hz"));

echo '</fieldset>';




/* Mode "CMS"
	- permet de définir les layouts à utiliser (par défaut avec interface du site, ou layout personnalisé)
	- si layout personnalisé, définition des zones
*/
echo '<fieldset><legend>' . elgg_echo('cmspages:fieldset:rendering') . '</legend>';
	
	/* Unused : let's use it by default
	echo '<p><label>' . elgg_echo('cmspages:settings:cms_mode') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[cms_mode]', 'value' => $plugin->cms_mode, 'options_values' => $yn_opts));
	echo '</label><br />' . elgg_echo('cmspages:settings:cms_mode:details');
	echo '</p>';
	*/
	
	// Default layout : existing, or custom
	// @TODO allow to use arbitrary layout ?  eg. template selector instead of 1 predefined template name ?
	echo '<p><label>' . elgg_echo('cmspages:settings:layout') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[layout]', 'value' => $plugin->layout, 'options_values' => $layout_opts)) . '</label>';
	echo ' &nbsp; <a href="' . $vars['url'] . 'cmspages/cms-layout-sidebar" target="_blank" class="elgg-button">' . elgg_echo('cmspages:layout:sidebar:edit') . '</a>';
	echo ' &nbsp; <a href="' . $vars['url'] . 'cmspages/cms-layout-sidebar-alt" target="_blank" class="elgg-button">' . elgg_echo('cmspages:layout:sidebar_alt:edit') . '</a>';
	echo ' &nbsp; <a href="' . $vars['url'] . 'cmspages/cms-layout" target="_blank" class="elgg-button">' . elgg_echo('cmspages:layout:custom:edit') . '</a>';
	echo '<br /><em>' . elgg_echo('cmspages:settings:layout:details') . '</em>';
	echo '</p>';
	
	// Default pageshell : default / iframe (no Elgg interface) / or custom
	echo '<p><label>' . elgg_echo('cmspages:settings:pageshell') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[pageshell]', 'value' => $plugin->pageshell, 'options_values' => $pageshell_opts));
	echo '</label> &nbsp; <a href="' . $vars['url'] . 'cmspages/cms-pageshell" target="_blank" class="elgg-button">' . elgg_echo('cmspages:pageshell:edit') . '</a>';
	echo '<br /><em>' . elgg_echo('cmspages:settings:pageshell:details') . '</em>';
	echo '</p>';
	
	// Default header : default, or custom cmspage
	echo '<p><label>' . elgg_echo('cmspages:settings:cms_header') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[cms_header]', 'value' => $plugin->cms_header, 'options_values' => $header_opts));
	echo '</label> &nbsp; <a href="' . $vars['url'] . 'cmspages/cms-header" target="_blank" class="elgg-button">' . elgg_echo('cmspages:cms_header:edit') . '</a>';
	echo '<br /><em>' . elgg_echo('cmspages:settings:cms_header:details') . '</em>';
	echo '</p>';
	
	// Menu CMS : categories ?  ou menu personnalisé
	if (elgg_is_active_plugin('elgg_menus')) {
		echo '<p><label>' . elgg_echo('cmspages:settings:cms_menu') . ' ';
		echo elgg_view('input/dropdown', array('name' => 'params[cms_menu]', 'value' => $plugin->cms_menu, 'options_values' => $cms_menus_opt));
		echo '</label><br /><em>' . elgg_echo('cmspages:settings:cms_menu:details') . '</em>';
		echo '</p>';
	}
	
	// Default footer : default, or custom cmspage
	echo '<p><label>' . elgg_echo('cmspages:settings:cms_footer') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[cms_footer]', 'value' => $plugin->cms_footer, 'options_values' => $footer_opts));
	echo '</label> &nbsp; <a href="' . $vars['url'] . 'cmspages/cms-footer" target="_blank" class="elgg-button">' . elgg_echo('cmspages:cms_footer:edit') . '</a>';
	echo '<br /><em>' . elgg_echo('cmspages:settings:cms_footer:details') . '</em>';
	echo '</p>';
	
echo '</fieldset>';


