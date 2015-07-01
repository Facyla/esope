<?php
return array(
	'transitions' => 'Contributions',
	'transitions:transitionss' => 'Contributions',
	'transitions:revisions' => 'Révisions',
	'transitions:archives' => 'Archives',
	'transitions:transitions' => 'Contribution',
	'item:object:transitions' => 'Contributions',

	'transitions:title:user_transitionss' => 'Contributions de %s',
	'transitions:title:all_transitionss' => 'Tous les contributions du site',
	'transitions:title:friends' => 'Contributions des contacts',

	'transitions:group' => 'Contributions du groupe',
	'transitions:enabletransitions' => 'Activer les contributions du groupe',
	'transitions:write' => 'Écrire une contribution',

	// Editing
	'transitions:add' => 'Ajouter une contribution',
	'transitions:edit' => 'Modifier la contribution',
	'transitions:excerpt' => 'Extrait',
	'transitions:body' => 'Corps de la contribution',
	'transitions:save_status' => 'Dernier enregistrement:',
	
	'transitions:revision' => 'Révision',
	'transitions:auto_saved_revision' => 'Révision automatiquement enregistrée',

	// messages
	'transitions:message:saved' => 'Contribution enregistrée.',
	'transitions:error:cannot_save' => 'Impossible d\'enregistrer la contribution.',
	'transitions:error:cannot_auto_save' => 'Impossible de sauvegarder automatiquement la contribution. ',
	'transitions:error:cannot_write_to_container' => 'Droits d\'accès insuffisants pour enregistrer la contribution pour ce groupe.',
	'transitions:messages:warning:draft' => 'Il y a un brouillon non enregistré de cette contribution !',
	'transitions:edit_revision_notice' => '(Ancienne version)',
	'transitions:message:deleted_post' => 'Contribution supprimée.',
	'transitions:error:cannot_delete_post' => 'Impossible de supprimer la contribution.',
	'transitions:none' => 'Aucune contribution',
	'transitions:error:missing:title' => 'Vous devez donner un titre à votre contribution !',
	'transitions:error:missing:description' => 'Le corps de votre contribution est vide !',
	'transitions:error:cannot_edit_post' => 'Cette contribution peut ne pas exister ou vous n\'avez pas les autorisations pour la modifier.',
	'transitions:error:post_not_found' => 'Impossible de trouver la contribution spécifiée.',
	'transitions:error:revision_not_found' => 'Impossible de trouver cette révision.',

	// river
	'river:create:object:transitions' => '%s a publié une contribution %s',
	'river:comment:object:transitions' => '%s a commenté la contribution %s',

	// notifications
	'transitions:notify:summary' => 'Nouvelle contribution : %s',
	'transitions:notify:subject' => 'Nouvelle contribution : %s',
	'transitions:notify:body' =>
'
%s a publié une nouvelle contribution : %s

%s

Voir et commenter cette contribution :
%s
',

	// widget
	'transitions:widget:description' => 'Ce widget affiche vos dernières contributions',
	'transitions:moretransitionss' => 'Plus de contributions',
	'transitions:numbertodisplay' => 'Nombre de contributions à afficher',
	'transitions:notransitionss' => 'Aucune contribution'
);
