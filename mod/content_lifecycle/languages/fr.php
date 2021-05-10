<?php
/**
 * French strings
 */

return [
	'content_lifecycle' => "Cycle de vie des contenus",
	'content_lifecycle:index' => "Contrôle du cycle de vie des contenus",
	
	// Plugin settings
	// Direct mode
	'content_lifecycle:settings:' => "",
	
	
	// Generic
	'option:transfer' => "Transférer",
	'option:delete' => "Supprimer définitivement",
	
	// Select form
	'content_lifecycle:user:select:submit' => "Sélectionner ce compte",
	'content_lifecycle:user:select:user' => "Utilisateur à supprimer",
	'content_lifecycle:user:select:nouser' => "Pas de compte utilisateur sélectionné.",
	
	// Deletion form
	'account_lifecycle:user:transfer_options' => "Gestion des contenus lors de la suppression du compte",
	'account_lifecycle:user:noself' => "Impossible de supprimer son propre compte",
	'account_lifecycle:user:invalid' => "Ce GUID n'est pas celui d'un compte utilisateur valide&nbsp;: %s",
	'account_lifecycle:user:cannotdelete' => "Vous n'avez pas l'autorisation de supprimer ce compte.",
	'' => "",
	'' => "",
	'' => "",
	'content_lifecycle:proceed' => "Appliquer les actions choisies",
	
	// Process details
	'account_lifecycle:processing' => "Exécution des actions",
	'account_lifecycle:guid' => "GUID&nbsp;: %s",
	'account_lifecycle:user:valid' => "Utilisateur valide&nbsp;: %s",
	'account_lifecycle:default_rule' => "Action par défaut valide&nbsp;: ' . %s",
	'account_lifecycle:default_new_owner' => "Nouveau propriétaire par défaut valide&nbsp;: %s",
	'account_lifecycle:groups' => "Groupes",
	'account_lifecycle:error:notgroupmember' => " => <strong>Impossible de transférer : le nouveau propriétaire n'est pas membre du groupe (et n'a pas pu le rejoindre) !</strong>",
	'account_lifecycle:error:cannottransferself' => " => <strong>Impossible de transférer au compte qui va être supprimé !</strong>",
	'account_lifecycle:error:simulating' => " => <strong>Aucune action effectuée !</strong>",
	'account_lifecycle:group:transfered' => " => <strong>OK !</strong>",
	'account_lifecycle:group:owner_not_group_member' => " => Nouveau propriétaire pas encore membre du groupe",
	'account_lifecycle:group:owner_is_group_member' => " => Nouveau propriétaire membre du groupe",
	
	'account_lifecycle:object:transfered' => " => <strong>OK !</strong>",
	'account_lifecycle:error:nocontent' => "Aucun contenu de ce type",
	
	
	// Overrides
	
];

