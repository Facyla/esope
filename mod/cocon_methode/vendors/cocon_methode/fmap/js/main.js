/**
	Objet JSON des données de la fiche de mise en pratique
*/
var fiche = {
	"error" : false,
	"error_string" : "",
	"fiche_id" : "",
	"cycle_id" : "",
	"group_id" : "",
	"user_id" : "",
	"active" : 1,
	"nom" : "",
	"theme" : "",
	"equipe" : "",
	"zone1" : "",
	"zone2" : "",
	"zone3" : "",
	"zone4" : "",
	"zone5" : "",
	"zone6" : "",
	"zone7" : "",
	"zone8" : "",
	"zone9" : "",
	"zone10" : "",
	"zone11" : ""
}

_page = 0;
_max = 4;

/**
	Démarrage
*/
$(document).ready(function(){

	/**
		On récupère les variables GET et on charge la fiche
		L'éditeur de fiche doit être être appelé depuis un lien de type :
		
		http://lien_editeur_fiche?fid=[ID de la fiche a afficher]&cid=[ID du cycle en cours]&gid=[ID Groupe]&uid=[ID enseignant]
	*/
	var qs = new Querystring();
	showLoading(true);
	$.ajax({
		url : "php/loadFiche.php",
		type: "POST",
		data:"fid=" + qs.get('fid') + "&cid=" + qs.get('cid') + "&gid=" + qs.get('gid') + "&uid=" + qs.get('uid'),
		dataType: "json",
		success: loadFiche__response
	});
});

/**
	Récupère l'objet JSON retourné par le serveur
*/
function loadFiche__response(_response){
	showLoading(false);
	fiche = _response;
	if(fiche.error == true){
		alert("Une erreur est survenue lors du chargement de la fiche.\n-> " + fiche.error_string);
		return;
	}
	
	loadPage();
}

/**
	Accès à la page précédente
*/
function prevPage(){
	
	// Sommes-nous déjà à la première page ?
	if(_page == 0){
		validateFields();
		validateFiche(function(_response){
			showLoading(false);
			fiche = _response;
			if(fiche.error == true){
				alert("Une erreur est survenue lors de l'enregistrement de la fiche.\n-> " + fiche.error_string);
				return;
			}
			exitEditor();
		});		
		return;
	}
	
	/**
		Enregistrement de la page
	*/
	validateFields();
	validateFiche(function(_response){
		showLoading(false);
		fiche = _response;
		if(fiche.error == true){
			alert("Une erreur est survenue lors de l'enregistrement de la fiche.\n-> " + fiche.error_string);
			return;
		}
		_page--;
		loadPage();
	});
}

/**
	Enregistrement de la fiche
*/
function enregistreFiche(){
	validateFields();
	validateFiche(function(_response){
		showLoading(false);	
		fiche = _response;
		if(fiche.error == true){
			alert("Une erreur est survenue lors de l'enregistrement de la fiche.\n-> " + fiche.error_string);
			return;
		}
		alert("Vos modifications ont été enregistrées.");
		return;
	});
}

/**
	Accès à la page suivante
*/
function nextPage(){
	if(_page == _max){
		validateFields();
		validateFiche(function(_response){
			showLoading(false);
			fiche = _response;
			if(fiche.error == true){
				alert("Une erreur est survenue lors de l'enregistrement de la fiche.\n-> " + fiche.error_string);
				return;
			}
			exitEditor();
		});		
		return;
	}
	
	validateFields();
	validateFiche(function(_response){
		showLoading(false);
		fiche = _response;
		if(fiche.error == true){
			alert("Une erreur est survenue lors de l'enregistrement de la fiche.\n-> " + fiche.error_string);
			return;
		}
		_page++;
		loadPage();				
	});
}

/**
	Chargement de la page demandée
*/
function loadPage(){
	showLoading(true);
	$("#app_content").load("php/html.php?page=page_" + _page + "&forced=" + Math.random(), function(){
		showLoading(false);
		loadFields();
	});
	
	/**
		Active / Désactive le bouton Précédent
	*/
	if(_page == 0){
		$('#btnPrev').html('Quitter');
	}else{
		$('#btnPrev').html('Précédent');
	}

	/**
		Grise le bouton Suivant si on est à la dernière page
	*/
	if(_page == _max){
		$('#btnNext').html('Quitter');
	}else{
		$('#btnNext').html('Suivant');
	}
}

/**
	Validation de la fiche avant envoi au serveur
	_callback est la fonction JS a appelé suite à la validation.
*/
function validateFiche(_callback){
	saveFiche(_callback);
}

/**
	Enregistrement de la fiche sur le serveur
	_callback est la fonction JS a appelé suite à la validation.	
*/
function saveFiche(_callback){
	showLoading(true);
	$.ajax({
		url: "php/saveFiche.php",
		type: "POST",
		data: "json=" + JSON.stringify(fiche), 
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

/**
	Sortie de l'éditeur de fiche et retour à la liste des fiches
*/
function exitEditor(){
	window.open('index.html?cid=' + fiche.cycle_id + '&gid=' + fiche.group_id + '&uid=' + fiche.user_id, '_self');
	return;
}