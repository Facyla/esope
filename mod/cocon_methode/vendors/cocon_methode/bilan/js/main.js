/**
	Objet JSON des données de la bilan bilan
*/
var bilan = {
	"error" : false,
	"error_string" : "",
	"bilan_id" : "",
	"cycle_id" : "",
	"group_id" : "",
	"active" : 1,
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
	"zone11" : "",
	"zone12" : "",
	"zone13" : ""
}

_page = 0;
_max = 3;

/**
	Démarrage
*/
$(document).ready(function(){

	/**
		On récupère les variables GET et on charge la fiche bilan
		L'éditeur de bilan doit être être appelé depuis un lien de type :
		
		http://lien_bilan?cid=[ID du cycle en cours]&gid=[ID Groupe]
	*/
	var qs = new Querystring();
	showLoading(true);
	$.ajax({
		url : "php/loadBilan.php",
		type: "POST",
		data:"cid=" + qs.get('cid') + "&gid=" + qs.get('gid'),
		dataType: "json",
		success: loadBilan__response
	});
});

/**
	Récupère l'objet JSON retourné par le serveur
*/
function loadBilan__response(_response){
	showLoading(false);
	bilan = _response;
	if(bilan.error == true){
		alert("Une erreur est survenue lors du chargement de la fiche bilan.\n-> " + bilan.error_string);
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
		validateBilan(function(_response){
			showLoading(false);
			bilan = _response;
			if(bilan.error == true){
				alert("Une erreur est survenue lors de l'enregistrement de la fiche bilan.\n-> " + bilan.error_string);
				return;
			}
		});		
		window.close();
	}
	
	/**
		Enregistrement de la page
	*/
	validateFields();
	validateBilan(function(_response){
		showLoading(false);
		bilan = _response;
		if(bilan.error == true){
			alert("Une erreur est survenue lors de l'enregistrement de la fiche bilan.\n-> " + bilan.error_string);
			return;
		}
		_page--;
		loadPage();
	});
}

/**
	Enregistrement de la bilan
*/
function enregistreBilan(){
	validateFields();
	validateBilan(function(_response){
		showLoading(false);	
		bilan = _response;
		if(bilan.error == true){
			alert("Une erreur est survenue lors de l'enregistrement de la fiche bilan.\n-> " + bilan.error_string);
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
		validateBilan(function(_response){
			showLoading(false);
			bilan = _response;
			if(bilan.error == true){
				alert("Une erreur est survenue lors de l'enregistrement de la fiche bilan.\n-> " + bilan.error_string);
				return;
			}
		});		
		window.close();
	}
	
	validateFields();
	validateBilan(function(_response){
		showLoading(false);
		bilan = _response;
		if(bilan.error == true){
			alert("Une erreur est survenue lors de l'enregistrement de la fiche bilan.\n-> " + bilan.error_string);
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
	Validation de la fiche bilan avant envoi au serveur
	_callback est la fonction JS a appelé suite à la validation.
*/
function validateBilan(_callback){
	saveBilan(_callback);
}

/**
	Enregistrement de la fiche bilan sur le serveur
	_callback est la fonction JS a appelé suite à la validation.	
*/
function saveBilan(_callback){
	showLoading(true);
	$.ajax({
		url: "php/saveBilan.php",
		type: "POST",
		data: "json=" + JSON.stringify(bilan), 
		dataType: "json",
		success: _callback
	});	
}

/**
	Afbilan/cache l'animation de chargement
*/
function showLoading(_show){
	if(_show){
		$('#app_loader').css('display', 'block');
	}else{
		$('#app_loader').css('display', 'none');
	}
}
