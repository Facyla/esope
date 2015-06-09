/**
	Objet JSON des données du questionnaire
*/
var survey = {
	"error" : false,
	"error_string" : "",
	"session_id" : "",
	"cycle_id" : "",
	"user_id" : "",
	"group_id" : "",
	"profil_theo" : 0,
	"etat" : 0,
	"active" : 1,
	"quest_1" : {
		"l1" : ""
	},
	"quest_2" : {
		"l1" : "",
		"l2" : ""
	},
	"quest_3" : {
		"l1" : "",
		"l2" : ""
	},
	"quest_4" : {
		"l1" : ""
	},
	"quest_5" : {
		"l1" : "",
		"l2" : ""
	},
	"quest_6" : {
		"l1" : ""
	},
};

/**
	Objet JSON de validation des questions
*/
var validation = {
	"page_1" : true,
	"page_2" : true
}

_page = 0; // Page de départ
_max = 2; // Nombre maximum de page

/**
	Démarrage
*/
$(document).ready(function(){

	/**
		On récupère les variables GET et on charge la session
		Le questionnaire dioit être appelé depuis un lien de type :
		
		http://lien_questionnaire?gid=[ID Groupe]&uid=[ID enseignant]
	*/
	var qs = new Querystring();
	showLoading(true);
	$.ajax({
		url : "php/loadSession.php",
		type: "POST",
		data:"gid=" + qs.get('gid') + "&uid=" + qs.get('uid'),
		dataType: "json",
		success: loadSession__response
	});
});

/**
	Récupère l'objet JSON retourné par le serveur
*/
function loadSession__response(_response){
	showLoading(false);
	survey = _response;
	if(survey.error == true){
		alert("Une erreur est survenue lors du chargement du questionnaire.\n-> " + survey.error_string);
		return;
	}
	
	if(survey.etat == 1){
		$("#btnSave").css("color", "#eeeeee");
		alert("Vous pouvez consulter vos réponses, mais vous ne pouvez plus les modifier.");
	}
	
	loadPage();
}

/**
	Accès à la page précédente
*/
function prevPage(){
	
	// Sommes-nous déjà à la première page ?
	if(_page == 0){
		return;
	}
	
	/**
		Enregistrement de la page
	*/
	if(survey.etat == 0){
		validateQuestion();
		
		validateSurvey(false, function(_response){
			showLoading(false);
			survey = _response;
			if(survey.error == true){
				alert("Une erreur est survenue lors de l'enregistrement du questionnaire.\n-> " + survey.error_string);
				return;
			}
			_page--;
			loadPage();
		});
	}else{
		_page--;
		loadPage();
	}
}

/**
	Enregistrement du questionnaire
*/
function saveQuest(){
	if(survey.etat == 0){
		validateQuestion();
		validateSurvey(false, function(_response){
			showLoading(false);	
			survey = _response;
			if(survey.error == true){
				alert("Une erreur est survenue lors de l'enregistrement du questionnaire.\n-> " + survey.error_string);
				return;
			}
			alert("Vos réponses ont été enregistrées.");
			return;
		});
	}else{
		return;
	}
}

/**
	Accès à la page suivante
*/
function nextPage(){
	// Sommes-nous à la dernière page ?
	if(_page == _max){
		// On enregistre la page est verrouillons les réponses au questionnaire
		if(survey.etat == 0){
			validateQuestion();
			validateSurvey(true);
			return;
		}else{
			$("#btnNext").hide();
		}
	}

	if(_page > 0){
		if(survey.etat == 0){
			validateQuestion();
			validateSurvey(false, function(_response){
				showLoading(false);
				survey = _response;
				if(survey.error == true){
					alert("Une erreur est survenue lors de l'enregistrement du questionnaire.\n-> " + survey.error_string);
					return;
				}
				_page++;
				loadPage();				
			});
		}else{
			_page++;
			loadPage();
		}
	}else{
		_page++;
		loadPage();
	}
}

/**
	Chargement de la page demandée
*/
function loadPage(){
	showLoading(true);
	$("#app_content").load("php/html.php?page=page_" + _page + "&forced=" + Math.random(), function(){
		showLoading(false);
		loadQuestion();
	});
	
	/**
		Active / Désactive le bouton Précédent
	*/
	if(_page == 0){
		$("#btnPrev").css("color", "#eeeeee");
	}else{
		$("#btnPrev").css("color", "#02658e");
	}

	/**
		Change le bouton Suivant par le bouton Terminer si on est à la dernière page de question
	*/
	if(_page == _max){
		if(survey.etat == 0){
			$("#btnNext").html("Envoyer mes réponses");
		}else{
			$("#btnNext").css("color", "#eeeeee");
			//$("#btnNext").hide();
		}
	}else{
		$("#btnNext").html("Suivant");
		$("#btnNext").css("color", "#02658e");
		$("#btnNext").show();
	}
}

/**
	Validation des réponses avant envoi au serveur
	si _validate = 1, alors on verrouillera la session de réponses (modification des réponses impossible par la suite)
	_callback est la fonction JS a appelé suite à la validation.
*/
function validateSurvey(_validate, _callback){

	// On passe par la vérification si _validate = 1 (verrouillage de la session de réponses)
	if(_validate == 1){
		
		// Vérification des réponses
		page_error = "";
		if(survey.etat == 0){
			// Questions 1 à 3
			if(survey.quest_1.l1 == undefined ||
				survey.quest_2.l1 == undefined ||
				survey.quest_2.l2 == undefined ||
				survey.quest_3.l1 == undefined ||
				survey.quest_3.l2 == undefined){
					page_error = 1;
			}

			// Questions 4 à 6
			if(survey.quest_4.l1 == undefined ||
				survey.quest_5.l1 == undefined ||
				survey.quest_5.l2 == undefined ||
				survey.quest_6.l1 == undefined){
					page_error = 2;
			}
		}
		
		// Teste si il y a des erreurs dans les réponses
		if(page_error != ""){
			// Il y a des réponses oubliées, on envoi à la page pour complèter
			alert("Merci de prendre le temps de répondre à toutes les questions.");
			_page = parseInt(page_error);
			loadPage();
			
		}else{
		
			// Affiche un message alertant sur le fait que les réponses seront verrouillées et ne pourront plus être changées
			r = confirm("Vos réponses seront prises en compte. Vous ne pourrez plus les modifier. Continuer ?");
			if(r){
				if(survey.etat == 0){
					survey.etat = 1;
					saveSession(function(_response){
						showLoading(false);
						survey = _response;
						if(survey.error == true){
							alert("Une erreur est survenue lors de l'enregistrement questionnaire.\n-> " + survey.error_string);
							return;
						}
						$("#app_content").load("php/html.php?page=page_end&forced=" + Math.random());
						$("#btnPrev").hide();
						$("#btnSave").hide();
						$("#btnNext").hide();
					});
				}
			}
		}
	}else{
	
		// Simple enregistrement de la session encours
		saveSession(_callback);
	}
}

/**
	Enregistrement de la session sur le serveur
	si _validate = 1, alors on verrouillera la session de réponses (modification des réponses impossible par la suite)
	_callback est la fonction JS a appelé suite à la validation.	
*/
function saveSession(_callback){
	showLoading(true);
	$.ajax({
		url: "php/saveSession.php",
		type: "POST",
		data: "json=" + JSON.stringify(survey), 
		dataType: "json",
		success: _callback
	});	
}

/**
	Affiche/cache l'animation de chargement
*/
function showLoading(_show){
	if(_show){
		$('#app_loader').css('display', 'block');
	}else{
		$('#app_loader').css('display', 'none');
	}
}
