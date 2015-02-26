_float_win = false;
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", $("#app_table").position().top + (($("#app_table").height() - $(this).height()) / 2) + "px");
    this.css("left",$("#app_table").position().left + (($("#app_table").width() - $(this).width()) / 2) + "px");
    return this;
}

/**
	Objet JSON de la liste des fiches de mise en pratique
*/
var list = {
	"error" : false,
	"error_string" : ""
}

_selected = -1;
cid = '';
gid = '';
uid = '';

/**
	Démarrage
*/
$(document).ready(function(){

	/**
		On récupère les variables GET et on charge la list
		L'éditeur de fiche doit être être appelé depuis un lien de type :
		
		http://lien_exploreur_fiches?cid=[ID du cycle en cours]&gid=[ID Groupe]&uid=[ID enseignant]
	*/
	var qs = new Querystring();
	showLoading(true);
	
	cid = qs.get('cid');
	gid = qs.get('gid');
	uid = qs.get('uid')

	$.ajax({
		url : "php/explorer.php",
		type: "POST",
		data:"cid=" + qs.get('cid') + "&gid=" + qs.get('gid') + "&uid=" + qs.get('uid'),
		dataType: "json",
		success: loadList__response
	});
});

/**
	Récupère l'objet JSON retourné par le serveur
*/
function loadList__response(_response){
	showLoading(false);
	list = _response;
	if(list.error == true){
		alert("Une erreur est survenue lors du chargement de la fiche.\n-> " + list.error_string);
		return;
	}
	
	showIcons();
}

/**
	Affiche les icones
*/
function showIcons(){
	_html = '<table style="width:100%">';
	
	n = 0;
	for(_i = 0; _i < list.fiches.length;_i++){
		if(n == 0){
			_html += '<tr>';
		}
		
		_html += '<td class="fiche_item" onclick="javascript:selectItem(' + _i + ');"><img id="img_' + _i + '" src="images/fiche_off.png" border="0" alt="' + list.fiches[_i].nom + '" title="' + list.fiches[_i].nom + '" /><br>' + list.fiches[_i].nom + '</td>';
		n++;
		if(n == 8){
			_html += "</tr>";
			n = 0;
		}
	}
	
	if(n > 0){
		for (_i = n; _i < 8; _i++){
			_html += '<td class="fiche_item">&nbsp;</td>';
		}
		_html += "</tr>";		
	}
	
	_html += '</table>';
	$('#app_content').html(_html);
}

/**
	Sélection d'une fiche
*/
function selectItem(_index){

	if(_index == _selected){
		editFiche();
		return;
	}

	if(_selected != -1){
		$('#img_' + _selected).attr('src', 'images/fiche_off.png');
	}
	
	_selected = _index;
	$('#img_' + _selected).attr('src', 'images/fiche_on.png');
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
	Création d'une nouvelle fiche
*/
function newFiche(){
	loadFloatWin('new_fiche');
}

/**
	Lance l'éditeur de fiche
*/
function editFiche(){
	if(_selected == -1){
		alert("Sélectionnez une fiche pour pouvoir la modifier.");
		return;
	}
	window.open('editor.html?fid=' + list.fiches[_selected].id + '&cid=' + cid + '&gid=' + gid + '&uid=' + uid, '_self');
}


function loadFloatWin(_page){
	if(_float_win){
		return;
	}
	
	$("#float_win").load("php/html.php?page=" + _page + "&forced=" + Math.random(),function(){
		_float_win = true;
		$("#black_mask").css("display", "block");
		initFloatWin();
		$("#float_win").center();
		$("#float_win").css("top", $(window).scrollTop() + "px");
		$("#float_win").css("display", "block");
	});
}

function closeFloatWin(_page){
	if(!_float_win){
		return;
	}
	
	_float_win = false;
	$("#black_mask").css("display", "none");
	$("#float_win").css("display", "none");
	$("#float_win").html("");
}

/**
	Création d'un nouvelle fiche
*/
function createFiche(){
	nom = $("input:text[name='nom']").val();
	if(nom == ''){
		alert('Veuillez saisir le nom de votre nouvelle fiche.');
		return;
	}

	showLoading(true);
	
	$.ajax({
		url : "php/createFiche.php",
		type: "POST",
		data:"cid=" + cid + "&gid=" + gid + "&uid=" + uid + "&nom=" + nom,
		dataType: "json",
		success: createFiche__response
	});
}

/**
	Récupère l'objet JSON retourné par le serveur
*/
function createFiche__response(_response){
	showLoading(false);
	if(_response.error == true){
		alert("Une erreur est survenue lors de la création de la fiche.\n-> " + _response.error_string);
		return;
	}
	
	window.open('editor.html?fid=' + _response.fiche_id + '&cid=' + cid + '&gid=' + gid + '&uid=' + uid, '_self');
}

/**
	Suppression d'un fiche
*/
function removeFiche(){
	if(_selected == -1){
		alert("Sélectionnez une fiche pour pouvoir la supprimer.");
		return;
	}
	
	r = confirm("Cette fiche sera supprim\351e. Continuer ?");
	if(!r){
		return;
	}
	showLoading(true);
	
	$.ajax({
		url : "php/removeFiche.php",
		type: "POST",
		data:"fid=" + list.fiches[_selected].id,
		dataType: "json",
		success: removeFiche__response
	});
}

/**
	Récupère l'objet JSON retourné par le serveur
*/
function removeFiche__response(_response){
	showLoading(false);
	if(_response.error == true){
		alert("Une erreur est survenue lors de la suppression de la fiche.\n-> " + _response.error_string);
		return;
	}
	
	window.open('index.html?cid=' + cid + '&gid=' + gid + '&uid=' + uid, '_self');
}

/**
	Format du téléchargement
*/
function downloadFiche(){
	loadFloatWin('fiche_format');
}

/**
	Téléchargement de la fiche
*/
function downloadFicheFormat(_format){
	closeFloatWin();
	window.open('../php/fmap/generateFiche.php?fid=' + list.fiches[_selected].id + '&cid=' + cid + '&gid=' + gid + '&uid=' + uid + '&format=' + _format, '_self');
}