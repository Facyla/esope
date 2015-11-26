/**

************************************************************************
	                         
							Utilitaires javascript

************************************************************************

*/

/**
	Complète le prototype String de javascript
*/
String.prototype.trim = function(){return (this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, ""));}

String.prototype.startsWith = function(str) {return this.substring(0,str.length) == str;}

String.prototype.endsWith = function(str) {return (this.match(str+"$")==str);}

String.prototype.limits = function(limit) {
	str = htmlDecode(this);
	
	if(str.length < limit){
		return str.htmlEncode();
	}else{
		str = str.substring(0,limit - 3) + '...';
		return str.htmlEncode();
	}
}

/**
	Vérification du bon formattage de l'adresse email donnée
*/
function validateEmailFormat(email){
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');

	if(reg.test(email))
	{
		return(true);
	}
	else
	{
		return(false);
	}
}

/**
	Vérifie si il y a eu une balise 'error' dans le code xml et retourne le message associé. Sinon 'false'
	xml est le code XML à vérifier
*/
function checkError(xml){
	message = 'false';
	error = $(xml).find("error").get();
	
	if(error.length == 1){ // il y a une balise error ?
		message = getContentNode(error[0]); // On retourne le message associé
	}
	
	if(message == undefined){ // Pas de message associé
		message = 'false'; // Donc pas d'erreur
	}
	
	return message;
}

/**
	Récupère le contenu d'une noeud XML
*/
function getContentNode(node){
	if(document.all){
		return node.text;
	}else{
		return node.textContent;
	}
}

/**
	Récupère un attribut d'un noeud XML
*/
function getAttribute(node, name){
	if(node.attributes.length > 0){
		for (iu = 0; iu < node.attributes.length; iu++){
			if(node.attributes[iu].name == name){
				return node.attributes[iu].nodeValue;
			}
		}
	}
	return undefined;
}

/**
	Création d'un cookie
	name : Chaine contenant le nom du cookie
	value : Valeur du cookie (chaine, nombre...)
	days : Nombre de jour de validité du cookie
*/
function createCookie(name, value, days) { 
	var expires; 
	if (days) { 
		var date = new Date(); 
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); 
		expires = "; expires=" + date.toGMTString(); 
	} 
	else expires = ""; 
	document.cookie = name + "=" + value + expires + "; path=/"; 
} 

/**
	Retourne la valeur d'un cookie
	name : Chaine contenant le nom du cookie
*/
function readCookie(name) { 
	var nameEQ = name + "="; 
	var ca = document.cookie.split(';'); 
	for (var i = 0; i < ca.length; i++) { 
		var c = ca[i]; 
		while (c.charAt(0) == ' ') c = c.substring(1, c.length); 
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length); 
	} 
	return null; 
} 

/**
	Suppression d'un cookie
	name : Chaine contenant le nom du cookie
*/
function eraseCookie(name) { 
	createCookie(name, "", -1); 
} 

/**
	Retourne true si les cookie sont activés, sinon false
*/
function areCookiesEnabled() { 
	var r = false; 
	createCookie("testing", "Hello", 1); 
	if (readCookie("testing") != null) { 
		r = true; 
		eraseCookie("testing"); 
	} 
	return r; 
}

/**
	Récupère la valeur d'un champ HTML par son ID
	id est une chaine Strinbg contenant l'id du champ HTML
*/
function getValue(id){
	if(DOMExists(id)){
		return document.getElementById(id).value;
	}else{
		return '';
	}
}

/**
	Définit la valeur d'un champ HTML par son ID
	id est une chaine String contenant l'id du champ HTML
	value est la valeur à définir
*/
function setValue(id, value){
//	alert(id);
	if(DOMExists(id)){
		var _parsed = $('<div>').html(value).text();
		document.getElementById(id).value = _parsed;
	}
}

/**
	Retourne 'yes' si la case à cocher demandée est cochée, sinon 'no'
	_id est une chaine String de l'id de la case à cochée
*/
function isChecked(_id){
	if(document.getElementById(_id).checked){
		return 'yes';
	}else{
		return 'no';
	};
}

/**
	Coche/décoche une case à cocher
	_id est une chaine String de l'id de la case à cochée
	_value est true ou false
*/
function setChecked(_id, _value){
	document.getElementById(_id).checked = _value;
}

/**
	Récupère le contenu HTML d'un élément DOM
	id est une chaine String contenant l'id de l'élément DOM
*/
function getHTML(id){
	return document.getElementById(id).innerHTML;
}

/**
	Définit le contenu HTML d'un élément DOM
	id est une chaine String contenant l'id de l'élément DOM
	value est le code HTML à définir
*/
function setHTML(id, value){
	if(DOMExists(id)){
		document.getElementById(id).innerHTML = value;
	}
}

/**
	Retourne true si un element DOM existe, sinon false
	id est une chaine String contenant l'id de l'élément DOM
*/
function DOMExists(_id){
	var e = document.getElementById(_id);
	if(typeof e == 'undefined' || e == null){
		return false;
	}else{
		return true;
	}
}

/**
	Centre un élément DOM par rapport à un autre
	source_id est l'id de l'élément DOM à center
	container_id est l'id de l'élément DOM dans lequel sera centré le source_id

*/
function centerAt(source_id, container_id){
	ws = document.getElementById(source_id).offsetWidth;
	hs = document.getElementById(source_id).offsetHeight;
	if(container_id == 'screen'){
		wc = window.screen.availWidth;
		hc = window.screen.availHeight;
	}else{
		wc = document.getElementById(container_id).offsetWidth;
		hc = document.getElementById(container_id).offsetHeight;
	}
	ls = (wc-ws)/2;
	ts = (hc-hs)/2;
	
	document.getElementById(source_id).style.left = '' + ls + 'px';
	document.getElementById(source_id).style.top = '' + ts + 'px';
}

/**
	Retourne true si une valeur existe dans un table, sinon false
	_value est la avelur recherchée
	_array est le tableau dans lequel rechercher
*/
function in_array(_value, _array){
	for(ii = 0; ii < _array.length; ii++){
		if(_value == _array[ii]){
			return true;
		}
	}
	return false;
}

/**
	retourne la version de IE
*/
function msieversion(){
	var ua = window.navigator.userAgent
	var msie = ua.indexOf ( "MSIE " )

	if ( msie > 0){
		return parseInt (ua.substring (msie+5, ua.indexOf (".", msie )))
	}else{
		return 0;
	}

}

/**
	Retourne true si la version de IE est inférieure à 9
*/
function IE8(){
	return msieversion() < 9 && msieversion() > 0;
}

/**
	Retourne une chaine String de type HH:MM:SS depuis une valeur en secondes
	time_ms est une valeur en secondes
*/
function get_HH_MM_SS(time_ms){
	var seconds=Math.floor(time_ms);
	var minutes=Math.floor(seconds/60);
	var hours=Math.floor(minutes/60);

	minutes=minutes-(hours*60);
	seconds=seconds-((minutes*60) + (hours * 3600));

	strhours=hours.toString()
	strminutes=minutes.toString()
	strseconds=seconds.toString()

	if (strseconds.length==1)
		strseconds="0"+strseconds
		
	if (strminutes.length==1)
		strminutes="0"+strminutes
		
	if (strhours.length==1)
		strhours="0"+strhours

	return(strhours+":"+strminutes+":"+strseconds) 
}
