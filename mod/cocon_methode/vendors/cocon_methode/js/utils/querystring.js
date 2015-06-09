/**
	Prototype Javascript permettant de lire les variables GET
	passées dans l'url.
*/

function Querystring(qs) { 
	this.params = {};
	
	if (qs == null) qs = location.search.substring(1, location.search.length);
	if (qs.length == 0) return;

	qs = qs.replace(/\+/g, ' ');
	var args = qs.split('&'); 
	
	for (var i = 0; i < args.length; i++) {
		var pair = args[i].split('=');
		var name = decodeURIComponent(pair[0]);
		
		var value = (pair.length==2)
			? decodeURIComponent(pair[1])
			: name;
		
		this.params[name] = value;
	}
}

/**
	Récupère la valeur d'une variable
*/
Querystring.prototype.get = function(key, default_) {
	var value = this.params[key];
	return (value != null) ? value : default_;
}

/**
	Retourne true si une varaible existe dans l'url, sinon false.
*/
Querystring.prototype.contains = function(key) {
	var value = this.params[key];
	return (value != null);
}
