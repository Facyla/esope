<?php
$fr = array(
	'cmspages' => "Pages statiques (CMS)",
	'item:object:cmspage' => '<i class="fa fa-file-code-o fa-fw"></i> Page statique',
	'item:object:cmspages' => '<i class="fa fa-file-code-o fa-fw"></i> Pages statiques',
	
	'cmspages:pagetype' => "Permalien",
	'cmspages:cmspage_url' => "URL de la page publiée :",
	'cmspages:cmspage_view' => "Affichage de la vue :",
	'cmspages:pageselect' => "Choix de la page à éditer",
	
	'cmspages:new' => "OK",
	'cmspages:newpage' => "Créer la page \"%s\"",
	'cmspages:createmenu' => "Création d'une nouvelle page",
	'cmspages:addnewpage' => "+ Créer une nouvelle page",
	'cmspages:newtitle' => "Indiquer le nom de la nouvelle page, puis appuyer sur Entrée", // Use as title : use escaping \'
	'cmspages:settitle' => "Cliquer pour modifier le titre",
	'cmspages:create' => "Créer la page !",
	'cmspages:save' => "Mettre à jour la page",
	'cmspages:preview' => "Aperçu",
	'cmspages:delete' => "Détruire la page",
	'cmspages:deletewarning' => "Attention : la destruction d'une page est irréversible. Si vous souhaitez seulement la dé-publier, vous pouvez modifier son niveau d'accès sans en perdre le contenu.",
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
	'cmspages:unsettooshort' => "Nom (pour l'URL) de la page non défini ou trop court (au moins 1 caractère)",
	
	'cmspages:pagescreated' => "%s pages créées",
	
	/* Settings */
	'cmspages:settings:layout' => "Choix de la mise en page par défaut",
	'cmspages:settings:layout:help' => "Ce paramètre permet d'utiliser la configuration d'externalblog, si le plugin est activé. Si vous ne savez pas quoi choisir, laissez le choix par défaut.",
	'cmspages:settings:layout:default' => "Par défaut",
	'cmspages:settings:layout:externalblog' => "Utiliser la config d'externalblog",
	'cmspages:settings:editors' => "Liste des éditeurs supplémentaires",
	'cmspages:settings:editors:help' => "Liste des GUID des membres, séparés par des virgules.<br />Les éditeurs ont un accès en lecture et écriture à l'ensemble des pages CMS. Ces éditeurs s'ajoutent aux administrateurs.<br />Développeurs : pour définir les éditeurs selon des critères précis, veuilllez utiliser le hook 'cmspages:edit', 'cmspage'.",
	
	'cmspages:chosenentity' => "Entité choisie (GUID)",
	'cmspages:configuredview' => "Vue configurée",
	'cmspages:module' => "Module %s",
	'cmspages:searchresults' => "Résultats de recherche",
	'cmspages:error:updatedpagetypes' => "Attention : suite au changement de version, les noms internes (pagetype) des pages ont été mis à jour ('_' remplacé par '-'). Suite à cette mise à jour, veuillez sélectionner à nouveau la page à éditer.",
	
	'cmspages:or' => "ou",
	
	// @TODO : missing translations in other languages
	'cmspages:fieldset:main' => "Principaux paramètres",
	'cmspages:fieldset:advanced' => "Paramètres avancés",
	'cmspages:content_type' => "Type de contenu",
	'cmspages:content_type:details' => "Les pages CMS peuvent être de divers types : les 2 premiers sont à utiliser pour afficher simplement du contenu. Les \"modules\" permettent de définir des blocs de contenu dynamique. Les \"templates\" servent à définir des gabarits qui peuvent être utilisés pour l'affichage d'autres pages CMS, ou pour des mises en pages complexes.",
	'cmspages:content_type:editor' => "HTML (avec éditeur de texte)",
	'cmspages:content_type:rawhtml' => "HTML (ne pas charger l'éditeur)",
	'cmspages:content_type:module' => "Module configurable",
	'cmspages:content_type:template' => "Template (agencement de pages et modules CMS)",
	'cmspages:content_type:template:details' => "Utilisation des templates :<ul>
		<li>{{cmspages-pagetype}} : insère le contenu de la page CMS 'cmspages-pagetype'</li>
		<li>{{%CONTENT%}} : insère le contenu chargé dans la vue par un outil tiers via le paramètre 'content'</li>
		<li>{{[shortcode]}} : insère le shortcode 'shortcode' (si le plugin elgg_shortcode est activé)</li>
		<li>{{:forms/register|username=admin}} : insère la vue forms/register en lui passant le paramètres 'username' => 'admin'</li>
		</ul>",
	'cmspages:content:rawhtml' => "Contenu de la page ou du bloc (code HTML)",
	'cmspages:content:template' => "Structure ou contenu du template",
	'cmspages:content:' => "Contenu de la page ou du bloc",
	'cmspages:templates:list' => "Templates utilisés",
	'cmspages:css' => "Styles personnalisés",
	'cmspages:css:details' => "Les feuilles de style CSS définies ici seront ajoutées lors de l'affichage de cette page.",
	'cmspages:js' => "JS personnalisé",
	'cmspages:js:details' => "Les scripts définis ici seront ajoutés lors de l'affichage de cette page.",
	'cmspages:module' => "Module", 
	'cmspages:module:infos' => "Notes : pour un titre, préciser le text. Pour un listing, préciser type, subtype, et optionnellement owner_guids, container_guids, limit et sort, full_view=yes pour inclusion totale du contenu. Pour une recherche : type et criteria. Pour une entité, le guid.",
	'cmspages:module:config' => "Configuration du module (param=value&amp;param2=value2...)",
	'cmspages:contexts' => "Filtre des contextes autorisés",
	'cmspages:contexts:details' => "Aucun filtre ne s'applique par défaut. Si un ou plusieurs filtres sont définis, ils permettent de n'afficher la page que si le contexte d'utilisation fait partie des contextes autorisés.",
	'cmspages:display' => "Affichage pleine page", 
	'cmspages:display:details' => "Permet de choisir comment afficher cette page de manière autonome (avec une URL propre). Par défaut la page peut être utilisée comme élément d'interface ou comme page autonome. Les options permettent d'interdire l'affichage pleine page (no), ou de n'autoriser que l'affichage pleine page pour une utilisation comme élément d'interface uniquement (noview).",
	//'cmspages:layout:details' => "Permet de choisir le layout pour afficher cette page de manière autonome (avec une URL propre). Les options permettent de choisir le layout à utiliser pour le rendu de la page, de ne permettre que l'affichage pleine page avec le layout par défaut (noview), ou d'interdire l'affichage pleine page (no), pour une utilisation comme élément d'intrerface uniquement.<br />Important : lors d'un \"embed\" de la page, le layout n'est pas utilisé.",
	'cmspages:template:use' => "Format d'affichage (template)",
	'cmspages:template:details' => "Permet d'utiliser un format d'affichage prédéfini, en injectant le contenu de cette page dans un template HTML créé avec cmspages. Laisser vide pour afficher tel quel le contenu de cette page. Pour créer un nouveau template, créez une page de type \"template\".",
	//'cmspages:settings:unused' => "Note : These settings are not used yet (future developments)",
	'cmspages:fieldset:unused' => "DEV : NON UTILISE (développements futurs)",
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
	
	'cmspages:categories' => "Rubrique(s)",
	'cmspages:slurl' => "Permalien",
	'cmspages:shorturl' => "URL courte",
	'cmspages:featured_image' => "Image en Une",
	'cmspages:featured_image:view' => "Afficher l'image en Une",
	'cmspages:notexist:create' => "Cette page n'existe pas. Vous avez pu faire une erreur dans l'URL (attention aux '_', remplacés par des '-'), sinon vous pouvez cliquer sur le lien ci-dessous pour créer une nouvelle page à cette adresse.",
	'cmspages:edit' => "[&nbsp;Modifier %s&nbsp;]",
	'cmspages:createnew' => "[&nbsp;Créer %s&nbsp;]",
	'cmspages:templates:parameters' => "Paramètres de contenu",
	'cmspages:templates:shortcodes' => "Shortcodes",
	'cmspages:templates:views' => "Vues",
	'cmspages:editors:list' => "Liste des éditeurs",
	'cmspages:authors:list' => "Liste des Auteurs",
	'cmspages:editurl' => "Pour éditer les pages CMS, rendez-vous sur",
	
	'cmspages:cms_mode' => "Mode CMS",
	'cmspages:settings:cms_mode' => "Activer le mode CMS",
	'cmspages:settings:cms_mode:details' => "Ce mode permet d'utiliser CMSPages pour gérer les pages d'un site. Il propose des adresses de pages optimisées pour le SEO, et des options plus avancées de gestion du rendu.",
	'cmspages:settings:layout:details' => "Permet de choisir l'agencement du contenu dans la page. Par défaut la page s'affiche en pleine largeur, mais vous pouvez également choisir un gabarit à 1 ou 2 colonnes, ou définir un gabarit personnalisé.",
	'cmspages:settings:pageshell' => "Coquille HTML",
	'cmspages:settings:pageshell:details' => "Permet de choisir la structure HTML du site. Par défaut la page sera affichée au sein de l'interface habituelle du site (entête, menu, pied de page), mais vous pouvez également définir une structure personnalisée.",
	'cmspages:editlayout' => "Editer le layout personnalisé",
	'cmspages:layout:sidebar' => "Editer la colonne droite",
	'cmspages:layout:sidebar_alt' => "Editer la colonne gauche",
	'cmspages:editpageshell' => "Définir/modifier le pageshell personnalisé",
	
	'cmspages:fieldset:seo' => "Options SEO",
	'cmspages:seo:title' => "Titre",
	'cmspages:seo:title:details' => "Maximum 60 caractères. Si vide, le titre de la page sera utilisé.",
	'cmspages:seo:description' => "META Description",
	'cmspages:seo:description:details' => "La plupart des moteurs prendront en compte un maximum de 160 caractères.",
	'cmspages:seo:tags' => "META Tags",
	'cmspages:seo:tags:details' => "Veuillez saisir une liste des mots-clefs les plus importants pour décrire cette page dans le champ \"Mots-clefs\". Pour un meilleur référencement, il est utile que ces termes figurent dans le texte de la page.",
	'cmspages:seo:index' => "Robots : index",
	'cmspages:seo:index:details' => "Indique aux robots d'indexer ou de ne pas indexer cette page",
	'cmspages:seo:follow' => "Robots : follow",
	'cmspages:seo:follow:details' => "Indique aux robots de suivre ou de ne pas suivre les liens présents sur cette page",
	'cmspages:seo:canonical' => "Lien canonique",
	'cmspages:seo:canonical:details' => "Si cette page est accessible via plusieurs URL, indique l'URL de la page \"principale\". Par défaut, l'URL canonique indiquée est celle du permalien.",
	
	'cmspages:edit:title' => "Edition de la page \"%s\"",
	'cmspages:alreadyexists' => "Cette adresse existe déjà, veuillez en choisir une autre",
	
	'cmspages:fieldset:rendering' => "Modes de rendu",
	'cmspages:fieldset:publication' => "Publication",
	'cmspages:fieldset:categories' => "Rubriquage",
	'cmspages:access:current' => "Accès actuel",
	
	'cmspages:error:nodisplay' => "Vous n'avez pas l'autorisation d'accéder à cette page.",
	'cmspages:notice:changedurl' => "L'adresse de cette page a changé, veuillez mettre à jour vos marque-pages.",
	
	'cmspages:type:' => "HTML",
	'cmspages:type:editor' => "HTML",
	'cmspages:type:rawhtml' => "HTML",
	'cmspages:type:module' => "Module",
	'cmspages:type:template' => "Template",
	'cmspages:notice:newpage' => "Création d'une nouvelle page.",
	'cmspages:pageselect:filter' => "Filtres de recherche",
	
);

add_translation("fr",$fr);

