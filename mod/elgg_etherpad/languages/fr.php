<?php
/*
 * @author Florian DANIEL aka Facyla
 */

$fr = array(
	'elgg_etherpad' => "Pads collaboratif",
	'elgg_etherpad:edit' => "Edition",
	'elgg_etherpad:view' => "Affichage",
	
	'elgg_etherpad:forms:createpad' => "Nouveau pad public",
	'elgg_etherpad:forms:createpad:details' => "Les pads publics ne sont soumis à aucun contrôle d'accès : ils sont ouverts publiquement à tous. Attention : une fois créés, les pads publics ne peuvent pas être modifiés pour les rendre privés !",
	'elgg_etherpad:forms:creategrouppad' => "Nouveau pad personnel",
	'elgg_etherpad:forms:creategrouppad:details' => "Les pads personnels vous permettent de gérer un contrôle d'accès sur le pad. Privés par défaut, ils peuvent être rendus publics et protégés avec un mot de passe.",
	
	'elgg_etherpad:editpad' => "Modifier les réglages du pad",
	'elgg_etherpad:title' => "Nom du pad",
	'elgg_etherpad:public' => "Le pad peut-il être visible publiquement ?",
	'elgg_etherpad:password' => "Mot de passe",
	'elgg_etherpad:password:details' => "Indiquer le mot de passe pour restreindre l'accès au pad. Laisser vide pour ne pas modifier. Ecrire \"no\" pour supprimer un mot de passe précédemment défini.",
	'elgg_etherpad:createpad' => "Créer le pad public",
	'elgg_etherpad:creategrouppad' => "Créer le pad privé",
	
	'elgg_etherpad:pad:defaultcontent' => "Ce pad a été automatiquement créé pour vous et est en accès restreint. Vous pouvez l'utiliser tel quel, en modifier les autorisations d'accès, ou en créer d'autres.",
	
	'elgg_etherpad:setcookie:error' => "Impossible de créer le cookie de session vers Etherpad Lite : vous ne pourrez accéder qu'aux pads publics !",
	
	// Entity editing
	'elgg_etherpad:entityedit:warning' => "Important : veuillez rafraîchir la page avant de copier le texte depuis ou vers le pad, car le contenu de la publicaiton n'est pas mis à jour en temps réel et peut avoir changé !",
	'elgg_etherpad:pushtoentity' => "Copier le contenu du pad vers la publication",
	'elgg_etherpad:pushtoentity:success' => "Le contenu de la publication a été mis à jour",
	'elgg_etherpad:pushtoentity:error' => "Le contenu de la publication n'a pas pu être mis à jour",
	'elgg_etherpad:pushtopad' => "Copier le contenu de la publication vers le pad",
	'elgg_etherpad:pushtopad:success' => "Le contenu du pad a été mis à jour",
	'elgg_etherpad:pushtopad:error' => "Le contenu du pad n'a pas pu être mis à jour",
	'elgg_etherpad:updateaccess:success' => "Les contrôles d'accès ont été mis à jour",
	'elgg_etherpad:updateaccess:error' => "Impossible de mettre à jour les contrôles d'accès",
	
	'elgg_etherpad:menu:editwithpad' => "<i class=\"fa fa-edit\"></i> Pad",
	'elgg_etherpad:editwithpad' => "Edition avec un pad",
	'elgg_etherpad:editwithpad:authorid' => "AuthorID trouvé ou créé : %s",
	'elgg_etherpad:editwithpad:groupid' => "GroupID trouvé ou créé : %s",
	'elgg_etherpad:editwithpad:padid' => "padID trouvé ou créé : %s",
	'elgg_etherpad:editwithpad:sessionid' => "SessionID créée : %s",
	
	'elgg_etherpad:editwithpad:invalidentity' => "Entité non valide ou non définie (GUID %s)",
	'elgg_etherpad:editwithpad:invalidsubtype' => "Ce type de contenu (%s) ne peut pas être édité avec un pad",
	
	'elgg_etherpad:viewpad' => "Affichage du pad %s",
	'elgg_etherpad:vieweditpad' => "Edition collaborative",
	'elgg_etherpad:vieweditpad:details' => "Vous pouvez utiliser ce pad pour éditer le contenu.<br />Pour cela donnez l'adresse suivante aux participants : %s<br />Si le pad est public, vous pouvez aussi le partager avec d'autres participants avec cette adresse : %s<br />Une fois que vous avez terminé, l'un des participants doit synchroniser le contenu sur la plateforme. Pour cela, rechargez la page (au cas où quelqu'un ait édité la publication entretemps), vérifiez que tout va bien, et cliquez sur le bouton \"Copier le contenu du pad vers la publication\".",
	'elgg_etherpad:vieweditentity' => "Publication à éditer collaborativement",
	'elgg_etherpad:vieweditentity:details' => "Voici la publication à éditer. Vous pouvez synchroniser son contenu vers le pad, ou récupérer le contenu du pad pour remplacer celui-ci.",
	
	'elgg_etherpad:pad:url' => "Adresse du Pad",
	'elgg_etherpad:pad:publicurl' => "Adresse publique du Pad",
	'elgg_etherpad:public' => "<i class=\"fa fa-unlock\"></i> PUBLIC",
	'elgg_etherpad:private' => "<i class=\"fa fa-lock\"></i> NON PUBLIC",
	'elgg_etherpad:access:current' => "Etat actuel",
	'elgg_etherpad:passwordprotected' => "<i class=\"fa fa-key\"></i> PROTEGE PAR MOT DE PASSE",
	'elgg_etherpad:nopassword' => "(SANS MOT DE PASSE)",
	'elgg_etherpad:publiconly' => "Ce pad a été créé comme \"pad public\" (hors groupe), et ne peut pas être rendu privé ni protégé par un mot de passe.",
	'elgg_etherpad:viewpad' => "<i class=\"fa fa-eye\"></i> Afficher la page de visualisation du pad",
	
);

add_translation("fr",$fr);

