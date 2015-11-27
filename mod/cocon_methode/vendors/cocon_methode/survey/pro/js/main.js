/**
	Objet JSON des données du questionnaire
*/
var survey = {
	"session_id" : "",
	"cycle_id" : "",
	"user_id" : "",
	"group_id" : "",
	"profil_rec" : 0,
	"etat" : 0,
	"active" : 1,
	"val_pt" : 0.0,
	"eco_1" : 0.0,
	"eco_2" : 0.0,
	"eco_3" : 0.0,
	"eco_4" : 0.0,
	"eco_sum" : 0.0,
	"usag_1" : 0.0,
	"usag_2" : 0.0,
	"usag_3" : 0.0,
	"usag_4" : 0.0,
	"usag_sum" : 0.0,
	"profil_theo" : 0,
	"comment_1" : "",
	"comment_2" : "",
	"quest_1" : {
		"nom" : "",
		"prenom" : ""
	},
	"quest_2" : 0,
	"quest_3" : {
		"matiere_1" : "-1",
		"matiere_2" : "-1",
		"matiere_3" : "-1",
		"matiere_4" : "-1"
	},
	"quest_4" : {
		"niveau_1" : "-1",
		"niveau_2" : "-1",
		"niveau_3" : "-1",
		"niveau_4" : "-1"
	},
	"quest_5" : 0,
	"quest_6" : 0,
	"quest_7" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0,
		"l6" : 0,
		"l7" : 0,
		"l8" : 0,
		"l9" : 0,
		"l10" : 0,
		"l11" : 0,
		"autre" : ""
	},
	"quest_8" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0,
		"l6" : 0,
		"l7" : 0,
		"l8" : 0,
		"l9" : 0,
		"l10" : 0,
		"l11" : 0,
		"autre" : ""
	},
	"quest_9" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0
	},
	"quest_10" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0
	},
	"quest_11" : {
		"l1" : 0,
		"l2" : 0,
		"autre" : ""
	},
	"quest_12" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0
	},	
	"quest_13" : {
		"l1" : 0
	},
	"quest_14" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0
	},
	"quest_15" : {
		"l1" : 0,
		"l2" : 0
	},
	"quest_16" : {
		"l1" : 0,
		"l2" : 0
	},
	"quest_17" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0
	},
	"quest_18" : {
		"l1" : 0,
		"l2" : 0
	},	
	"quest_19" : {
		"l1" : 0,
		"l2" : 0
	},	
	"quest_20" : {
		"l1" : 0,
		"l2" : 0
	},	
	"quest_21" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0
	},
	"quest_22" : {
		"l1" : 0,
		"l2" : 0
	},
	"quest_23" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0
	},
	"quest_24" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0,
		"l6" : 0,
		"l7" : 0,
		"autre" : ""
	},
	"quest_25" : {
		"l1" : 0,
		"autre" : ""
	},
	"quest_26" : {
		"l1" : 0,
		"l2" : 0
	},
	"quest_27" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0
	},
	"quest_28" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0
	},
	"quest_29" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0
	},
	"quest_30" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0
	},
	"quest_31" : {
		"l1" : 0,
		"l2" : 0
	},
	"quest_32" : {
		"l1" : 0,
		"l2" : 0,
		"l3" : 0,
		"l4" : 0,
		"l5" : 0,
		"l6" : 0,
		"l7" : 0,
		"l8" : 0,
		"l9" : 0,
		"l10" : 0,
		"l11" : 0,
		"l12" : 0,
		"autre" : ""
	}
};

/**
	Objet JSON de validation des questions
*/
var validation = {
	"page_1" : true,
	"page_2" : true,
	"page_3" : true,
	"page_4" : true,
	"page_5" : true,
	"page_6" : true,
	"page_7" : true,
	"page_8" : true,
	"page_9" : true,
	"page_10" : true,
	"page_11" : true,
	"page_12" : true,
	"page_13" : true,
	"page_14" : true,
	"page_15" : true,
	"page_16" : true,
	"page_17" : true,
	"page_18" : true,
	"page_19" : true,
	"page_20" : true,
	"page_21" : true
}

_page = 22; // Page de départ
_max = 23; // Nombre maximum de page

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
	
	if(survey.etat == 2){
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
	if(survey.etat != 2){
		validateQuestion();
		
		validateSurvey(1, function(_response){
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
	if(survey.etat != 2){
		validateQuestion();
		validateSurvey(1, function(_response){
			showLoading(false);
			console.log(_response);
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
		if(survey.etat != 2){
			validateQuestion();
			validateSurvey(2);
			return;
		}else{
			$("#btnNext").hide();
		}
	}

	if(_page > 0){
		if(survey.etat != 2){
			validateQuestion();
			validateSurvey(1, function(_response){
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
		$("#btnNext").html("Envoyer mes réponses");
	}else{
		$("#btnNext").html("Suivant");
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
	if(_validate == 2){
		
		// Vérification des réponses
		page_error = "";
		if(survey.etat != 2){
			// Questions 1 à 6
			if(survey.quest_1.nom == '' ||
				survey.quest_1.prenom == '' ||
				survey.quest_2 == undefined ||
				survey.quest_3.matiere_1 == '-1' ||
				survey.quest_4.niveau_1 == '-1' ||
				survey.quest_5 == '0' ||
				survey.quest_6 == '0'
			){
					page_error = 1;
			}

			// Questions 7 à 8
			if(survey.quest_7.l1 == undefined ||
				survey.quest_7.l2 == undefined ||
				survey.quest_7.l3 == undefined ||
				survey.quest_7.l4 == undefined ||
				survey.quest_7.l5 == undefined ||
				survey.quest_7.l6 == undefined ||
				survey.quest_7.l7 == undefined ||
				survey.quest_7.l8 == undefined ||
				survey.quest_7.l9 == undefined ||
				survey.quest_7.l10 == undefined ||
				survey.quest_7.l11 == undefined ||
				survey.quest_8.l1 == undefined ||
				survey.quest_8.l2 == undefined ||
				survey.quest_8.l3 == undefined ||
				survey.quest_8.l4 == undefined ||
				survey.quest_8.l5 == undefined ||
				survey.quest_8.l6 == undefined ||
				survey.quest_8.l7 == undefined ||
				survey.quest_8.l8 == undefined ||
				survey.quest_8.l9 == undefined ||
				survey.quest_8.l10 == undefined ||
				survey.quest_8.l11 == undefined
			){
				page_error = 2;
			}

			// Questions 9 à 10
			if(survey.quest_9.l1 == undefined ||
				survey.quest_9.l2 == undefined ||
				survey.quest_9.l3 == undefined ||
				survey.quest_9.l4 == undefined ||
				survey.quest_10.l1 == undefined ||
				survey.quest_10.l2 == undefined ||
				survey.quest_10.l3 == undefined ||
				survey.quest_10.l4 == undefined 
			){
				page_error = 3;
			}

			// Question 11
			if(survey.quest_11.l1 == undefined ||
				survey.quest_11.l2 == undefined
			){
				page_error = 4;
			}

			// Questions 12 à 13
			if(survey.quest_12.l1 == undefined ||
				survey.quest_12.l2 == undefined ||
				survey.quest_13.l1 == undefined
			){
				page_error = 5;
			}

			// Question 14
			if(survey.quest_14.l1 == undefined ||
				survey.quest_14.l2 == undefined ||
				survey.quest_14.l3 == undefined
			){
				page_error = 6;
			}

			// Questions 15 à 16
			if(survey.quest_15.l1 == undefined ||
				survey.quest_15.l2 == undefined ||
				survey.quest_16.l1 == undefined ||
				survey.quest_16.l2 == undefined
			){
				page_error = 7;
			}
			
			// Question 17
			if(survey.quest_17.l1 == undefined ||
				survey.quest_17.l2 == undefined ||
				survey.quest_17.l1 == undefined ||
				survey.quest_17.l2 == undefined ||
				survey.quest_17.l3 == undefined
			){
				page_error = 8;
			}

			// Question 18
			if(survey.quest_18.l1 == undefined ||
				survey.quest_18.l2 == undefined
			){
				page_error = 9;
			}

			// Question 19
			if(survey.quest_19.l1 == undefined ||
				survey.quest_19.l2 == undefined
			){
				page_error = 10;
			}
			
			// Question 20
			if(survey.quest_20.l1 == undefined ||
				survey.quest_20.l2 == undefined
			){
				page_error = 11;
			}
			
			// Question 21
			if(survey.quest_21.l1 == undefined ||
				survey.quest_21.l2 == undefined ||
				survey.quest_21.l3 == undefined ||
				survey.quest_21.l4 == undefined ||
				survey.quest_21.l5 == undefined ||
				survey.quest_21.l6 == undefined
			){
				page_error = 12;
			}
			
			// Question 22
			if(survey.quest_22.l1 == undefined ||
				survey.quest_22.l2 == undefined
			){
				page_error = 13;
			}
			
			// Question 23
			if(survey.quest_23.l1 == undefined ||
				survey.quest_23.l2 == undefined ||
				survey.quest_23.l3 == undefined ||
				survey.quest_23.l4 == undefined
			){
				page_error = 14;
			}
			
			// Questions 24 à 25
			if(survey.quest_24.l1 == undefined ||
				survey.quest_24.l2 == undefined ||
				survey.quest_24.l3 == undefined ||
				survey.quest_24.l4 == undefined ||
				survey.quest_24.l5 == undefined ||
				survey.quest_24.l7 == undefined ||
				survey.quest_25.l1 == undefined			
			){
				page_error = 15;
			}

			// Question 26
			if(survey.quest_26.l1 == undefined ||
				survey.quest_26.l2 == undefined
			){
				page_error = 16;
			}
			
			// Question 27
			if(survey.quest_27.l1 == undefined ||
				survey.quest_27.l2 == undefined ||
				survey.quest_27.l3 == undefined ||
				survey.quest_27.l4 == undefined ||
				survey.quest_27.l5 == undefined
			){
				page_error = 17;
			}
			
			// Question 28
			if(survey.quest_28.l1 == undefined ||
				survey.quest_28.l2 == undefined ||
				survey.quest_28.l3 == undefined
			){
				page_error = 18;
			}

			// Question 29
			if(survey.quest_29.l1 == undefined ||
				survey.quest_29.l2 == undefined ||
				survey.quest_29.l3 == undefined
			){
				page_error = 19;
			}
			
			// Questions 30 à 31
			if(survey.quest_30.l1 == undefined ||
				survey.quest_30.l2 == undefined ||
				survey.quest_30.l3 == undefined ||
				survey.quest_31.l1 == undefined ||
				survey.quest_31.l2 == undefined
			){
				page_error = 20;
			}

			// Question 32
			if(survey.quest_32.l1 == undefined ||
				survey.quest_32.l2 == undefined ||
				survey.quest_32.l3 == undefined ||
				survey.quest_32.l4 == undefined ||
				survey.quest_32.l5 == undefined ||
				survey.quest_32.l6 == undefined ||
				survey.quest_32.l7 == undefined ||
				survey.quest_32.l8 == undefined ||
				survey.quest_32.l9 == undefined ||
				survey.quest_32.l10 == undefined ||
				survey.quest_32.l11 == undefined ||
				survey.quest_32.l12 == undefined
			){
				page_error = 21;
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
				if(survey.etat != 2){
					survey.etat = 2;
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
	
		// Simple enregistrement de la session en cours
		survey.etat = 1;
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
