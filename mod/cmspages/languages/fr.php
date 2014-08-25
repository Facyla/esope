<?php
$fr = array(
	'cmspages' => "Pages statiques (CMS)",
	'item:object:cmspage' => 'Page statique',
	'item:object:cmspages' => 'Pages statiques',
	
	'cmspages:pagetype' => "Nom de la page (pour l'URL)",
	'cmspages:cmspage_url' => "URL de la page publiée :",
	'cmspages:cmspage_view' => "Affichage de la vue :",
	'cmspages:pageselect' => "Choix de la page à éditer",
	
	'cmspages:new' => "OK",
	'cmspages:newpage' => "Créer la page \"%s\"",
	'cmspages:createmenu' => "Création d'une nouvelle page",
	'cmspages:addnewpage' => "+ Créer une nouvelle page",
	'cmspages:newtitle' => "Cliquer pour choisir le titre de la nouvelle page, puis indiquer l\'identifiant de la page tel qu\'il apparaitra dns l\'URL, et appuyer sur Entrée", // Use as title : use escaping \'
	'cmspages:settitle' => "Cliquer pour modifier le titre",
	'cmspages:create' => "Créer la page !",
	'cmspages:save' => "Mettre à jour la page",
	'cmspages:preview' => "Aperçu",
	'cmspages:delete' => "Détruire la page",
	'cmspages:deletewarning' => "Attention : la destruction d\'une page est irréversible. Vous pouvez également annuler et la rendre privée pour supprimer l\'accès à cette page en perdre le contenu.", // Penser aux antislashs ici ! (JS)
	'cmspages:showinstructions' => "Afficher les explications détaillées",
	'cmspages:instructions' => "Utilisation des pages statiques :<ul>
			<li>ces pages sont accessibles via une URL spécifique (par ex. mainpage)</li>
			<li>elles sont éditables par tout administrateur du site (global et local)</li>
			<li>elles peuvent être intégrées à l'interface du site (lien depuis le menu, le pied de page, etc.)</li>
			<li>leur création/mise à jour ne génère pas l'envoi de notification</li>
			<li>la modification d'une page prend effet immédiatemment, et il n'y a pas d'historique des modifications : attention à ne pas \"vider\" les pages (les pages sans titre ni contenus sont autorisées)</li>
			<li>elles intègrent divers niveaux d'accès selon l'utilisation à en faire : public, connecté, et privé (brouillon)</li>
			<li>pour créer une nouvelle page :
				<ol>
					<li>cliquer sur \"+\"</li>
					<li>saisir le nom qui va apparaître dans l'URL (ce nom ne pourra pas être changé par la suite)</li>
					<li>appuyer sur la touche Entrée (si Javascript est désactivé, cliquer sur le bouton) pour accéder au formulaire d'édition de la nouvelle page</li>
					<li>compléter le formulaire, puis cliquer sur \"Créer la page !\"</li>
				</ol>
				<strong>Attention :</strong> utilisez exclusivement des <strong>caractères alphanumériques en minuscule</strong> dans ce titre de page, <strong>sans espace ni accent ni signe de ponctuation</strong> (restent seuls autorisés : \"-\", \"_\" et \".\")</strong>
			</li>
		</ul>",
	
	/* Status messages */
	'cmspages:posted' => "La page statique a bien été mise à jour.",
	'cmspages:deleted' => "La page statique a bien été supprimée.",
	
	/* Error messages */
	'cmspages:nopreview' => "Aucun aperçu disponible pour le moment",
	'cmspages:notset' => "Cette page n'existe pas, ou vous devez vous connecter pour pouvoir y accéder.",
	'cmspages:delete:fail' => "Un problème est survenu lors de la suppression de la page",
	'cmspages:error' => "Une erreur est survenue, merci de réessayer, ou de contacter l'administrateur si le problème persiste",
	'cmspages:unsettooshort' => "Nom (pour l'URL) de la page non défini ou trop court (minimum : 2 caractères)",
	
	'cmspages:pagescreated' => "%s pages créées",
	
	/* Settings */
	'cmspages:settings:layout' => "Choix de la mise en page par défaut",
	'cmspages:settings:layout:help' => "Ce paramètre permet d'utiliser la configuraiton d'externalblog, si le plugin est activé. Si vous ne savez pas quoi choisir, laissez le choix par défaut.",
	'cmspages:settings:layout:default' => "Par défaut",
	'cmspages:settings:layout:externalblog' => "Utiliser la config d'externalblog",
	'cmspages:settings:editors' => "Editeurs ayant accès à cet outil",
	'cmspages:settings:editors:help' => "Liste des GUID des utilisateurs ayant accès au CMS, séparés par des virgules. Notez que ces éditeurs s'ajoutent aux administrateurs.",
	
	'cmspages:chosenentity' => "Entité choisie (GUID)",
	'cmspages:configuredview' => "Vue configurée",
	'cmspages:module' => "Module %s",
	'cmspages:searchresults' => "Résultats de recherche",
	'cmspages:error:updatedpagetypes' => "Attention : suite au changement de version, les noms internes (pagetype) des pages ont été mis à jour ('_' remplacé par '-'). Suite à cette mise à jour, veuillez sélectionner à nouveau la page à éditer.",
	
	// @TODO : missing translations in other languages
	'cmspages:fieldset:main' => "Principaux paramètres",
	'cmspages:fieldset:advanced' => "Paramètres avancés",
	'cmspages:content_type' => "Type de contenu",
	'cmspages:content_type:editor' => "HTML (avec éditeur de texte)",
	'cmspages:content_type:rawhtml' => "HTML (ne pas charger l'éditeur)",
	'cmspages:content_type:module' => "Module configurable",
	'cmspages:content_type:template' => "Template (agencement de pages et modules CMS)",
	'cmspages:content_type:template:details' => "Utilisation des templates :<ul>
		<li>{{cmspages-pagetype}} : insère le contenu de la page CMS 'cmspages-pagetype'</li>
		<li>{{%CONTENT%}} : insère le contenu chargé par un outil tiers (blogs externes typiquement)</li>
		</ul>",
	'cmspages:content:rawhtml' => "Contenu de la page ou du bloc (code HTML)",
	'cmspages:content:template' => "Structure ou contenu du template",
	'cmspages:content:' => "Contenu de la page ou du bloc",
	'cmspages:templates:list' => "Templates utilisés",
	'cmspages:css' => "CSS personnalisée",
	'cmspages:css:details' => "Cette feuille de style sera ajoutée lors de l'affichage de cette page.",
	'cmspages:js' => "JS personnalisé",
	'cmspages:js:details' => "Ces scripts seront ajoutés lors de l'affichage de cette page.",
	'cmspages:module' => "Module", 
	'cmspages:module:infos' => "Notes : pour un titre, préciser le text. Pour un listing, préciser type, subtype, et optionnellement owner_guids, container_guids, limit et sort, full_view=yes pour inclusion totale du contenu. Pour une recherche : type et criteria. Pour une entité, le guid.",
	'cmspages:module:config' => "Configuration du module (param=value&amp;param2=value2...)",
	'cmspages:contexts' => "Filtre des contextes autorisés (liste, ou rien)",
	'cmspages:contexts:details' => "Si défini, le bloc ne s'affichera que dans ces contextes d'utilisation (par défaut : aucun filtre)",
	'cmspages:display' => "Affichage autonome", 
	'cmspages:display:details' => "vide = oui (par défaut), 'no' pour non (élément d'interface seulement), 'noview' exclusif (page seulement, pas élément d'interface), nom du layout pour utiliser un layout spécifique",
	'cmspages:template:use' => "Utiliser un template",
	'cmspages:template:details' => "Vide = non (par défaut), ou nom du template cmspages pour utiliser un template spécifique",
	//'cmspages:settings:unused' => "Note : These settings are not used yet (future developments)",
	'cmspages:fieldset:unused' => "Note : les paramètres suivants ne sont pas utilisés pour le moment (développements futurs)",
	'cmspages:container_guid' => "GUID du container", 
	'cmspages:parent_guid' => "GUID du parent", 
	'cmspages:sibling_guid' => "GUID du frère", 
	'cmspages:container' => "Container", 
	'cmspages:parent' => "Parent", 
	'cmspages:sibling' => "Frère", 
	'cmspages:module:' => "Aucun (bloc vide)", 
	'cmspages:module:title' => "Titre", 
	'cmspages:module:listing' => "Liste d\'entités", 
	'cmspages:module:search' => "Résultats de recherche", 
	'cmspages:module:entity' => "Entité", 
	'cmspages:module:view' => "Vue configurable", 
	/* @TODO : missing translations
	'cmspages:' => "Lien connexe", 
	'cmspages:' => "<kbd>[&nbsp;Modifier%s&nbsp;]</kbd>", 
	'cmspages:' => "Pour éditer les pages CMS, rendez-vous sur", 
	'cmspages:' => "Vue non configurée.",
	*/
	
	
);

add_translation("fr",$fr);

