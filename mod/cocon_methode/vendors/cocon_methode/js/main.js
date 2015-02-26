_topic = "temps_0";
_float_win = false;
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", $("#app_table").position().top + (($("#app_table").height() - $(this).height()) / 2) + "px");
    this.css("left",$("#app_table").position().left + (($("#app_table").width() - $(this).width()) / 2) + "px");
    return this;
}

$(document).ready(function(){
/* Intégration : pas cohérent avec design Cocon
	$(window).scroll(function(){
		updateMenusTop();
	});
*/
/* Intégration : doublon
	$('li.home').hover(function(){
		$('li.home ul.hidden').css('display', 'block');
	}, function(){
		$('li.home ul.hidden').css('display', 'none');
	});
			
	$('li.groups').hover(function(){
		$('li.groups ul.hidden').css('display', 'block');
	}, function(){
		$('li.groups ul.hidden').css('display', 'none');
	});

	$('li.thematiques').hover(function(){
		$('li.thematiques ul.hidden').css('display', 'block');
	}, function(){
		$('li.thematiques ul.hidden').css('display', 'none');
	});

	$('li.help').hover(function(){
		$('li.help ul.hidden').css('display', 'block');
	}, function(){
		$('li.help ul.hidden').css('display', 'none');
	});
*/
	
	loadConfig();
});

/*
function updateMenusTop(){
	$('#menus_panel').css('top', $(window).scrollTop() + 'px');
}
*/

function loadPage(_page, _menu){
	if(_topic == 'temps_4'){
		saveFeuilleDeRoute(0);
	}
	$("#" + _topic).removeClass("selected");
	$("#" + _menu).addClass("selected");
	$("#app_content").load("php/html.php?page=" + _page + "&forced=" + Math.random());
	_topic = _menu;
	$(window).scrollTop(0);
	updateMenusTop();
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

// Affiche l'annuaire CoCon
function showAnnuaire(){
	window.open(annuaire_url,'_new');
}
