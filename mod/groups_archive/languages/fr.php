<?php
/**
 * French strings
 */

$fr = array(
	'groups_archive' => "Archivage des groupes",
	'groups-archive' => "Archivage des groupes",
	
	// Index page
	'groups_archive:index' => "Groupes archivés",
	'groups_archive:index:details' => "Cette page vous permet de consulter la liste des groupes archivés, d'avoir un aperçu de leur contenu, et de les réactiver.",
	
	// Form
	'groups_archive:information' => "Les groupes archivés sont <strong>invisibles des membres et des administrateurs</strong>, n'apparaissent pas dans le moteur de recherche, et sont de fait considérés comme n'existant plus.<br /><br />Une fois réactivés, les groupes retrouvent leur adresse d'origine, ainsi que l'ensemble des contenus et informations associés&nbsp;: membres, contenus, niveaux d'accès, etc.",
	'groups_archive:groupguid' => "Choix du groupe",
	'groups_archive:grouparchive' => "Action à effectuer",
	'groups_archive:view' => "Afficher",
	'groups_archive:form:title' => "Archiver un groupe",
	'groups_archive:archive' => "Archiver",
	'groups_archive:unarchive' => "Désarchiver",
	'groups_archive:option:enabled' => "Désarchiver",
	'groups_archive:option:disabled' => "Archiver",
	'groups_archive:proceed' => "Procéder",
	
	
	// Disabled content view page
	'groups_archive:view' => "Groupe ou contenu archivé",
	'groups_archive:view:group' => "Prévisualisation d'un groupe archivé",
	'groups_archive:view:object' => "Prévisualisation d'un contenu archivé",
	
	'groups_archive:content:count' => "Contenus du groupe&nbsp;: %s publication(s)",
	'groups_archive:nocontent' => "Aucune publication dans ce groupe",
	'groups_archive:members:count' => "Membres du groupe&nbsp;: %s personne(s)",
	
	// Errors and messages
	'groups_archive:error:invalidentity' => "Groupe ou publication invalide",
	'groups_archive:notice:previewonly' => "Attention&nbsp;: cette page permet seulement de prévisualiser les groupes et publicaitons désactivés. Divers éléments de contenu peuvent ne pas apparaître correctement, et les liens de navigation internes ne seront probablement pas fonctionnels, selon les contenus affichés.",
	'groups_archive:confirm' => "Attention, ceci rendra le groupe et tous ses contenus inaccessibles pour tous les membres (et administrateurs) !",
	'groups_archive:error:noaction' => "Aucune action demandée",
	'groups_archive:enable:success' => "Le groupe \"%s\" a bien été désarchivé.",
	'groups_archive:disable:success' => "Le groupe \"%s\" a bien été archivé. Le groupe et ses contenus ne sont plus visibles des membres.",
	'groups_archive:enable:error' => "Une erreur s'est produite lors du désarchivage du groupe \"%s\".",
	'groups_archive:disable:error' => "Une erreur s'est produite lors de l'archivage du groupe \"%s\".",
	
	
);

add_translation('fr', $fr);

