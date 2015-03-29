<?php
/**
 * French strings
 */
global $CONFIG;

$fr = array(
	'admin:appearance:menus' => "Gestion des menus",
	
	'elgg_menus:new' => "Nouveau menu",
	'elgg_menus:name' => "Nom du menu",
	'elgg_menus:section' => "Section",
	'elgg_menus:selectedit' => "Menu à éditer",
	'elgg_menus:edit:title' => "Edition du menu",
	'elgg_menus:preview' => "Prévisualiser le menu \"%s\"",
	'elgg_menus:item:edit' => "Edition",
	'elgg_menus:edit:newitem' => "Nouvelle entrée de menu",
	'elgg_menus:add:newitem' => "Ajouter une nouvelle entrée au menu",
	'elgg_menus:edit:newsection' => "Nouvelle section de menu",
	'elgg_menus:edit:newsection:details' => "Pour ajouter une section, créez une entrée utilisant la nouvelle section souhaitée.",
	'elgg_menus:delete' => "Supprimer cette entrée",
	'elgg_menus:delete:confirm' => "Confirmez-vous la suppression de cette entrée de menu ?",
	'elgg_menus:system' => "système",
	'elgg_menus:custom' => "personnalisé",
	'elgg_menus:mode' => "Mode de fonctionnement du menu",
	'elgg_menus:mode:details' => "Les menus personnalisés peuvent fonctionner de 2 manières :<br /> - \"Fusion\" = les entrées du menu sont ajoutées au menu existant (recommandé)<br /> - \"Remplacement\" = les entrées du menu remplacent le menu existant<br />ATTENTION : le remplacement du menu risque de ne pas fonctionner correctement avec les menus pré-définis (ceux du système ou générés par d'autres plugins), car ceux-ci ne sont pas tous définis lors de l'initialisation des plugins.",
	'elgg_menus:mode:merge' => "Fusion",
	'elgg_menus:mode:replace' => "Remplacement",
	'elgg_menus:menu_class' => "Classe (CSS) du menu",
	'elgg_menus:menu_class:details' => "Permet de spécifier des classes CSS précises. Notamment <q>elgg-menu-hz</q> pour un menu horizontal.",
	'elgg_menus:menu_sort_by' => "Tri du menu",
	'elgg_menus:menu_sort_by:details' => "Permet de préciser l'ordre d'affichage des entrées du menu : les options possibles sont 'name', 'priority', 'title' (default), 'register' (registration order) or a php callback (a compare function for usort)",
	'elgg_menus:menu_handler' => "Page handler pour les actions",
	'elgg_menus:menu_handler:details' => "the page handler to build action URLs entity: to use to build action URLs",
	'elgg_menus:menu_show_section_headers' => "Montrer les sections",
	'elgg_menus:menu_show_section_headers:details' => "Désactivé par défaut. Affiche les entêtes avant les sections du menu.",
	
);

add_translation('fr', $fr);

