<?php

$fr = array(
	/* magic strings */
	'admin:user' => "Compte utilisateur",
	'admin:user:delete:content_policy' => "Politique de gestion des publications",
	
	
	'duc:error:content_owner' => "GUID invalide pour le nouveau propriétaire des publications",
	'duc:error:invalid_guid' => "GUID du compte utilisateur invalide",
	'duc:delete:user' => "Vous êtes sur le point de supprimer le compte utilisateur \"%s\".  Veuillez choisir ce qu'il devrait advenir des publications créées par ce compte.",
	'duc:error:select_policy' => "Vous devez choisir l'action à préférer en fonction des publications du compte utilisateur",
	'duc:label:content_policy' => "Politique de contenu",
	'duc:label:content_policy:help' => "Si vous réassignez les publications à un autre compte utilisateur, veuillez sélectionner ce compte ci-dessous",
	'duc:option:delete' => "Supprimer tout le contenu de ce compte utilisateur",
	'duc:option:reassign' => "Réassigner le contenu à un autre compte utilisateur",
	'duc:label:reassign_member' => "Nouveau propriétaire",
	'duc:label:reassign_member:help' => "Pour réassigner le contenu, écrivez le nom du compte utilisateur auquel vous souhiatez assigner ces contenus et sélectionnez-le dans la liste. Vous ne pouvez sélectionner qu'un seul compte, les sélections supplémentaires seront ignorées.",
	'duc:error:reassign_deleted_user' => "Vous ne pouvez pas réassigner le contenu au compte utilisateur que vous êtes en train de supprimer",
	'duc:title:stats' => "Contenu associé à ce compte utilisateur",
);

add_translation('fr', $fr);
