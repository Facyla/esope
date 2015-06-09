/**
	Envoi d'une requête HTTP en passant des variables en mode POST
	_url : adresse de la requête
	_params : Tableau de String (chaine) contenant les ID des champs HTML de formulaire ou un parametre de type "nom=valeur"
	          ex. : new Array('fld_nom', 'fld_prenom', 'sex=m'); 'fld_nom' et 'fld_prenom' sont des champs HTML et 'sex' est un paramètre perso accompagné de sa valeur
	_success_handler : Fonction a appeler apès l'exécution de la requête et qui recevra la réponse du serveur.
*/
function _postValues(_url, _params, _success_handler){
	_data = "";
	
	/**
		Si le visiteur est connecté, on ajoute son ID à la requête HTTP
	*/
	if(typeof cnx_id != 'undefined'){
		if(cnx_id != null && cnx_id != ''){
			_data = "cnx_id=" + cnx_id
		}
	}
	
	/**
		On passe nos paramètres à la requête HTTP
	*/
	for(_i = 0; _i < _params.length; _i++){
		if(DOMExists(_params[_i])){
			_v = getValue(_params[_i]);
			if(_data == ""){
				_data = _data + _params[_i] + "=" + _v;
			}else{
				_data = _data + "&"  +_params[_i] + "=" + _v;
			}
		}else{
			if(_data == ""){
				_data = _data + _params[_i];
			}else{
				_data = _data + "&"  +_params[_i];
			}
		}
	}

	/**
		On exécute la requète HTTP
	*/
	$.ajax({
		type:'POST',
		url: _url,
		data: _data,
		success: _success_handler
	});
}