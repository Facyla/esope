<?php

$french = array(

	/**
	 * Menu items and titles
	 */

	'messageboard:board' => "Mur",
	'messageboard:messageboard' => "mur",
	'messageboard:viewall' => "Voir tout",
	'messageboard:postit' => "Publier ",
	'messageboard:history:title' => "Historique",
	'messageboard:none' => "Il n'y a encore rien sur ce Mur",
	'messageboard:num_display' => "Nombre de messages à afficher",
	'messageboard:desc' => "Ceci est un Mur que vous pouvez ajouter sur votre profil, et où les autres membres peuvent laisser un message.",

	'messageboard:user' => "Mur de %s",

	'messageboard:replyon' => "réponse sur",
	'messageboard:history' => "historique",

	'messageboard:owner' => "mur de %s",
	'messageboard:owner_history' => "%s a envoyé un message sur le mur de %s",

	/**
	 * Message board widget river
	 */
	'messageboard:river:added' => "a écrit sur",
	'messageboard:river:user' => "de %s",
	'messageboard:river:messageboard' => "mur",


	/**
	 * Status messages
	 */

	'messageboard:posted' => "Votre message a bien été publié sur le mur.",
	'messageboard:deleted' => "Votre message a bien été supprimé.",

	/**
	 * Email messages
	 */

	'messageboard:email:subject' => "Vous avez un nouveau message sur votre mur !",
	'messageboard:email:body' => "Vous avez reçu un nouveau message de %s sur votre mur :


%s


Pour voir les messages sur votre mur, cliquez sur :

	%s

Pour voir le profil de %s, cliquez sur :

	%s

Vous ne pouvez pas répondre à cet email.",

	/**
	 * Error messages
	 */

	'messageboard:blank' => "Désolé, vous devez écrire quelque chose dans le corps du message avant de pouvoir l'enregistrer.",
	'messageboard:notfound' => "Désolé, l'élément spécifié n'a pu être trouvé.",
	'messageboard:notdeleted' => "Désolé, le message n'a pu être supprimé.",
	'messageboard:somethingwentwrong' => "Quelque chose a tourné court lors de l'enregistrement de votre message, veuillez vérifier que vous avez bien écrit un message.",

	'messageboard:failure' => "Une erreur imprévue s'est produite lors de l'ajout de votre message. Veuillez réeessayer.",

);

add_translation("fr", $french);

