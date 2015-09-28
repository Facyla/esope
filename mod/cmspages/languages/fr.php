<?php
$fr = array(
	'cmspages' => "Pages CMS",
	'item:object:cmspage' => '<i class="fa fa-file-code-o fa-fw"></i>Page CMS',
	'item:object:cmspages' => '<i class="fa fa-file-code-o fa-fw"></i>Pages CMS',
	
	'cmspages:pagetype' => "<i class=\"fa fa-link\"></i>URL de la page (permalien)", // link ou anchor
	'cmspages:cmspage_url' => "<i class=\"fa fa-link\"></i>URL de la page (permalien)",
	'cmspages:cmspage_view' => "<i class=\"fa fa-plug\"></i>Intégration dans Elgg",
	'cmspages:cmspage_embed' => "<i class=\"fa fa-code\"></i>Code d'embarquement HTML",
	'cmspages:cmspage_template' => "<i class=\"fa fa-puzzle-piece\"></i>Utilisation dans un gabarit",
	'cmspages:pageselect' => "Editer une page",
	'cmspages:page:new' => "Créer une page",
	'cmspages:page:new:name' => "Indiquer ici le nom de la nouvelle page",
	
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
	'cmspages:showinstructions' => "Mode d'emploi &nbsp; <i class=\"fa fa-toggle-down\"></i>",
	'cmspages:instructions' => "<ul>
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
	'cmspages:posted' => "La page CMS a bien été mise à jour.",
	'cmspages:deleted' => "La page CMS a bien été supprimée.",
	
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
	'cmspages:settings:editors:help' => "Liste des GUID des membres, séparés par des virgules.<br />Les éditeurs ont un accès en lecture et écriture à l'ensemble des pages CMS.<br />Tous les administrateurs sont éditeurs, mais vous pouvez ajouter d'autres éditeurs qui auront un accès total aux pages CMS, à l'exception de cette page de configuration.<br /><i class=\"fa fa-info-circle\"></i> Développeurs : pour définir les éditeurs selon des critères précis, veuilllez utiliser le hook 'cmspages:edit', 'cmspage'.",
	'cmspages:settings:authors' => "Liste des auteurs supplémentaires",
	'cmspages:settings:authors:help' => "Liste des GUID des membres, séparés par des virgules.<br />Les auteurs ont un accès limité à leurs propres articles.<br /><i class=\"fa fa-info-circle\"></i> Développeurs : pour définir les éditeurs selon des critères précis, veuilllez utiliser le hook 'cmspages:edit:authors', 'cmspage'.",
	
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
	'cmspages:content_type:details' => "Les pages CMS peuvent être de divers types : les 2 premiers sont à utiliser pour afficher simplement du contenu. Les \"modules\" permettent de définir des blocs de contenu dynamique. Les \"gabarits\" servent à définir des modèles d'affichage qui peuvent être utilisés pour l'affichage de contenus, et des mises en pages complexes, faisant appels à divers autres pages CMS et éléments de contenu.",
	'cmspages:content_type:editor' => "Contenu (HTML avec éditeur visuel)",
	'cmspages:content_type:rawhtml' => "Code source (HTML sans éditeur)",
	'cmspages:content_type:module' => "Module configurable",
	'cmspages:content_type:template' => "Gabarit",
	'cmspages:content:rawhtml' => "Contenu de la page ou du bloc (code HTML)",
	'cmspages:content:template' => "Structure ou contenu du gabarit",
	'cmspages:content:' => "Contenu de la page ou du bloc",
	'cmspages:templates:list' => "Eléments utilisés",
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
	'cmspages:template:use' => "Gabarit (template)",
	'cmspages:template:details' => "Permet d'utiliser un gabarit d'affichage prédéfini, en injectant le contenu de cette page dans le gabarit HTML créé avec CMSPages. Laisser vide pour afficher tel quel le contenu de cette page. Pour créer un nouveau gabarit, créez une page de type \"gabarit\".<br />Attention : les pages de type gabarit ne peuvent pas spécifier de gabarit d'affichage.",
	'cmspages:layout:use' => "Mise en page (layout)",
	'cmspages:layout:details' => "Affichage pleine page seulement. Permet de modifier la mise en page interne de la page (nombre de colonnes)",
	'cmspages:pageshell:use' => "Coquille HTML (pageshell)",
	'cmspages:pageshell:details' => "Affichage pleine page seulement. Permet de modifier la coquille HTML de la page (organisation des blocs dans la page).",
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
	'cmspages:shorturl' => "<i class=\"fa fa-external-link\"></i>URL courte", // link, compress, retweet, quote-left, external-link
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
	'cmspages:settings:layout:details' => "Par défaut, les pages CMS s'affichent avec le layout \"one_column\" (1 seule colonne), mais vous pouvez choisir de les afficher en utilisant un autre layout (modèle d'agencement du contenu dans la page), par ex. un layout à 2 ou 3 colonnes, ou définir un gabarit personnalisé pour une personnalisation maximale.",
	'cmspages:settings:pageshell' => "Coquille HTML",
	'cmspages:settings:pageshell:details' => "Pour un contrôle total sur la structure HTML du site, vous pouvez utiliser d'autres \"pageshells\" (coquille HTML). Par défaut la page sera affichée dans l'interface habituelle du site (avec entête, menu, pied de page), mais vous pouvez également utiliser le pageshell \"iframe\" (qui conserve les styles mais pas l'interface), ou définir un pageshell personnalisé pour un contrôle total sur le rendu.",
	'cmspages:layout:custom:edit' => "Editer le layout personnalisé",
	'cmspages:layout:sidebar:edit' => "Editer la colonne droite",
	'cmspages:layout:sidebar_alt:edit' => "Editer la colonne gauche",
	'cmspages:pageshell:edit' => "Editer le pageshell personnalisé",
	'cmspages:layout:one_column' => "1 colonne",
	'cmspages:layout:one_sidebar' => "2 colonnes (menu droit)",
	'cmspages:layout:two_sidebar' => "3 colonnes (menu gauche + droit)",
	'cmspages:layout:custom' => "Personnalisé (cms-layout)",
	'cmspages:layout:' => "Par défaut (identique au site)",
	'cmspages:pageshell:default' => "Site (par défaut)",
	'cmspages:pageshell:cmspages' => "Site pleine largeur (sans marge)", 
	'cmspages:pageshell:cmspages_cms' => "Site pleine largeur + menu CMS", 
	'cmspages:pageshell:iframe' => "Iframe (sans interface)",
	'cmspages:pageshell:inner' => "Contenu brut (pour AJAX)",
	'cmspages:pageshell:custom' => "Personnalisé (cms-pageshell)",
	'cmspages:pageshell:' => "Par défaut (identique au site)",
	'cmspages:fieldset:seo' => "Référencement",
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
	'cmspages:alreadyexists' => "Une page existe déjà avec ce permalien (\"%s\")&nbsp;: veuillez réessayer avec un autre.",
	
	'cmspages:fieldset:rendering' => "Modes de rendu",
	'cmspages:fieldset:publication' => "Publication",
	'cmspages:fieldset:information' => "Informations utiles &nbsp; <i class=\"fa fa-toggle-down\"></i>",
	'cmspages:fieldset:categories' => "Rubriquage",
	'cmspages:access:current' => "Visibilité",
	
	'cmspages:error:nodisplay' => "Vous n'avez pas l'autorisation d'accéder à cette page.",
	'cmspages:notice:changedurl' => "L'adresse de cette page a changé, veuillez mettre à jour vos marque-pages.",
	
	'cmspages:type:' => "HTML",
	'cmspages:type:editor' => "HTML",
	'cmspages:type:rawhtml' => "HTML",
	'cmspages:type:module' => "Module",
	'cmspages:type:template' => "Gabarit",
	'cmspages:notice:newpage' => "Création d'une nouvelle page.",
	'cmspages:pageselect:filter' => "Rechercher une page",
	'cmspages:search:title' => "Titre de la page",
	'cmspages:search:filter' => "Filtres",
	'cmspages:filter:all' => "Toutes",
	'cmspages:access_id:none' => "",
	'cmspages:status:none' => "",
	'cmspages:content_type:none' => "",
	'cmspages:sort:none' => "",
	'cmspages:filter:access_id' => "Visibilité",
	'cmspages:filter:status' => "En ligne",
	'cmspages:filter:content_type' => "Type de page",
	'cmspages:filter:sort' => "Trier par",
	'cmspages:sort:latest' => "Date",
	'cmspages:sort:alpha' => "Alphabétique",
	'cmspages:search:nameortitle' => "Titre de la page",
	
	/* Modes d'emploi */
	'cmspages:content_type:template:details' => "<i class=\"fa fa-info-circle\"></i>Les gabarits servent pour 2 types d'utilisations principales&nbsp;:
		<ol>
			<li>pour définir des gabarits qui vont servir de \"modèle\" pour l'affichage d'autres contenus : le contenu pourra être \"injecté\" dans le gabarit, à l'emplacement indiqué par {{%CONTENT%}}&nbsp;;</li>
			<li>pour définir un contenu complexe, qui fasse appel à divers éléments dynamiques : le contenu de la page sera alors généré en faisant appel à divers types de blocs de contenus (variables, shortcodes, vues Elgg), ou à d'autres pages CMS (contenu, code source, module, mais aussi d'autres gabarits). Lors de l'utilisation d'autres gabarits, ceux-ci peuvent également faire appel à d'autres gabarits, etc.</li>
		</ol>
		Pour cela, les gabarits doivent être édités directement en HTML, dans lequel vous pouvez également intégrer les codes suivants :
		<ul>
			<li>PAGE CMS : {{cmspages-pagetype}} : insère le contenu de la page CMS 'cmspages-pagetype' (contenut, code source, module ou gabarit)</li>
			<li>VARIABLE : {{%CONTENT%}} : insère le contenu chargé dans la vue par un outil tiers via le paramètre 'content'</li>
			<li>SHORTCODE : {{[shortcode]}} : insère le shortcode 'shortcode' (si le plugin elgg_shortcode est activé)</li>
			<li>VUE ELGG : {{:forms/register|username=admin}} : insère la vue forms/register en lui passant le paramètres 'username' => 'admin'</li>
		</ul>",
	'cmspages:content_type:module:details' => "<i class=\"fa fa-info-circle\"></i>Les modules permettent de sélectionner et d'afficher divers types de contenus, selon des critères précis. Pour cela, chaque module doit être configuré avec des paramètres précis :
		<ol>
			<li>Choisir le module : par exemple une Liste d'entités</li>
			<li>Renseigner les paramètres : par ex. type d'entité 'object', type de contenu 'bookmarks', affichage limité à '5', et 'pagination' activée'</li>
			<li>Choisir éventuellement d'autres réglages généraux : contextes autorisés, niveaux d'accès, etc.</li>
			<li>Une fois le module enregistré, il peut être utilisé sous forme de vue, ou appelé par une page de type 'template'.</li>
		</ol>",
	'cmspages:content_type:rawhtml:details' => "<i class=\"fa fa-info-circle\"></i>Ce type de contenu est recommandé si vous souhaitez utiliser du code HTML \"brut\", sans filtrage ni modification. Il est notamment adapté pour intégrer des codes d'intégration de contenus riches comme un widget Twitter ou une vidéo, ou tout type de contenu dont le code source supporte mal les filtrages et corrections apportés par les éditeurs visuels.<br />
		Il est quasiment identique à \"Contenu (HTML avec éditeur visuel)\", mais permet d'éditer la page sans le filtrage et les modifications du code apportées par l'éditeur visuel, notamment les JavaScript ainsi que divers éléments HTML.",
	'cmspages:content_type:editor:details' => "<i class=\"fa fa-info-circle\"></i>Ce type de contenu est recommandé si vous souhaitez rédiger une page de contenu de manière visuelle, par ex. un texte illustré, travailler la mise en forme de la page, etc.<br />
		Si vous avez besoin d'un contrôle direct sur le code source de la page, veuillez utiliser \"Code source (HTML sans éditeur)\".",
	
	'cmspages:status' => "Statut",
	'cmspages:status:published' => "En ligne",
	'cmspages:status:notpublished' => "Hors ligne",
	
	'cmspages:password' => "Protection par mot de passe",
	'cmspages:password:details' => "Si un mot de passe est indiqué, il devra être renseigné pour pouvoir accéder au contenu de la page. <br />Attention : ajouter un mot de passe ne change pas la visibilité de la page.",
	'cmspage:password:cleared' => "Déconnexion des pages réussies.",
	'cmspage:password:cleared:page' => "Déconnexion de la page réussie",
	'cmspages:password:submit' => "Accéder",
	'cmspages:password:form' => "Accès protégé par mot de passe",
	
	'cmspages:settings:cms_menu' => "Menu à afficher",
	'cmspages:settings:cms_menu:cmspages_categories' => "cmspages_categories (rubriques CMSPages)",
	'cmspages:settings:cms_menu:default' => "[ Par défaut ]",
	'cmspages:settings:cms_menu:no' => "[ Aucun menu ]",
	'cmspages:settings:cms_menu:details' => "Pageshells ou layouts avec le \"menu CMS\" uniquement.<br />Par défaut, le menu des catégories des pages CMS sera affiché. Si vous le souhaitez, vous pouvez remplacer ce menu par un menu personnalisé, défini avec le plugin \"elgg_menus\". Pour rétablir le menu des catégories, choisissez \"cmspages_categories\".",
	'cmspages:settings:categories' => "Rubriques",
	'cmspages:settings:categories:details' => "Pour définir des rubriques, indiquez un titre de rubrique par ligne.<br />Pour définir une arborescence, vous pouvez indenter la liste en utilisant des tirets (plusieurs sous-niveaux possibles).",
	// Header
	'cmspages:settings:cms_header' => "Entête",
	'cmspages:settings:cms_header:details' => "Pageshells ou layouts avec le \"menu CMS\" uniquement.<br />Par défaut aucun entête ne sera affiché. Si vous le souhaitez, vous pouvez utiliser une page CMS pour ajouter un entête personnalisé avant le menu.",
	'cmspages:cms_header:edit' => "Editer l'entête personnalisé",
	'cmspages:cms_header:no' => "[ Aucun entête ]",
	'cmspages:cms_header:custom' => "[ Personnalisé ] (cms-header)",
	'cmspages:cms_header:initial' => "[ Identique à celui du site ]",
	'cmspages:cms_header:default' => "[ Par défaut ]",
	// Footer
	'cmspages:settings:cms_footer' => "Pied de page",
	'cmspages:settings:cms_footer:details' => "Pageshells ou layouts avec le \"menu CMS\" uniquement.<br />Par défaut le pied de page du site sera affiché. Si vous le souhaitez, vous pouvez le remplacer par une page CMS personalisée.",
	'cmspages:cms_footer:edit' => "Editer le pied de page personnalisé",
	'cmspages:cms_footer:no' => "[ Aucun pied de page ]",
	'cmspages:cms_footer:default' => "[ Par défaut ]",
	'cmspages:cms_footer:initial' => "[ Identique à celui du site ]",
	'cmspages:cms_footer:custom' => "[ Personnalisé ] (cms-footer)",
	
	'admin:cms' => "CMS",
	'admin:cms:cmspages' => "Pages CMS",
	'cmspages:configredirect' => "Pour gérer les pages CMS, vous pouvez utiliser directement la page " . elgg_get_site_url() . "cmspages",
	
	'cmspages:fieldset:access' => "Gestion des rôles",
	'cmspages:fieldset:categories' => "Rubriques",
	'cmspages:fieldset:categories:details' => "Les rubriques permettent de gérer la publication des pages CMS dans des catégories éditoriales plus structurées que les mots-clefs. Si la coquille HTML le permet, ces rubriques peuvent constituer un menu.",
	'cmspages:fieldset:rendering' => "Rendu",
	'cmspages:fieldset:rendering:details' => "Ces options avancées permettent de contrôler plus finement le rendu de votre page. Certaines options ne s'appliquent que dans des contextes bien précis, et n'ont pas forcément d'effet dans tous les cas.",
	
	'cmspages:error:duplicate' => "Attention, plusieurs entrées portent le même nom : veuillez les modifier pour avoir des titres uniques.",
	
	'cmspages:editlink' => "Cliquer pour modifier la page %s",
	'cmspages:nestedlevel' => "Page de niveau %s (le contenu est généralement au niveau 0).",
	
	'cmspages:fieldset:editor' => "Contenu de la page",
	'cmspages:history' => "Historique des versions précédentes",
	'cmspages:history:version' => "<i class=\"fa fa-history\"></i>Version enregistrée par %s %s",
	
	'cmspages:none' => "Aucune page CMS trouvée.",
	'cmspages:created' => "créée %s",
	'cmspages:updated' => "MAJ %s",
	'cmspages:readmore' => "Lire la suite",
	
);

add_translation("fr",$fr);

