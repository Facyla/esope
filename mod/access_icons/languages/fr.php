<?php
global $CONFIG;
$iconurl = $CONFIG->url . 'mod/access_icons/graphics/';
$french = array (
	
	'access_icons:title' => "Informations sur les droits d'accès.",
	
	// Settings
	'access_icons:settings:helpurl' => "URL de la page d'aide sur les accès",
	'access_icons:settings:helpurl:help' => "Indiquez l'URL complète de la page qui détaille les divers types d'accès disponibles pour ce site. Cette page sera affichée dans une \"lightbox\" (boîte affichée dans la page), aussi il est préférable qu'elle puisse être affichée sans l'interface du site.<br />Vous pouvez ne rien indiquer pour ne pas afficher de lien du tout sur les niveaux d'accès, ou utiliser le texte configurable ci-dessous à la place.",
	'access_icons:settings:helptext' => "Texte de la page d'aide sur les accès",
	'access_icons:settings:helptext:help' => "Plutôt qu'un lien vers une page, vous pouvez configurer ici directement le texte qui apparaîtra pour expliquer les divers types d'accès disponibles pour ce site. Les informations saisies ici seront affichées dans une \"lightbox\" (boîte affichée dans la page). Vous pouvez utiliser tout type de formatage HTML. Laissez le champ vide pour ne rien afficher du tout (pas de lien), ou écrivez \"RAZ\" pour remettre les valeurs par défaut.",
	'access_icons:settings:helptext:default' => "<table>
	<tr><th>Niveau d'accès'</th><th>Explications</th></tr>
	<tr><td><span class=\"elgg-access elgg-access-default\">Par défaut</span></td><td></td></tr>
	<tr><td><span class=\"elgg-access elgg-access-public\">Public</span></td><td></td></tr>
	<tr><td><span class=\"elgg-access elgg-access-members\">Membres du site</span></td><td></td></tr>
	<tr><td><span class=\"elgg-access elgg-access-group\">Groupe</span></td><td></td></tr>
	<tr><td><span class=\"elgg-access elgg-access-collection\">Liste de contacts</span></td><td></td></tr>
	<tr><td><span class=\"elgg-access elgg-access-friends\">Contacts</span></td><td></td></tr>
	<tr><td><span class=\"elgg-access elgg-access-private\">Privé / Brouillon</span></td><td></td></tr>
	</table>",
	
	// Droits d'accès
	'access_icons:details' => " - Cliquer pour en savoir plus sur tous les droits d'accès disponibles.",
	
	// Default access level (-1)
	'access_icons:default:details' => "Les droits d'accès par défaut du site (ou de votre compte utilisateur le cas échéant) s'appliquent à ce contenu.",
	
	// Private access level (0)
	'access_icons:private:details' => "Cette publication est PRIVÉE : elle n'est accessible par son auteur, ou par un administrateur (du site ou du groupe dans lequel elle est publiée).",
	
	// Members access level (1)
	'access_icons:members:details' => "Cette publication est RÉSERVÉE AUX MEMBRES DU SITE : c'est-à-dire que tous les membres du site peuvent y accéder (ils doivent pour cela être connectés).",
	
	// Public access level (2)
	'access_icons:public:details' => "Cette publication est PUBLIQUE : toute personne disposant du lien vers cette page peut y accéder sans avoir besoin de s\'identifier sur le site (elle peut donc être indexée par les moteurs de recherche).",
	
	// Friends access level (-2)
	'access_icons:friends:details' => "Cette publication est RÉSERVÉE AUX CONTACS DE L'AUTEUR : seuls les contacts de l'auteur peuvent y accéder.",
	
	// Group access level (>2, owned by a group)
	'access_icons:group:details' => "Cette publication est RÉSERVÉE AUX MEMBRES DU GROUPE : seuls les membres de ce groupe peuvent y accéder.",
	
	// Collection access level (>2, owned by a user)
	'access_icons:collection:details' => "Cette publication est RÉSERVÉE A UNE LISTE : seuls les membres d'une liste de contacts de l'auteur peuvent y accéder.",
	
	// Other / unkwnown access level (>2, owned none or other entity)
	'access_icons:other:details' => "Cette publication est RÉSERVÉE A CERTAINS MEMBRES : seuls certains membres et/ou types de membres peuvent y accéder.",
	
);

add_translation("fr",$french);

