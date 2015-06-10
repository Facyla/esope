<?php
$url = elgg_get_site_url();
$iconurl = $url . 'mod/access_icons/graphics/';

return array(
	'access_icons' => "Icônes d'accès",
	'access_icons:title' => "Informations sur les droits d'accès.",
	
	// Settings
	'access_icons:settings:helpurl' => "URL de la page d'aide sur les accès",
	'access_icons:settings:helpurl:help' => "Indiquez l'URL complète de la page qui détaille les divers types d'accès disponibles pour ce site. Cette page sera affichée dans une \"lightbox\" (boîte affichée dans la page), aussi il est préférable qu'elle puisse être affichée sans l'interface du site (utilisation de cmspages conseillée).<br />Vous pouvez ne rien indiquer pour ne pas afficher de lien du tout sur les niveaux d'accès.",
	'access_icons:settings:helptext' => "Texte de la page d'aide sur les accès",
	'access_icons:settings:helptext:help' => "Plutôt qu'un lien vers une page, vous pouvez configurer ici directement le texte qui apparaîtra pour expliquer les divers types d'accès disponibles pour ce site. Les informations saisies ici seront affichées dans une \"lightbox\" (boîte affichée dans la page). Vous pouvez utiliser tout type de formatage HTML. Laissez le champ vide pour ne rien afficher du tout (pas de lien), ou écrivez \"RAZ\" pour charger les valeurs par défaut.",
	
	'access_icons:settings:helptext:details' => "Pour créer votre page d'explications, il est recommandé d'utilisé le plugin cmpspages, qui vous permet de créer une page qui peut être affichée sans l'interface du site, en ajoutant ?embed=true. <strong><a href=\"" . $url . "cmspages/?pagetype=help-access\" target=\"_new\">Cliquez ici pour créer cette page</a></strong>, puis utilisez <strong>" . $url . "cmspages/read/<i>help-access</i>?embed=true</strong> dans le champ ci-dessus.<br />Note : vous pouvez remplacer <i>help-access</i> par l'élément d'URL de votre choix.<br /><br /><strong>Voici ci-dessous un exemple de texte à copier-coller dans cette page, libre à vous de l'adapter à votre convenance&nbsp;:</strong>",
	
	'access_icons:settings:helptext:default' => "<p>Il est essentiel de d&eacute;finir correctement les droits d'acc&egrave;s lorsque vous faites de nouvelles publications, afin de garantir que les informations que vous publi&eacute;es sont partag&eacute;es avec les bonnes personnes.</p>
<p>Seules les personnes avec lesquelles vous partagez vos publications y auront acc&egrave;s. Les autres ne sauront pas que vous avez publi&eacute; quelque chose.</p>
<p>Ainsi, si vous cr&eacute;ez un article en mode \"Priv&eacute;\", personne ne pourra le lire. Inversement, pour qu'une image puisse &ecirc;tre ins&eacute;r&eacute;e dans un article qui sera visible hors connexion, elle doit &ecirc;tre publi&eacute;e en mode \"Public\".</p>
<p>&nbsp;</p>
<table>
<tbody>
<tr><th>Niveau d'acc&egrave;s</th><th>Explications</th></tr>
<tr>
<td><span class=\"elgg-access elgg-access-default\">Par d&eacute;faut</span></td>
<td>&nbsp;Il ne s'agit pas d'un niveau d'acc&egrave;s au sens propre, mais du <strong>niveau d'acc&egrave;s d&eacute;fini par d&eacute;faut</strong> pour toutes les nouvelles publications. C'est le niveau d'acc&egrave;s qui s'applique pour toute nouvelle publication.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-public\">Public</span></td>
<td>&nbsp;La publication est <strong>visible par tout le monde</strong>. Cela inclut tout visiteur du site, y compris les non-membres : il n'est pas n&eacute;cessaire de s'identifier sur le site pour y acc&eacute;der, et votre publication peut &ecirc;tre lue et index&eacute;e par les moteurs de recherche.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-members\">Membres du site</span></td>
<td>&nbsp;La publication est visible par <strong>tous les membres</strong> du site, c'est-&agrave;-dire par toute personne qui dispose d'un compte sur la plateforme.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-group\">Groupe</span></td>
<td>&nbsp;La publication est visible seulement par&nbsp;les membres d'un<strong> groupe particulier</strong>.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-collection\">Liste de contacts</span></td>
<td>&nbsp;La publication est visible par les membres d'une <strong>liste de contacts</strong>. Chaque membre peut cr&eacute;er ses propres listes de contacts, qui sont strictement personnelles (pour une liste partag&eacute;e, il est pr&eacute;f&eacute;rable d'utiliser un groupe).</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-friends\">Contacts</span></td>
<td>&nbsp;La publication est visible uniquement par les <strong>contacts de l'auteur</strong>.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-private\">Priv&eacute; / Brouillon</span></td>
<td>&nbsp;La publication n'est visible que par <strong>vous</strong>.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-public elgg-access-limited\">Limit&eacute;</span></td>
<td>&nbsp;Cas particulier : lorsque le site est en mode \"intranet\", le niveau d'acc&egrave;s \"Public\" est remplac&eacute; par \"Limit&eacute;\" : seuls les utilisateurs connect&eacute;s y ont acc&egrave;s. En pratique, ce niveau est &eacute;quivalent &agrave; \"Membres du site\".</td>
</tr>
</tbody>
</table>",
	
	// Droits d'accès
	'access_icons:details' => " - Cliquez pour en savoir plus sur tous les droits d'accès disponibles.",
	
	// Default access level (-1)
	'access_icons:default:details' => "Les droits d'accès par défaut du site (ou de votre compte utilisateur le cas échéant) s'appliquent à ce contenu.",
	
	// Private access level (0)
	'access_icons:private:details' => "Cette publication est PRIVÉE : elle n'est accessible par son auteur, ou par un administrateur (du site ou du groupe dans lequel elle est publiée).",
	
	// Members access level (1)
	'access_icons:members:details' => "Cette publication est RÉSERVÉE AUX MEMBRES DU SITE : c'est-à-dire que tous les membres du site peuvent y accéder (ils doivent pour cela être connectés).",
	
	// Public access level (2)
	'access_icons:public:details' => "Cette publication est PUBLIQUE : toute personne disposant du lien vers cette page peut y accéder sans avoir besoin de s'identifier sur le site (elle peut donc être indexée par les moteurs de recherche).",
	
	// Friends access level (-2)
	'access_icons:friends:details' => "Cette publication est RÉSERVÉE AUX CONTACS DE L'AUTEUR : seuls les contacts de l'auteur peuvent y accéder.",
	
	// Group access level (>2, owned by a group)
	'access_icons:group:details' => "Cette publication est RÉSERVÉE AUX MEMBRES DU GROUPE : seuls les membres de ce groupe peuvent y accéder.",
	
	// Collection access level (>2, owned by a user)
	'access_icons:collection:details' => "Cette publication est RÉSERVÉE A UNE LISTE : seuls les membres d'une liste de contacts de l'auteur peuvent y accéder.",
	
	// Other / unkwnown access level (>2, owned none or other entity)
	'access_icons:other:details' => "Cette publication est RÉSERVÉE A CERTAINS MEMBRES : seuls certains membres et/ou types de membres peuvent y accéder.",
	
	// Access levels
	'access:-2' => 'Contacts',
	'access:-1' => 'Par défaut',
	'access:0' => 'Privé / brouillon',
	'access:1' => 'Membres du site',
	'access:2' => 'Public',
	
);

