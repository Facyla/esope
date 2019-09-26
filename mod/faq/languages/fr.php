<?php

return array(
	// Main Title
	'faq' => "Foire Aux Questions",
	'faq:title' => "Foire Aux Questions",
	'faq:shorttitle' => "FAQs",
	'faq:sidebar:categories' => "Catégories de la FAQ",

	'item:object:faq' => "FAQs",

	// Add
	'faq:add' => "Nouvelle FAQ",
	'faq:add:title' => "Nouvelle question",
	'faq:add:question' => "Question",
	'faq:add:category' => "Catégorie",
	'faq:add:answer' => "Réponse",

	'faq:add:oldcat:please' => "Sélectionnez une catégorie",
	'faq:add:oldcat:new' => "Saisissez une nouvelle catégorie",

	'faq:add:check:question' => "Veuillez entrer une question.",
	'faq:add:check:category' => "Veuillez entrer une catégorie.",
	'faq:add:check:answer' => "Veuillez entrer une réponse.",

	'faq:add:error:invalid_input' => "Erreur lors de l'enregistrement&nbsp;: entrée invalide, veuillez vérifier tous les champs.",
	'faq:add:error:save' => "Erreur inconnue lors de l'enregistrement.",
	'faq:add:success' => "Nouvelle FAQ ajoutée.",

	// Edit
	'faq:edit:title' => "Editer une question",
	'faq:edit:error:invalid_input' => "Erreur lors de l'enregistrement&nbsp;: entrée invalide, veuillez vérifier tous les champs.",
	'faq:edit:error:invalid_object' => "Erreur d'édition&nbsp;: objet invalide, il semble que la FAQ que vous essayez d'éditer n'existe pas.",
	'faq:edit:error:save' => "Erreur inconnue lors de l'enregistrement.",
	'faq:edit:success' => "La FAQ a bien été modifiée.",

	// Delete
	'faq:delete:confirm' => "Confirmez-vous vouloir supprimer cette FAQ&nbsp;?",
	'faq:delete:success' => "FAQ supprimée.",
	'faq:delete:error:delete' => 'La suppression de la FAQ a échoué.',
	'faq:delete:error:invalid_object' => 'Erreur lors de la suppressio&nbsp;: objet FAQ invalide.',
	'faq:delete:error:invalid_input' => 'Erreur lors de la suppression&nbsp;: aucun objet FAQ indiqué.',

	// Settings
	'faq:settings:public' => "La FAQ doit-elle être publiquement disponible (sinon seulement pour les administrateurs)&nbsp;? ",
	'faq:settings:publicAvailable_sitemenu'  => "L'entrée FAQ du menu du site doit-elle être visible hors connexion&nbsp;? ",
	'faq:settings:publicAvailable_footerlink' => "L'entrée FAQ du menu du pied de page doit-elle être visible hors connexion&nbsp;? ",
	'faq:settings:ask' => "Permettre aux membres de poser des questions&nbsp;? ",
	'faq:settings:minimum_search_tag_size' => "Longeur minimum des mots-clefs&nbsp;: ",
	'faq:settings:minimum_hit_count' => "Nombre de vues minimum&nbsp;: ",

	// Search
	'faq:search:noresult' => "Aucun résultat trouvé.",
	'faq:search:hitcount' => "Compteur de hits&nbsp;: ",
	'faq:search:title' => "Rechercher dans la FAQ",
	'faq:search:label' => "Veuillez entrer le(s) terme(s) à rechercher dans la FAQ&nbsp;: ",
	'faq:search:description' => "(La longueur minimale des termes valides est de %s caractères. Un terme doit apparaître au moins %s fois dans la FQ pour être affiché dans les résultats.)",

	// List a category
	'faq:list:category_title' => "Catégorie&nbsp;: ",
	'faq:list:no_category' => "Aucune catégorie valide sélectionnée.",
	'faq:list:edit:new_category' => "Veuillez indiquer une nouvelle catégorie.",
	'faq:list:edit:confirm:question' => "Confirmez-vous vouloir déplacer ",
	'faq:list:edit:confirm:category' => " question(s) vers la catégorie ",
	'faq:list:edit:category:please' => "Veuillez sélectionner une ou plusieurs questions à déplacer.",
	'faq:list:edit:begin' => "Changer de catégorie",
	'faq:list:edit:all' => "Tout sélectionner",
	'faq:list:edit:none' => "Tout désélectionner",
	'faq:list:edit:select:choice' => "- Veuillez choisir une catégorie",
	'faq:list:edit:select:new' => "- Créer une nouvelle catégorie",

	// Change category
	'faq:change_category:description' => "Sélectionnez au moins une des questions ci-dessus que vous souhaitez déplacer vers une autre catégorie. Puis sélectionnez la nouvelle catégorie ci-dessous. (Astuce&nbsp;: pour renommer une catégorie sélectionnez toutes les questions de cette catégorie et saisissez le nouveau om ci-dessous.)",
	'faq:change_category:new_category' => "Nouvelle catégorie&nbsp;: ",
	'faq:change_category:error:input' => "Saisie invalide.",
	'faq:change_category:error:no_faq' => "Aucun objet FAQ  fourni.",
	'faq:change_category:error:save' => "Une erreur est survenue lors de l'enregistrement de la FAQ, veuillez réessayer.",
	'faq:change_category:success' => "La FAQ a bien été enregistrée.",

	// Ask a question
	'faq:ask' => "Poser une question",
	'faq:ask:title' => "Poser une question",
	'faq:ask:label' => "Pas de réponse dans la FAQ&nbsp;? Posez votre question ici&nbsp;: ",
	'faq:ask:description' => "(Votre question pourra être ajoutée à la FAQ, ou pas. Dans tous les cas vous recevrez une réponse.)",
	'faq:ask:button' => "Demander",
	'faq:ask:new_question:subject' => "Votre question a bien été envoyée",
	'faq:ask:new_question:message' => "Merci d'avoir envoyé votre question.

L'équipe du site va faire au mieux pour répondre à votre question&nbsp;:

%s

aussitôt que possible.

WVotre question pourra être ajoutée à la FAQ. Vous serez notifié avec une réponse et si votre question a été incluse ou non dans la FAQ.",

	'faq:ask:new_question:send' => "Votre question a été ajoutée, et vous recevrez une notification à ce propos.",
	'faq:ask:error:not_send' => "Votre question a été ajoutée, mais il n'a pas été possible de vous envoyer une notification à ce propos.",
	'faq:ask:error:save' => "Une erreur est survenue lors de l'enregistrement de votre question, veuillez réessayer.",
	'faq:ask:error:no_user' => "Une erreur est survenue, veuillez indiquer un compte de membre valide.",
	'faq:ask:error:input' => "Une erreur est survenue, saisie invalide. Veuillez réessayer.",
	'faq:ask:notify:admin:subject' => "Une nouvelle question a été posée",
	'faq:ask:notify:admin:message' => "Cher(Chère) %s,

Une nouvelle question a été ajoutée dans la FAQ.

Pour consulter la(les) question(s) en attente, veuillez cliquer sur&nbsp;:

%s",

	// View asked questions
	'faq:asked' => "Questions des membres (%s)",
	'faq:asked:title' => "Questions soumises par les membres",
	'faq:asked:no_questions' => "Aucune question sans réponse en ce moment.",
	'faq:asked:not_allowed' => "Les membres ne sont pas autorisés à poser des questions. Si vous souhaitez le leur permettre, vérifiez les Paramètres du plugin.",
	'faq:asked:added' => "Ajouté&nbsp;:",
	'faq:asked:add' => "Ajouter cette question à la FAQ",
	'faq:asked:by' => "posé par&nbsp;: ",
	'faq:asked:check:add' => "Veuillez choisir si cette question doit être ajoutée à la FAQ",

	// Answer an asked question
	'faq:answer:notify:subject' => "Une réponse a été apportée à votre question",
	'faq:answer:notify:message:added:same' => "La question que vous aviez posée&nbsp;:

%s

a reçu une réponse. La réponse peut être consultée sur&nbsp;:

%s

Et ainsi que vous pouvez le constater votre question a été ajoutée à la FAQ.",

	'faq:answer:notify:message:added:adjusted' => "La question que vous aviez posée&nbsp;:

%s

a reçu une réponse. Toutefois la question a été modifiée ainsi&nbsp;:

%s

La réponse peut être trouvée sur&nbsp;:

%s

Et ainsi que vous pouvez le constater votre question a été ajoutée à la FAQ.",

	'faq:answer:success:added:send' => "La question a été ajoutée à la FAQ et le membre notifié.",
	'faq:answer:error:added:not_send' => "La question a été ajoutée à la FAQ mais le membre n'a pas pu être notifié.",
	'faq:answer:error:save' => "Une erreur est survenue lors de l'enregistrement de la FAQ.",
	'faq:answer:error:remove' => "Une erreur est survenue lors de la suppression de la question, veuillez réessayer.",
	'faq:answer:error:no_cat' => "Erreur&nbsp;: une catégorie invalide a été fournie, veuillez réessayer.",
	'faq:answer:notify:not_added:same' => "La question que vous aviez posée&nbsp;:

%s

a reçu une réponse. La réponse est&nbsp;:

%s

Votre question n'a PAS été ajoutée à la FAQ.",

	'faq:answer:notify:not_added:adjusted' => "La question que vous aviez posée&nbsp;:

%s

a reçu une réponse. Toutefois la question a été modifiée ainsi&nbsp;:

%s

La réponse est&nbsp;:

%s

Votre question n'a PAS été ajoutée à la FAQ.",

	'faq:answer:success:not_added:send' => "Le membre a bien été notifié de la réponse.",
	'faq:answer:error:not_added:not_send' => "Erreur lors de l'envoi de la notification au membre.",
	'faq:answer:error:no_faq' => "Erreur&nbsp;: objet FAQ non valide.",
	'faq:answer:error:input' => "Erreur&nbsp;: saisie invalide, veuillez réessayer.",

	// Stats page
	'faq:stats:categories' => "Cette FAQ contient %s catégories,",
	'faq:stats:questions' => " avec %s questions/réponses au total.",
	'faq:stats:user' => "Il y a %s questions des membres en attente d'une réponse."
);