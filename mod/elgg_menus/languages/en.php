<?php
/**
 * French strings
 */
global $CONFIG;

$en = array(
	'admin:appearance:menus' => "Customp Menus Editor",
	
	'elgg_menus:new' => "New menu",
	'elgg_menus:name' => "Menu name",
	'elgg_menus:name:details' => "Si vous modifiez le nom d'un menu existant, un nouveau menu sera créé avec les élements ci-dessous.",
	'elgg_menus:section' => "Section",
	'elgg_menus:selectedit' => "Menu to edit",
	'elgg_menus:edit:title' => "Menu edition",
	'elgg_menus:preview' => "Preview \"%s\" menu",
	'elgg_menus:preview:details' => "Seules les modifications déjà enregistrées seront affichées.",
	// Edit
	'elgg_menus:item:edit' => "Edition",
	'elgg_menus:edit:newitem' => "New menu item",
	'elgg_menus:add:newitem' => "Add a new menu item",
	'elgg_menus:edit:newsection' => "New menu section",
	'elgg_menus:edit:newsection:details' => "Pour ajouter une section, indiquez le nom de cette section pour l'item souhaité, puis enregistrez vos modifications : la nouvelle section apparaîtra.",
	'elgg_menus:edit:message' => "The cusotm menu \"%s\" has been saved.",
	'elgg_menus:edit:error:empty' => "Error: no menu.",
	// Delete
	'elgg_menus:delete' => "Delete this item",
	'elgg_menus:delete:confirm' => "Confirmez-vous la suppression de cet item ?",
	'elgg_menus:delete:message' => "Le menu personnalisé \"%s\" a bien été supprimé.",
	'elgg_menus:delete:error:empty' => "Error: no menu.",
	// Edit form
	'elgg_menus:settings:yes' => "Yes",
	'elgg_menus:settings:no' => "No",
	'elgg_menus:system' => "default",
	'elgg_menus:custom' => "custom",
	'elgg_menus:mode' => "Menu behaviour mode",
	'elgg_menus:mode:details' => "Les menus personnalisés peuvent fonctionner de 2 manières :<br />
		 - \"Fusion\" = les items configurés ci-dessous sont ajoutés au menu existant. Ceci est le mode recommandé, car il permet à d'autres plugins d'ajouter ou d'enlever des éléments du menu, mais vous permet également de retirer certains de ces items du menu si vous le souhiatez (avec les \"Items à supprimer\")<br />
		  - \"Remplacement\" = les items du menu remplacent et annulent le menu par défaut. A n'utiliser que pour des menus statiques, ou lorsque vous souhaitez contrôler totalement les items du menu. Attention, plus aucun plugin ne pourra enregistrer d'item dans ce menu.<br />
		  ATTENTION : le remplacement du menu risque de ne pas fonctionner correctement avec les menus par défaut (ceux du système ou générés par d'autres plugins), car ceux-ci ne sont pas tous définis lors de l'initialisation des plugins.",
	'elgg_menus:mode:merge' => "Merge (adds items)",
	'elgg_menus:mode:replace' => "Replace (replaces the menu)",
	'elgg_menus:mode:clear' => "Disabled (no menu)",
	'elgg_menus:mode:disabled' => "Default (no change)",
	'elgg_menus:menu_class' => "CSS class",
	'elgg_menus:menu_class:details' => "Permet de spécifier des classes CSS précises pour ce menu.<br />Vous pouvez notamment ajouter <strong>elgg-menu-hz</strong> pour obtenir un menu horizontal.",
	'elgg_menus:menu_sort_by' => "Menu sort order",
	'elgg_menus:menu_sort_by:details' => "Permet de préciser l'ordre d'affichage des items du menu : les options possibles sont <b>name</b>, <b>priority</b>, <b>title</b>, <b>register</b> (ordre d'ajout au menu), ou le <b>nom d'un callback PHP</b> (une fonction de comparaison pour usort()).",
	'elgg_menus:menu_handler' => "Page handler des actions",
	'elgg_menus:menu_handler:details' => "Le page handler pour construire les URLs des actions",
	'elgg_menus:menu_show_section_headers' => "Montrer les sections",
	'elgg_menus:menu_show_section_headers:details' => "Désactivé par défaut. Affiche les entêtes des sections du menu.",
	// Menu item
	'elgg_menus:item:name' => "Id",
	'elgg_menus:item:name:details' => "L'identifiant est une chaine de caractères unique pour un menu donné.",
	'elgg_menus:item:text' => "Name",
	'elgg_menus:item:text:details' => "Titre de l'item du menu tel qu'il sera affiché.",
	'elgg_menus:item:href' => "Link URL",
	'elgg_menus:item:href:details' => "L'adresse du lien, le cas échéant. Peut également être une ancre <strong>#ancre</strong> ou une commande JavaScript.",
	'elgg_menus:item:title' => "Title (tooltip)",
	'elgg_menus:item:title:details' => "Si un titre est défini, le lien comportera une propriété <b>title</b>, permettant d'afficher une infobulle au survol.",
	'elgg_menus:item:confirm' => "Confirmation",
	'elgg_menus:item:confirm:details' => "Facultatif. Si un message de confirmation est défini, il sera affiché lors du clic sur le lien, avec la possibilité d'annuler. Utile principalement pour des actions.",
	'elgg_menus:item:item_class' => "Classe(s) CSS de l'item",
	'elgg_menus:item:item_class:details' => "Classes à ajouter à l'item du menu (sur la balise <b>&lt;li&gt;</b>).",
	'elgg_menus:item:link_class' => "Classe(s) CSS du lien",
	'elgg_menus:item:link_class:details' => "Classes à ajouter au lien de l'item du menu (sur la balise <b>&lt;a&gt;</b>).",
	'elgg_menus:item:section' => "Section",
	'elgg_menus:item:section:details' => "Les items peuvent être regroupés dans plusieurs sections. La section par défaut est appelée 'default'.",
	'elgg_menus:item:priority' => "Priorité",
	'elgg_menus:item:priority:details' => "Une priorité, de 1 à 1000. Les entrées seront affichées par ordre de priorité croissante.",
	'elgg_menus:item:contexts' => "Contexte(s)",
	'elgg_menus:item:contexts:details' => "Les contextes dans lesquels cet item sera affiché. Pour tous, indiquer 'all'. Pour plusieurs contextes, indiquer : 'blog,groups,friends...'",
	'elgg_menus:item:parent_name' => "Identifiant du parent",
	'elgg_menus:item:parent_name:details' => "Si cet item est un sous-menu, indiquer ici l'identifiant de l'item parent. SI le parent est lui-même un sous-menu, plusieurs niveaux imbriqués seront créés.",
	'elgg_menus:item:selected' => "Sélectionné ?",
	'elgg_menus:item:selected:details' => "Permet de marquer cet item comme sélectionné, c'est-à-dire que la classe CSS <b>elgg-state-selected</b> sera ajoutée à cet item.",
	'elgg_menus:menu_remove' => "Items à supprimer (mode \"Fusion\")",
	'elgg_menus:menu_remove:details' => "Si le menu est en mode \"fusion\", vous pouvez définir ici une liste d'items qui seront retirés du menu par défaut. Il s'agit généralement d'items dynamiques (définis par une vue) que vous ne souhaitez pas voir appraître. Cela peut être particulièrement utile si vous ne souhaitez pas remplacer intégralement un menu, mais seulement retirer certains de ses items.",
	'elgg_menus:fieldset:menu_options' => "Paramètres généraux du menu",
	'elgg_menus:fieldset:menu_options:details' => "Ces options s'appliquent avant tout aux menus personnalisés.<br />Elles ne pourront notamment pas être appliquées lorsque vous appelez un menu par la fonction elgg_view_menu(nom_du_menu).<br />A contrario, elles s'appliquent si vous utilisez la vue elgg_menus/menu",
	'elgg_menus:fieldset:menu_items' => "Gestion des items du menu",
	'elgg_menus:edit:items' => "Items du menu",
	'elgg_menus:edit:items:details' => "Selon le mode choisi, ces items seront soit ajoutés au menu par défaut (fusion), soit remplacent ce menu.",
	'elgg_menus:edit:system_menu:details' => "Aucun menu personnalisé n'est encore défini pour ce menu. Les éléments du menu par défaut ont été pré-chargés.<br />Si vous souhaitez créer un menu personnalisé, éditez les éléments ci-dessous et enregistrez votre menu.",
	'elgg_menus:edit:custom_menu:details' => "Les items du menu personnalisé ci-dessous s'ajoutent à ceux du menu par défaut, ou les remplacent, selon le mode choisi.",
	'elgg_menus:edit:new_menu:details' => "Aucun menu n'est encore défini. Vous pouvez créer ce menu en ajoutant des items ci-dessous, puis en enregistrant vos modifications.",
	'elgg_menus:menu:create' => "Créer ce menu",
	'elgg_menus:menu:select' => "Afficher ce menu",
	'elgg_menus:menu:save' => "Enregistrer les modifications",
	'elgg_menus:menu:delete' => "Supprimer le menu personnalisé \"%s\"",
	'elgg_menus:backups' => "Sauvegarde et restauration",
	'elgg_menus:backups:toggle' => "Cliquez pour afficher les options",
	// Import
	'elgg_menus:import' => "Import",
	'elgg_menus:import:title' => "Import custom menu",
	'elgg_menus:import:title:details' => "Vous pouvez restaurer une configuration précédemment enregistrée. Les menus présents dans la sauvegarde s'ajouteront aux menus existants, ou les remplaceront s'ils existent déjà. Les menus personnalisés non présents dans la sauvegarde ne seront pas modifiés.",
	'elgg_menus:import:backup_file' => "Fichier de sauvegarde",
	'elgg_menus:import:filter' => "Nom du menu à importer",
	'elgg_menus:import:filter:details' => "Si vide, importe tous les menus de la sauvegarde. Si un nom de menu est indiqué, seul ce menu sera importé.",
	'elgg_menus:imported:menu' => "Import du menu \"%s\" réussi.",
	// Export
	'elgg_menus:export' => "Exporter",
	'elgg_menus:export:title' => "Exporter la configuration personnalisée",
	'elgg_menus:export:title:details' => "Vous pouvez exporter la configuration actuelle du menu sélectionné, ou de l'ensemble des menus, en cliquant sur l'un des liens suivants. En cas de besoin, vous pourrez les utiliser pour restaurer tous les menus personnalisés, ou l'un d'entre eux séparemment.<br />Attention, seules les modifications enregistrées seront exportées !",
	'elgg_menus:export:all_menus' => "Exporter tous les menus personnalisés",
	'elgg_menus:export:menu' => "Exporter le menu personnalisé \"%s\"",
	'elgg_menus:export:message' => "Les %s menus personnalisés ont bien été exportés. Conservez le fichier %s pour pouvoir les importer ultérieurement.",
	'elgg_menus:export:error:nomenu' => "Error : no menu to export",
	
	'elgg_menus:edit:newsection:prompt' => "New section name",
	
);

add_translation('en', $en);

