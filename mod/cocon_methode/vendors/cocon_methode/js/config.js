/**
	Fichier de configuration Javascript
*/

// Constantes
var ROLE_PRINCIPAL = 0;
var ROLE_EQUIPE = 1;
var ROLE_AUTRE = 2;

// Variables pour les liens vers les outils CoCon
var cocon_url = "http://cocon.eduscol.education.fr";
var group_url = cocon_url + "/groups/profile/";
var activite_group_url = cocon_url + "/groups/activity/";
var agenda_group_url = cocon_url + "/groups/event_calendar/";
var annonces_group_url = cocon_url + "/announcements/groups/";
var blog_group_url = cocon_url + "/blog/groups/";
var boite_a_idees_group_url = cocon_url + "/brainstorm/groups/";
var fichiers_group_url = cocon_url + "/file/groups/";
var forum_group_url = cocon_url + "/discussion/owner/";
var liens_web_group_url = cocon_url + "/bookmarks/groups/";
var wiki_group_url = cocon_url + "/pages/groups/";
var annuaire_url = cocon_url + "/members";

// Objet JSON pour pour le visiteur connecté
var config = {
	"error" : false,
	"error_string" : "",
	"cycle_id" : "",
	"group_id" : "",
	"group_name" : "", // Nom du groupe CoCon associé au visiteur
	"user_id" : "", // ID du visiteur
	"user_name" : "", // Nom et prénom du visiteur
	"user_role" : -1 // Role du visiteur
};

// Méthodes javascript

/**
	Chargement des infos depuis CoCon
*/
function loadConfig(){
	$.ajax({
		type: "POST",
		url: "php/loadConfig.php",
		dataType: "json",
		success: loadConfig__response
	});
}

/**
	_response est un objet JSON retourné par le serveur CoCon
	Attributs :
	.error = si true, une erreur s'est produite lors de la récupération des infos
	.error_string chaine contenant le message d'erreur
	.cycle_id = chaine contenant l'ID du cycle
	.group_id = chaine contenant l'ID du groupe
	.group_name = chaine contenant le nom du groupe
	.user_id = chaine contenant l'ID de l'utilisateur
	.user_name = chaine contenant les nom et prénom de l'utilisateur
	.user_role = chaine contenant le type de rôle de l'utilisateur
*/
function loadConfig__response(_response){
	if(_response.error){
		alert(_response.error_string);
		return false;
	}
		
	config = _response;
	loadPage("presentation", "temps_0");
}