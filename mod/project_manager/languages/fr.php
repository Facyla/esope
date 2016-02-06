<?php
/** Project manager language file
 * @author Facyla
 * @copyright Facyla 2010-2016
 * @link http://id.facyla.net/
 */

return array(
	'project_manager' => "Gestion de projet",
	'project_manager:time_tracker' => "Rapports d'Activités",
	'item:object:project_manager' => "Projets",
	'item:object:time_tracker' => "Feuilles de temps",
	
	'members:none' => "<em>(aucun membre sélectionné)</em>",
	'river:comment:object' => "%s a commenté %s %s %s",
	
	// Menus
	'project_manager:menu:time_tracker' => "Rapports d'Activités",
	'project_manager:menu:project:time_tracker' => "Rapports d'Activités du projet",
	'project_manager:menu:project:time_tracker:edit' => "Mettre à jour mon Rapport d'Activités",
	'project_manager:menu:project:production:edit' => "Gérer la production de ce projet",
	'project_manager:menu:time_tracker:summary' => "Synthèse des RA",
	'project_manager:menu:project:time_tracker:summary' => "Synthèse des Rapports d'Activités du projet",
	'project_manager:menu:projects' => "Projets",
	'project_manager:menu:expenses' => "Notes de Frais",
	'project_manager:menu:globalproduction' => "Production globale",
	'project_manager:menu:production' => "Production",
	'project_manager:menu:projectproduction' => "Production par projet",
	'project_manager:menu:group:production' => "Gestion de la production",
	'project_manager:menu:consultants' => "Consultants",
	'project_manager:world:details' => 'Un bandeau de couleur indique le statut actuel des projets :<br />
		<strong class="project_managertype_prospect">Bleu&nbsp;:</strong> Réponse AO / Proposition<br />
		<strong class="project_managertype_unsigned">Rouge&nbsp;:</strong> Projet commencé mais Non signé<br />
		<strong class="project_managertype_current">Vert&nbsp;:</strong> Projet en cours / Mission<br />
		<strong class="project_managertype_rejected">Gris&nbsp;:</strong> Non retenu / Refusé<br />
		<strong class="project_managertype_closed">Noir&nbsp;:</strong> Terminé / Référence',
	
	// Basic + action strings
	'project_manager:projects' => "Projets",
	'project_manager:all' => "Tous les projets",
	'project_manager:yours' => "Vos projets",
	
	'project_manager:enableproject_manager' => "Activer les Projets ?",
	'project_manager:group' => "Gestion du projet",
	'project_manager:consultants' => "Consultants",
	'project_manager:consultants:details' => "La page Consultants permet aux managers de gérer les taux affectés aux consultants internes et externes, et indique les marges réalisées pour chacun sur les différents mois de l'année.<br />Note : pour le moment, seuls les totaux des temps de production sont affichés pour chaque mois !",
	'project_manager:consultants:data:details' => "Ces constantes sont définies dans les paramètres du plugin de Gestion de projet. Elles peuvent être modifiées, mais ne devraient l'être que très rarement : pour les modifier, demandez à un administrateur.",
	'project_manager:production' => "Production",
	'project_manager:production:details' => "La page Production permet aux chefs de projet de gérer financièrement le projet : arbitrer sur les temps passés sur les projets, les temps facturables, les taux des prestataires, et d'ajuster les différentes variables du projet pour produire les indicateurs de production, et de facturation.<br />Les saisies sont en partie automatisées : certaines valeurs proviennent des saisies des consultants, et peuvent être ajustées par le chef de projet. D'autres -les valeurs liées au temps consommés- sont directement à saisir par le chef de projet, sur la base des informations précédemment renseignées. Les dernières sont calculées automatiquement à partir des données collectées et/ou saisies.",
	'project_manager:globalproduction' => "Synthèse de la Production",
	'project_manager:globalproduction:details' => "La page de Synthèse de la Production permet aux managers d'avoir une vue d'ensemble des Projets, et de vérifier les éléments financiers des projets.<br />Les données mensuelles doivent avoir fait l'objet d'une validation par le chef de projet (ou un manager) pour être prises en compte. Les saisies valides sont en vert, et sont comptées dans les totaux, celles en rouge attendent une validation par le chef de projet et ne sont PAS comptabilisées dans les totaux par ligne ni par colonne.",
	'project_manager:managers' => "Managers ayant accès à cet outil",
	'project_manager:managers:noaccess' => "Cette page est réservée aux managers. Si vous pensez devoir y avoir accès, veuillez demander l'accès à un administrateur.",
	
	'project_manager:new' => "Nouveau projet",
	'project_manager:notification:title' => "Un nouveau projet a été créé",
	'project_manager:edit' => "Mise à jour du projet",
	'project_manager:edit:details' => "Mode d'emploi pour créer ou mettre à jour un nouveau projet&nbsp;:<br /><ol>
		<li>Nom du projet : indiquez le titre de votre projet</li>
		<li>Code projet : indiquez un code court pour le projet, tel qu'il est référencé dans d'autres outils (comptabilité)</li>
		<li>Groupe du projet : pour relier le projet à des outils collaboratif ou de suivi de tâches, choisissez le groupe auquel associer le projet. Si ce groupe n'existe pas encore, vous pouvez le créer et revenir modiifer le choix par la suite.</li>
		<li>Statut : indiquez le stade du projet. Un projet terminé (\"closed\") ne peut plus faire l'objet de saisies.</li>
		<li>Avancement global : un indicateur global d'avancement du projet, à l'appréciation du chef du projet.</li>
		<li>Budget total : budget tel qu'il figure dans la proposition commerciale ou le contrat signé, en € Hors Taxe.</li>
		<li>Nombre de jours facturables : tels qu'ils figurent dans la proposition commerciale ou le contrat signé, en nombre de jours-homme.</li>
		<li>Dates de début et de fin : date de démarrage et de fin prévisionnels du projet.</li>
		<li>Equipe du projet & éléments pour la production : permet de sélectionner qui sera affecté par défaut au projet, et quels postes de coût ou de CA sont prévus. Ces éléments peuvent être ajustés au fur et à mesure de l'avancement du projet.</li>
		<li>Profils et taux : les taux journaliers des différents types d'intervenants, tels qu'ils figurent dans la proposition commerciale ou le contrat signé, en € Hors Taxe.</li>
		<li>Client : informations sur le client, ses coordonnées, et toutes autres informations utiles.</li>
		<li>Description détaillée et tags : description fine du projet, document joints (sous forme de liens), et mots-clefs.</li>
		</ol>",
	'project_manager:edit:ok' => "Modifications enregistrées",
	'project_manager:save' => "Enregistrer",
	'project_manager:saved' => "Mise à jour du projet enregistrée",
	'project_manager:saved:ok' => "Modifications enregistrées",
	'project_manager:savefailed' => "L'enregistrement du projet a échoué ; vous pouvez essayer de renvoyer le formulaire, ou ré-éditer le projet.",
	'project_manager:delete:confirm' => "Confirmez-vous la suppression de ce projet ?",
	'project_manager:deleted' => "le projet a bien été supprimé",
	'project_manager:noaccess' => "Vous n'avez pas les autorisations d'accès à cette page.",
	'project_manager:missingrequireddata' => "Impossible d'afficher la page : les informations requises ne sont pas disponibles.",
	'project_manager:ajax:loading' => "Mise à jour des données en cours",
	
	// Production
	'project_manager:novalue' => "Aucune donnée disponible.",
	'project_manager:production:salarie' => "Salariés",
	'project_manager:production:non-salarie' => "Non salariés",
	'project_manager:production:otherhuman' => "Autres humains",
	'project_manager:production:other' => "Autres",
	
	// Frais
	'project_manager:expenses:noproject' => "Non affecté (hors-projets)",
	'project_manager:expenses:details' => "<h3>Règles pour renseigner les notes de frais</h3><br />
		<h4>TVA déductible</h4><em>la TVA déductible ne concerne que les frais en France</em><br /><br />
		<strong>Sont déductibles :</strong><br />
		la TVA de livres, études, congrès<br />
		pour les frais de resto: seule la TVA indiquée explicitement sur l'addition est déductible<br /><br />
		<strong>Ne sont PAS déductibles :</strong><br />
		la TVA d'une location de voiture<br />
		la TVA d'un 'hôtel",
	
	// Settings
	'project_manager:settings:user_metadata_name' => "Metadata des comptes utilisateurs utilisée pour la définition des rôles",
	'project_manager:settings:presentation' => "Cet outil de gestion de projet est réservé à certains membres, avec différents niveaux d'accès :
			<ul>
				<li>Seuls les membres ayant une propriété ->%s non vide ont accès aux projets</li>
				<li>Ces membres ont accès aux informations des projets, ainsi qu'aux outils de suivi du temps</li>
				<li>Seuls les membres \"managers\" définis dans cette page ont accès à la partie d'édition des projets et aux outils de synthèse globaux</li>
			</ul>",
	'project_manager:settings:managers' => "Managers des projets",
	'project_manager:settings:managers:help' => "Les Managers ont la possibilité de créer et modifier des projets et d'accéder aux outils de synthèse.",
	'project_manager:settings:consultants:data' => "Données générales pour les calculs des indicateurs consultants",
	'project_manager:settings:coefsalarie' => "Coefficient charges salariales",
	'project_manager:settings:coefpv' => "Coefficient charges Part Variable (PV)",
	'project_manager:settings:dayspermonth' => "Nombre moyen de jour par mois (calcul des indicateurs)",
	
	// User metadata
	'project_manager:status_meta:salarie' => "Salarié",
	'project_manager:status_meta:non-salarie' => "Non salarié",
	'project_manager:status_meta:extranet' => "NA (accès extranet seulement)",
	'project_manager:status_meta:' => "NA (non défini)",
	

	'project_manager:references' => "Liste des projets",
	'project_manager:references:description' => "Tableau récapitulatif des projets, triable et filtrable",
	
	'project_manager:readaccess' => "Accès en lecture",
	'project_manager:writeaccess' => "Accès en écriture",
	'project_manager:title' => "Nom du projet",
	'project_manager:startyear' => "Année de début",
	'project_manager:clientshort' => "Nom court du client",
	'project_manager:project_code' => "Code projet (cf. Admin)",
	'project_manager:noproject_code' => "(pas de code projet)",
	'project_manager:empty:project_code' => "pas de code projet",
	'project_manager:error:cantedit' => "Erreur : vous n'avez pas les droits suffisants pour éditer ce projet.",
	'project_manager:ajax:error:retry' => "Erreur : les informations n'ont pas pu être mises à jour, veuillez recharger la page et réessayer.",
	'project_manager:ajax:error:reload' => "Erreur : les informations n'ont pas pu être mises à jour, veuillez réessayer dans un instant.",
	'project_manager:error:noproject_code' => "Code projet non renseigné : merci de modifier le projet et d'indiquer son code projet",
	'project_manager:error:closed' => "Un projet marqué comme Terminé ne peut plus être modifié ni supprimé. Si vous souhaitez le réouvrir, veuillez demander à un administrateur de le faire.",
	'project_manager:error:closedproject' => "Il n'est pas possible de renseigner de rapport d'activité sur un projet marqué comme Rejeté ou Terminé. Si vous souhaitez réouvrir le projet pour terminer votre rapport d'activité, veuillez contacter un administrateur pour le faire.",
	'project_manager:nodata' => "Aucune donnée",
	//'project_manager:date' => "Date de début du projet",
	'project_manager:date' => "Dates du projet : du",
	//'project_manager:enddate' => "Date de fin du projet",
	'project_manager:enddate' => "au",
	'project_manager:maininfo' => "Informations du projet",
	'project_manager:client' => "Client",
	'project_manager:clients' => "Client / Organisation",
	'project_manager:clientcontacts' => "Contacts et coordonnées",
	'project_manager:clienttype' => "Type(s) de client",
	'project_manager:budget' => "Budget total",
	'project_manager:totaldays' => "Jours facturables",
	'project_manager:globalpercentage' => "Avancement global",
	'project_manager:status' => "Workflow",
	'project_manager:project_managertype' => "Statut",
	'project_manager:project_managertype:details' => "Attention : un projet marqué Rejeté ou Terminé ne peut plus être modifié ni supprimé, et il n'est plus possible d'effectuer de saisie dessus.",
	'project_manager:description' => "Description détaillée du projet",
	'project_manager:tags' => "Tags",
	'project_manager:projectgroup' => "Groupe de ce projet",
	'project_manager:projectgroup:details' => "En associant ce projet à un groupe, vous pouvez utiliser l'ensemble des outils collaboratifs activés dans le groupe pour gérer votre projet. Seuls les membres du groupe auront accès aux outils collaboratifs tels que tâches, wikis, forums, partage de fichiers.<br />Attention : les membres du groupe ne sont pas gérés via l'équipe du projet : il est nécessaire de les inviter directement dans le groupe.",
	'project_manager:clientcontact' => "Nom, fonction et coordonnées du client",
	'project_manager:notes' => "Notes et remarques sur le projet (budget variable, etc.)",
	'project_manager:people' => "Acteurs du projet",
	'project_manager:people:details' => "Pour chaque personne de l'équipe : temps et tarif prévus, sur la base des profils du projet. Ces tarifs peuvent être ajustés a posteriori ?",
	'project_manager:projectmanager' => "Chef de projet",
	'project_manager:owner' => "Auteur du projet",
	'project_manager:productionteam' => "Equipe du projet & éléments pour la production",
	'project_manager:memberselect:details' => "Attention : les personnes peuvent être classées par leur nom (par défaut), mais aussi par leur prénom dans certains cas. Pensez à vérifier les 2 !",
	'project_manager:team' => "Salariés",
	'project_manager:fullteam' => "Non-salariés",
	'project_manager:profiles' => "Profils, taux et temps associés",
	'project_manager:profilesrates' => "Profils et taux (1 profil par ligne)",
	'project_manager:profilesrates:details' => "Nom du profil : taux € HT : nb jours<br /><em>Exemple pour un profil manager avec 6,5 jours valorisés à 1000 € HT&nbsp;: CMN (consultant manager) : 1000 : 6.5",
	'project_manager:otherhuman' => "Autres coûts/CA humains (1 poste par ligne)",
	'project_manager:otherhuman:details' => "Indiquez au autre intitulé de poste de coût ou de CA par ligne : ils seront intégrés dans le suivi de la production",
	'project_manager:other' => "Autres postes de coûts/CA (1 poste par ligne)",
	'project_manager:other:details' => "Indiquez au autre intitulé de poste de coût ou de CA par ligne : ils seront intégrés dans le suivi de la production",
	'project_manager:extranet' => "Accès extranet",
	'project_manager:extranet:details' => "personnes ayant accès au groupe, mais pas au projet",
	'project_manager:ispublic' => "Rapport publiable ?",
	'project_manager:sector' => "Secteur d'activité",
	'project_manager:files' => "<strong>Documents joints et annexes</strong><br /><em>Note : les pièces jointes apparaitront dans le champ <b>Description</b> ci-après.</em>",
	'project_manager:file:offer' => "Propale",
	'project_manager:file:market' => "DCE, admin",
	'project_manager:file:finalreport' => "Rapports",
	'project_manager:file:reports' => "Documents connexes",
	'project_manager:geodata' => "Localisation(s)",
	'project_manager:scope' => "Echelle",
	
	'project_manager:clicktoselect' => "Cliquer pour choisir",
	'project_manager:choose' => "(choisir)",
	'project_manager:choose:multi' => "(choisir un ou plusieurs)",
	//'project_manager:file:clicktoadd' => " (cliquer pour ajouter)",
	'project_manager:file:clicktoadd' => " <strong><big><big>+</big></big></strong>",
	//'project_manager:file:clicktoselect' => " (afficher/masquer le sélecteur)",
	'project_manager:file:clicktoselect' => " +",
	
	// Matcher ça sur une échelle numérique pour pouvoir déduire à partir que (région) > (département) ?
	// par ex.: 0 (pas de valeur = a-territorial), 1 (world), 2 (continent), 3 (zone), 4 (état), 5 (région), 6 (département), 7 (interco), 8 (commune), 9 (adresse précise)
	'project_manager:scope:' => "(aucun, a-territorial)",
	'project_manager:scope:world' => "International",
	'project_manager:scope:continent' => "Continental",
	'project_manager:scope:europe' => "Europe",
	'project_manager:scope:algerie' => "Algérie",
	'project_manager:scope:france' => "France",
	'project_manager:scope:japon' => "Japon",
	'project_manager:scope:uk' => "UK",
	'project_manager:scope:etat' => "Etat",
	'project_manager:scope:region' => "Régional",
	'project_manager:scope:departement' => "Départemental",
	'project_manager:scope:interco' => "Intercommunal",
	'project_manager:scope:commune' => "Communal",
	'project_manager:scope:local' => "Local (hyperlocal)",
	
	// Secteurs d'activité
	'project_manager:sector:' => "",
//	'project_manager:sector:private' => "Privé",
	'project_manager:sector:transport' => "Transport",
	'project_manager:sector:energie' => "Energie",
	'project_manager:sector:banque' => "Banque",
	'project_manager:sector:education' => "Education/formation",
	'project_manager:sector:tv' => "Télévision",
	'project_manager:sector:service' => "Services",
	'project_manager:sector:informatique' => "Informatique/dév",
	'project_manager:sector:media' => "Média",
	'project_manager:sector:culture' => "Culture/Musée",
	'project_manager:sector:other' => "Autre",
	
	// Types de clients
	'project_manager:clienttypes:' => "",
	'project_manager:clienttypes:entreprise' => "Entreprise",
//	'project_manager:clienttypes:public' => "Public",
	'project_manager:clienttypes:servicecentral' => "Etat/Administration",	// Service Central / Ministère / Autorité régulation
	'project_manager:clienttypes:ministere' => "Ministère",
	'project_manager:clienttypes:developpement' => "Agence/Etab. Public",
//	'project_manager:clienttypes:collectivite' => "Collectivité territoriale",
	'project_manager:clienttypes:cr' => "Conseil Régional",
	'project_manager:clienttypes:cg' => "Conseil Général",
	'project_manager:clienttypes:interco' => "Commune, interco, agglo",
//	'project_manager:clienttypes:mix' => "Mixte",
	'project_manager:clienttypes:pole' => "Pôle de compétitivité",
	'project_manager:clienttypes:association' => "Association",
	// Autres
	'project_manager:clienttypes:self' => "Interne",
	'project_manager:clienttypes:other' => "Autre",
	
	// Workflow
	'project_manager:status:' => "",
	'project_manager:status:new' => "Nouvel appel d'offre",
	'project_manager:status:needinfo' => "Besoin de plus d'informations",
	'project_manager:status:needmanager' => "Choix chef de projet",
	'project_manager:status:needteam' => "Constitution équipe",
	'project_manager:status:writing' => "Rédaction propale",
	'project_manager:status:sent' => "Envoyée",
	
	'project_manager:project_managertype:' => "(à définir)",
	'project_manager:project_managertype:prospect' => "Réponse AO / Proposition",
	'project_manager:project_managertype:new' => "Nouveau / Propale",
	'project_manager:project_managertype:rejected' => "Non retenu / Refusé",
	'project_manager:project_managertype:unsigned' => "Projet commencé mais Non signé",
	'project_manager:project_managertype:current' => "Projet en cours / Mission",
	'project_manager:project_managertype:old' => "Terminé / Référence",
	'project_manager:project_managertype:closed' => "Terminé / Référence",
	
	'project_manager:' => "",
	'project_manager:public' => "Public et diffusable",
	'project_manager:private' => "Confidentiel, ne pas diffuser",
	'project_manager:ask' => "Autorisation à demander",
	
	'project_manager:searchtag' => "Recherche",
	
	
	// Production
	'project_manager:error:nogroupproject' => "Pas de projet associé à ce groupe",
	'project_manager:error:nogroupproject:details' => "Aucun projet n'est associé à ce groupe pour le moment.<br />Vous pouvez consulter la liste des projets existants et affecter un projet à ce groupe, ou <a href=\"%sproject_manager/group/%s/new\">créer un projet pour ce groupe</a>.",
	'project_manager:error:noproject' => "Pas de projet correspondant",
	'project_manager:error:noproject:details' => "Aucun projet ne correspond aux indications fournies.<br />Vous pouvez consulter la liste des projets existants, ou <a href=\"%sproject_manager/new/\">créer un nouveau projet</a>.",
	'project_manager:expenses:error:readwrite' => "Erreur lors de la lecture ou de la modification de certaines données : %s erreurs en lecture et %s erreurs en écriture.",
	'project_manager:delete:error:adminonly' => "Désolé, la suppression d'un projet peut avoir de nombreuses incidences. Merci de le faire supprimer par un administrateur. Vous pouvez toutefois changer les autres paramètres et notamment le niveau de visibilité du projet.",
	'project_manager:infos' => "Informations et mode d'emploi",
	'project_manager:showhide' => "cliquer pour afficher",
	'project_manager:access:otheraccess' => "Ont également accès&nbsp;: le chef de projet, et l'auteur du projet (s'il est différent du chef de projet)",
	'project_manager:manager:summary' => "Manager ? &nbsp; Cliquez ici pour afficher la synthèse de la production",
	'project_manager:allprojects' => "Tableau de l'ensemble des projets en %s",
	'project_manager:validated' => "Ces données ont été validées (par le chef de projet ou par un manager)",
	'project_manager:notvalidated' => "Validation non effectuée pour les données de ce mois",
	'project_manager:nomonthdata' => "Pas de donnée pour ce mois",
	'project_manager:report:global' => "Global projets",
	'project_manager:report:validation' => "Validation",
	'project_manager:report:charges' => "Charges",
	'project_manager:report:ca' => "CA",
	'project_manager:report:marge' => "Marge",
	'project_manager:ok' => "OK",
	'project_manager:no' => "NON",
	'project_manager:report:monthvalidation' => "Validation des données par mois",
	'project_manager:report:monthmarge' => "Marge par mois",
	
	'project_manager:report:crosstest' => "Test croisé (non fonctionnel)",
	'project_manager:report:month' => "Mois",
	'project_manager:report:opendays' => "Jours ouvrés",
	'project_manager:report:chargestotal' => "Total Charges",
	'project_manager:report:catotal' => "Total CA",
	'project_manager:report:result' => "Résultat",
	'project_manager:na' => "(sans objet)",
	
	'project_manager:report:prodsalarie' => "Production salariée",
	'project_manager:report:prodnonsalarie' => "Production non salariée",
	'project_manager:report:otherhuman' => "Autres humains",
	'project_manager:report:other' => "Autres",
	'project_manager:report:projectmonth' => "Projet %s, pour le mois de %s %s",
	'project_manager:editproject' => "&raquo;&nbsp;modifier les informations du Projet",
	'project_manager:warning:unsigned' => "ATTENTION : projet démarré mais NON SIGNÉ => à signer rapidement !!",
	'project_manager:report:consultants' => "Consultants ayant effectué des saisies sur ce projet",
	'project_manager:report:saisies' => "Détail des temps saisis",
	'project_manager:report:othercacharges' => "Pour définir d'autres postes de charges ou de CA, merci de les indiquer en ",
	'project_manager:report:updateproject' => "mettant à jour les informations du projet (nouvelle fenêtre)",
	'project_manager:report:nom' => "Nom",
	'project_manager:report:infoconsultant' => "Informations consultants (ajustables par chef de projet)",
	'project_manager:report:gestioncdp' => "Gestion par le chef de projet (saisies et calculs)",
	'project_manager:report:otherchargeinfo' => "Infos autres charges",
	'project_manager:report:daysprod' => "J. produits",
	'project_manager:report:cjm' => "CJM",
	'project_manager:report:cout1' => "Coût1",
	'project_manager:report:frais' => "Frais",
	'project_manager:report:cout2' => "Coût2",
	'project_manager:report:othercainfo' => "Infos autres CA",
	'project_manager:report:tjm' => "TJM",
	'project_manager:report:daysconso' => "J. consommés",
	'project_manager:report:ca1' => "CA1",
	'project_manager:report:fraisf' => "FraisF",
	'project_manager:report:ca2' => "CA2",
	'project_manager:total' => "Total",
	'project_manager:report:monthstats' => "Indicateurs mensuels",
	'project_manager:report:chargesmaj' => "CHARGES",
	'project_manager:report:prevmonthreport' => "Récap mois précédent",
	'project_manager:report:totalcontrat' => "Total contrat",
	'project_manager:report:rapm1' => "Reste à produire M-1",
	'project_manager:report:rafm1' => "Reste à facturer M-1",
	'project_manager:report:facturesummary' => "Facturation et synthèse",
	'project_manager:report:todofacture' => "Facture à émettre",
	'project_manager:report:rap' => "Reste à produire",
	'project_manager:report:raf' => "Reste à facturer",
	'project_manager:report:monthvalidationsheet' => "Validation de la feuille mensuelle (vide = non validé)",
	'project_manager:report:notvalidated' => "Non validé",
	'project_manager:report:validated' => "Validation OK",
	'project_manager:report:validationnotice' => "Les feuilles mensuelles doivent être validées par le chef de projet ou un manager.",
	'project_manager:notesrmq' => "Notes / Remarques",
	'project_manager:saveandrecompute' => "Enregistrer les données et re-calculer",
	
	
	// Consultants
	'project_manager:consultants:member' => "Membre",
	'project_manager:consultants:statut' => "Statut",
	'project_manager:consultants:fixe' => "Annuel brut",
	'project_manager:consultants:fixe:details' => "Salaire annuel brut en €",
	'project_manager:consultants:variable' => "PV",
	'project_manager:consultants:variable:details' => "Part variable en €",
	'project_manager:consultants:monthbrut' => "Mensuel brut",
	'project_manager:consultants:monthbrut:details' => "Salaire mensuel brut en € = Brut annuel / 12",
	'project_manager:consultants:monthcost' => "Coût mois",
	'project_manager:consultants:monthcost:details' => "Coût chargé en € par mois = (Mensuel brut * coef_salarial) + (PV * coef_PV / 12)",
	'project_manager:consultants:daycost' => "Coût jour",
	'project_manager:consultants:daycost:details' => "Coût chargé en € par jour ouvré = Coût mois / 12",
	'project_manager:consultants:lastname' => "Nom",
	'project_manager:consultants:name' => "Prénom",
	
	// Notes de frais
	'project_manager:expenses:managerlink' => "Manager ? &nbsp; Cliquez ici pour afficher la synthèse des notes de frais",
	'project_manager:expenses:addnew' => "Ajouter de nouvelles Notes de frais",
	'project_manager:expenses:date' => "Date",
	'project_manager:expenses:objet' => "Objet",
	'project_manager:expenses:montant' => "Montant",
	'project_manager:expenses:devise' => "Devise (si non €)",
	'project_manager:expenses:tva' => "TVA déductible € si indiquée et en France",
	'project_manager:expenses:affconsult' => "Affectation consultant",
	'project_manager:expenses:affconsults' => "Affectation consultants",
	'project_manager:expenses:affproj' => "Affectation projet",
	'project_manager:expenses:affprojs' => "Affectation projets",
	'project_manager:expenses:prevexpenses' => "Rappel / édition de Notes de frais déjà saisies et non validées",
	'project_manager:expenses:tvaded' => "TVA déductible",
	'project_manager:expenses:tvaded:details' => "Indiquer la TVA déductible € si elle est indiquée et que les frais sont en France - cf. règles TVA en bas de page",
	'project_manager:expenses:montanteur' => "Montant €",
	'project_manager:expenses:rate' => "Taux (1€ = ? unités)",
	'project_manager:expenses:montantloc' => "Montant local",
	'project_manager:expenses:' => "",
	'project_manager:expenses:' => "",
	'project_manager:expenses:' => "",
	'project_manager:expenses:noproject' => "Non-affecté / hors-projet",
	
	// @TODO : Notes de frais - Global
	
	// @TODO : Projets - World
	
	'project_manager:validation' => "Validation",
	
	
	'project_manager:' => "",
	
	
	/* TACHES */
	// Menu items and titles
	'tasks' => "tâches",
	'tasks:owner' => "tâches de %s",
	'tasks:friends' => "Tâches des contacts",
	'tasks:all' => "Toutes les tâches du site",
	'tasks:add' => "Ajouter une tâche",

	'tasks:group' => "Tâches du groupe",
	'groups:enabletasks' => 'Activer les tâches du groupe',

	'tasks:edit' => "Modifier cette tâche",
	'tasks:delete' => "Supprimer cette tâche",
	'tasks:history' => "Historique",
	'tasks:view' => "Voir la tâche",
	'tasks:revision' => "Révision",

	'tasks:navigation' => "Navigation",
	'tasks:via' => "via les tâches",
	'item:object:task_top' => 'Phases',
	'item:object:task' => 'Tâches',
	'tasks:nogroup' => "Ce groupe n'a aucune tâche pour le moment",
	'tasks:more' => 'Plus de tâches',
	'tasks:none' => 'Aucune tâche créée pour le moment',

	// River
	'river:create:object:task' => '%s a créé la tâche %s',
	'river:create:object:task_top' => '%s a créé une tâche %s',
	'river:update:object:task' => '%s a mis à jour la tâche %s',
	'river:update:object:task_top' => '%s a mis à jour une tâche %s',
	'river:comment:object:task' => '%s a commenté la tâche nommée %s',
	'river:comment:object:task_top' => '%s a commenté la tâche nommée %s',

	// Form fields
	'tasks:title' => 'titre de la tâche',
	'tasks:description' => 'texte de la tâche',
	'tasks:tags' => 'Tags',
	'tasks:access_id' => 'Accès en lecture',
	'tasks:write_access_id' => 'Accès en écriture',
	'tasks:transfer:myself' => 'Assigner à moi-même',

	// Status and error messages
	'tasks:noaccess' => "Pas d'accès à cette tâche",
	'tasks:cantedit' => 'Vous ne pouvez pas modifier cette tâche',
	'tasks:saved' => 'tâche enregistrée',
	'tasks:notsaved' => 'tâche non enregistrée',
	'tasks:error:no_title' => 'Vous devez définir un titre pour cette tâche.',
	'tasks:delete:success' => 'Cette tâche a bien été supprimée.',
	'tasks:delete:failure' => "Cette tâche n'a pas pu être supprimée.",

	// Tâche
	'tasks:strapline' => 'Dernière mise à jour %s par %s',

	// History
	'tasks:revision:subtitle' => 'Révision créée %s par %s',

	// Widget
	'tasks:num' => 'Nombre de tâches à afficher',
	'tasks:widget:description' => "La liste de vos tâches.",

	// Submenu items
	'tasks:label:view' => "Voir cette tâche",
	'tasks:label:edit' => "Modifier la tâche",
	'tasks:label:history' => "historique de la tâche",

	// Sidebar items
	'tasks:sidebar:this' => "Cette tâche",
	'tasks:sidebar:children' => "Sous-tâches",
	'tasks:sidebar:parent' => "Parent",

	'tasks:newchild' => "Créer une sous-tâche",
	'tasks:backtoparent' => "Retour à '%s'",
	
	'tasks:start_date' => "Début",
	'tasks:end_date' => "Fin",
	'tasks:percent_done' => " terminé",
	'tasks:work_remaining' => "Restant.",

	'tasks:task_type' => 'Type',
	'tasks:status' => 'Statut',
	'tasks:assigned_to' => 'Personne',

	'tasks:task_type_'=>"",
	'tasks:task_type_0'=>"",
	'tasks:task_type_1'=>"Analyse",
	'tasks:task_type_2'=>"Spécifications",
	'tasks:task_type_3'=>"Dévelopement",
	'tasks:task_type_4'=>"Test",
	'tasks:task_type_5'=>"Mise en production",

	'tasks:task_status_'=>"",
	'tasks:task_status_0'=>"",
	'tasks:task_status_1'=>"Ouvert",
	'tasks:task_status_2'=>"Assignée",
	'tasks:task_status_3'=>"Chargée",
	'tasks:task_status_4'=>"En cours",
	'tasks:task_status_5'=>"Terminée",

	'tasks:task_percent_done_'=>"0%",
	'tasks:task_percent_done_0'=>"0%",
	'tasks:task_percent_done_1'=>"20%",
	'tasks:task_percent_done_2'=>"40%",
	'tasks:task_percent_done_3'=>"60%",
	'tasks:task_percent_done_4'=>"80%",
	'tasks:task_percent_done_5'=>"100%",

	'tasks:tasksboard'=>"Tableau de bord des tâches",
	'tasks:tasksmanage'=>"Gérer",
	'tasks:tasksmanageone'=>"Gérer une tâche",
	
	'tasks:project_tasks' => "Phases et tâches",
	'tasks:project_tasks:details' => "Phases représentées en fonction du budget associé à chaque phase.<br />
			Avancement dans une phase : 1 barre par phase, % en fonction du % de tâches terminées<br />
			Budget dans une phase : temps passé / temps facturable (même longueur donc si l'une dépasse l'autre il y a un pb)<br />",
	'tasks:new' => "Une nouvelle tâche a été ajoutée",
	
	// TIME TRACKER
	'time_tracker' => "Rapports d'Activités",
	'time_tracker:owner' => "Rapports d'Activités de %s",
	'time_tracker:details' => "Les rapports d'activités permettent de suivre mois par mois son activité, et d'indiquer sur quoi on a passé du temps. Le temps passé chaque jour est de 1. Pour saisir le temps passé sur un projet donné, vous pouvez indiquer les valeurs sous les formes suivantes : 0.5, 0,3, 1/4, 3/7, etc. Lorsqu'une saisie est valide, la somme du temps passé sur la journée est indiqué dans la colonne \"Total\" : la case est grisée si la somme est inférieure, verte si la saisie est de 1, et rouge si elle dépasse. En cas de surcharge, merci de reporter le temps supplémentaire sur un autre jour, ou d'en discuter directement avec le chef de projet. Les jours fériés non exceptionnels sont indiqués et grisés. Lorsque vous indiquez un jour de congé, les saisies de la ligne correspondante sont effacées, et la ligne est grisée.",
	'time_tracker:summary' => "Synthèse des Rapports d'Activités",
	'time_tracker:summary:owner' => "Synthèse des Rapports d'Activités de %s",
	'time_tracker:summary:details' => "Ce tableau donne un aperçu global de l'activité d'une personne, mois par mois. Le temps de production est la somme des temps passés sur les projets. Le temps saisi inclut les congés et autres activités hors-production. Les saisies des temps sont complètes si le temps saisis est égal au nombre de jours ouvrés.",
	'time_tracker:otherproject' => "Autre, hors-projet",
	'time_tracker:add_new' => "+ Projet",
	'time_tracker:save_new' => "Ajouter au tableau",
	'time_tracker:group' => "Suivi du temps passé",
	'time_tracker:code:undefined' => "(pas de code projet)",
	'time_tracker:production' => "Production",
	'time_tracker:avantvente' => "Avant-vente",
	'time_tracker:travauxtechniques' => "Travaux techniques",
	'time_tracker:gestion' => "Gestion",
	'time_tracker:frais' => "Frais €",
	'time_tracker:conge' => "Congé",
	'time_tracker:conge:details' => "(clic pour cocher)",
	'time_tracker:notes' => "Notes",
	'time_tracker:notes:details' => "(clic pour saisir)",
	'time_tracker:validate' => "Valider le rapport",
	'time_tracker:validate:ready' => "Mois terminé",
	'time_tracker:validate:cancel' => "Annuler la validation",
	'time_tracker:validate:warning' => "Attention, cette action est définitive : vous ne pourrez plus modifier les saisies pour ce mois. Confirmer et valider le rapport ?",
	'time_tracker:unvalidate:warning' => "Attention, retirer la validation peut mener à des incohérences dans le suivi de la produciton des projets - si . Confirmer et annuler la validation ?",
	'time_tracker:project:remove' => "Retirer ce projet",
	'time_tracker:project:removetitle' => "Retirer ce projet de mon rapport d'activité",
	'time_tracker:project:removeconfirm' => "Retirer ce projet de ce rapport d'activité : toutes les saisies de ce mois seront également effacées. Voulez-vous continuer ?",
	'time_tracker:chooseproject' => "	-- Choisir un projet -- ",
	'time_tracker:error:nomoreproject' => "Tous les projets connus ont été renseignés : veuillez créer un nouveau projet, ou modifier les saisies sur les projets existants.",
	'time_tracker:validation:ready' => "Saisie terminée ?",
	'time_tracker:validation' => "Validé (saisie terminée)",
	'time_tracker:novalidation' => "Non validé",
	'time_tracker:comment' => "Rmqs",
	'time_tracker:noinput' => "Aucune saisie",
	'time_tracker:total:permonth' => "Total",
	'time_tracker:total:peryear' => "Total annuel",
	'time_tracker:total:perproject' => "Total global sur le projet",
	
	'time_tracker:deleted' => "Projet supprimé du rapport d'activités.",
	
	'time_tracker:display_user_month' => "<i class=\"fa fa-external-link\"></i> afficher la feuille de temps",
	

);
				
add_translation("fr",$french);

