<?php
/**
 * Likes French language file
 */

$french = array(
	'likes:this' => "a apprécié cette publication",
	'likes:deleted' => "Votre appréciation a été retirée",
	'likes:see' => "Voir ceux qui ont apprécié cette publication",
	'likes:remove' => "N'apprécie pas cette publication",
	'likes:notdeleted' => "Il y a eu un problème lors de la suppression de l'appréciation",
	'likes:likes' => "Vous appréciez cette publication",
	'likes:failure' => "Il y a eu un problème d'appréciation sur cet élément",
	'likes:alreadyliked' => "Vous avez déjà porté votre appréciation cette publication",
	'likes:notfound' => "L'élément que vous essayez d'apprécier ne peut être trouvé",
	'likes:likethis' => "apprécie cette publication",
	'likes:userlikedthis' => "%s apprécie",
	'likes:userslikedthis' => "%s apprécient",
	'likes:river:annotate' => "apprécie",
	'likes:email:body' => "%s a apprécié %s",
	'likes:email:subject' => "Un utilisateur a apprécié quelque chose",
	'river:likes' => "apprécie %s %s",

	// notifications. yikes.
	'likes:notifications:subject' => '%s apprécie votre publication "%s"',
	'likes:notifications:body' =>
'Bonjour %1$s,

%2$s apprécie votre publication "%3$s" sur %4$s

Retrouvez votre publication via :
%5$s

ou consultez le profil de  %2$s via :
%6$s

Merci,
%4$s
',
	'likes:delete:confirm' => "Etes-vous sûr(e) de vouloir annuler votre appréciation ?",

);


add_translation("fr", $french);
