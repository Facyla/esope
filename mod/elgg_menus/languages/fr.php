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
	'elgg_menus:edit:newitem' => "Nouvel item",
	'elgg_menus:add:newitem' => "Ajouter un nouvel item",
	'elgg_menus:edit:newsection' => "Nouvelle section de menu",
	'elgg_menus:edit:newsection:details' => "Pour ajouter une section, indiquez le nom de cette section pour l'item souhaité.",
	'elgg_menus:delete' => "Supprimer cette item",
	'elgg_menus:delete:confirm' => "Confirmez-vous la suppression de cet item ?",
	'elgg_menus:system' => "système",
	'elgg_menus:custom' => "personnalisé",
	'elgg_menus:mode' => "Mode de fonctionnement du menu",
	'elgg_menus:mode:details' => "Les menus personnalisés peuvent fonctionner de 2 manières :<br /> - \"Fusion\" = les items du menu sont ajoutés au menu existant (recommandé)<br /> - \"Remplacement\" = les items du menu remplacent le menu existant<br />ATTENTION : le remplacement du menu risque de ne pas fonctionner correctement avec les menus pré-définis (ceux du système ou générés par d'autres plugins), car ceux-ci ne sont pas tous définis lors de l'initialisation des plugins.",
	'elgg_menus:mode:merge' => "Fusion",
	'elgg_menus:mode:replace' => "Remplacement",
	'elgg_menus:menu_class' => "Classe (CSS) du menu",
	'elgg_menus:menu_class:details' => "Permet de spécifier des classes CSS précises. Notamment <q>elgg-menu-hz</q> pour un menu horizontal.",
	'elgg_menus:menu_sort_by' => "Tri du menu",
	'elgg_menus:menu_sort_by:details' => "Permet de préciser l'ordre d'affichage des items du menu : les options possibles sont 'name', 'priority', 'title' (default), 'register' (registration order) or a php callback (a compare function for usort)",
	'elgg_menus:menu_handler' => "Page handler pour les actions",
	'elgg_menus:menu_handler:details' => "Le page handler to build action URLs entity: to use to build action URLs",
	'elgg_menus:menu_show_section_headers' => "Montrer les sections",
	'elgg_menus:menu_show_section_headers:details' => "Désactivé par défaut. Affiche les entêtes avant les sections du menu.",
	
	'elgg_menus:item:name' => "Identifiant",
	'elgg_menus:item:text' => "Titre de l'item",
	'elgg_menus:item:href' => "URL du lien",
	'elgg_menus:item:name' => "Nom (interne)",
	'elgg_menus:item:title' => "Titre (infobulle)",
	'elgg_menus:item:title:details' => "Si un titre est défini, le lien comportera une propriété 'title', permettant d'afficher une infobulle au survol.",
	'elgg_menus:item:confirm' => "Confirmation",
	'elgg_menus:item:confirm:details' => "Facultatif. Si un message de confirmation est défini, il sera affiché lors du clic sur le lien, avec la possibilité d'annuler. Utile principalement pour des actions.",
	'elgg_menus:item:item_class' => "Classe CSS de l'item",
	'elgg_menus:item:link_class' => "Classe CSS du lien",
	'elgg_menus:item:section' => "Section",
	'elgg_menus:item:section:details' => "Les items peuvent ^etre regroupés dans plusieurs sections. La section par défaut est appelée 'default'.",
	'elgg_menus:item:priority' => "Priorité",
	'elgg_menus:item:priority:details' => "Une priorité, de 1 à 1000. Les entrées seront affichées par ordre de priorité croissante.",
	'elgg_menus:item:contexts' => "Contexte(s)",
	'elgg_menus:item:contexts:details' => "Les contextes dans lesquels cet item sera affiché. Pour tous, indiquer 'all'. Pour plusieurs contextes, indiquer : 'blog,groups,friends...'",
	'elgg_menus:item:selected' => "Sélectionné ?",
	'elgg_menus:item:parent_name' => "Identifiant du parent",
	
);

add_translation('fr', $fr);

