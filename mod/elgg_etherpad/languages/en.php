<?php
/*
 * @author Florian DANIEL aka Facyla
 */

$en = array(
	'elgg_etherpad' => "Collaborative pads",
	'elgg_etherpad:edit' => "Edit",
	'elgg_etherpad:view' => "Display",
	
	'elgg_etherpad:forms:createpad' => "New public pad",
	'elgg_etherpad:forms:createpad:details' => "Les pads publics ne sont soumis à aucun contrôle d'accès : ils sont ouverts publiquement à tous et le resteront toujours.",
	'elgg_etherpad:forms:creategrouppad' => "New private pad",
	'elgg_etherpad:forms:creategrouppad:details' => "Les pads privés permettent de gérer un contrôle d'accès sur le pad. Privés par défaut, ils peuvent être rendus publics et protégés avec un mot de passe.",
	
	'elgg_etherpad:editpad' => "Modifier les réglages du pad",
	'elgg_etherpad:title' => "Pad title",
	'elgg_etherpad:public' => "Le pad peut-il être visible publiquement ?",
	'elgg_etherpad:password' => "Password",
	'elgg_etherpad:password:details' => "Indiquer le mot de passe pour restreindre l'accès au pad. Laisser vide pour ne pas modifier. Ecrire \"no\" pour supprimer un mot de passe précédemment défini.",
	'elgg_etherpad:createpad' => "Créer le pad public",
	'elgg_etherpad:creategrouppad' => "Créer le pad privé",
	
	'elgg_etherpad:pad:defaultcontent' => "Ce pad a été automatiquement créé pour vous et est en accès restreint. Vous pouvez l'utiliser tel quel, en modifier les autorisations d'accès, ou en créer d'autres.",
	
	'elgg_etherpad:setcookie:error' => "Cookie could not be set : you will probably not be able to access any protected pad.",
	
	// Entity editing
	'elgg_etherpad:entityedit:warning' => "Important : please consider refreshing the page before synchronizing content, as entity content is not updated live !",
	'elgg_etherpad:pushtoentity' => "Push pad content to entity content",
	'elgg_etherpad:pushtoentity:success' => "Entity content updated",
	'elgg_etherpad:pushtoentity:error' => "Entity content could not be updated",
	'elgg_etherpad:pushtopad' => "Push entity content to pad content",
	'elgg_etherpad:pushtopad:success' => "Pad content updated",
	'elgg_etherpad:pushtopad:error' => "Pad content could not be updated",
	'elgg_etherpad:updateaccess:success' => "Access controls updated",
	'elgg_etherpad:updateaccess:error' => "Cannot update access controls",
	
	'elgg_etherpad:editwithpad' => "Edition avec un pad",
	'elgg_etherpad:editwithpad:authorid' => "AuthorID found/created : %s",
	'elgg_etherpad:editwithpad:groupid' => "GroupID found/created : %s",
	'elgg_etherpad:editwithpad:padid' => "padID found/created : %s",
	'elgg_etherpad:editwithpad:sessionid' => "SessionID created : %s",
	
	'elgg_etherpad:editwithpad:invalidentity' => "Invalid or undefined entity (GUID %s)",
	'elgg_etherpad:editwithpad:invalidsubtype' => "Invalid subtype (%s)",
	'' => "",
	'' => "",
	'' => "",
	'' => "",
	'' => "",
	'' => "",
	
	
);

add_translation("en",$en);

