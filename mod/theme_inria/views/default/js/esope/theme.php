<?php
$urlicon = elgg_get_site_url() . 'mod/esope/img/theme/';
?>

$(document).ready(function() {
	menu("#iris-navigation .elgg-menu-navigation");
	//menu("header .elgg-menu-navigation"); // Pour le menu supérieur, si utilisé

	//recherche
	/*
	var valueSearch = $("form input#esope-search-input").attr("value");
	$("form input#esope-search-input").focus(function() {
		if (($(this).attr("value") != "") || ($(this).attr("value") == valueSearch)) {
		  $(this).attr("value", "");
		}
	});
	$("form input#esope-search-input").click(function() {
		if (($(this).attr("value") != "") || ($(this).attr("value") == valueSearch)) {
		  $(this).attr("value", "");
		}
	});
	$("form input#esope-search-input").blur(function() {
		if ($(this).attr("value") == "") { $(this).attr("value", valueSearch); }
	});
	*/
	
	//ouverture élément module
	$(".plus").hide();
	$("a.ouvrir").click(function() {
		if ($(this).hasClass("ouvert")) {
			$(this).removeClass("ouvert");
			$(this).find("img").attr("src", "<?php echo $urlicon; ?>ensavoirplus.png");
			$(this).next(".plus").slideUp();
		} else {
			$(this).addClass("ouvert");
			$(this).find("img").attr("src", "<?php echo $urlicon; ?>fermer.png");
			$(this).next(".plus").slideDown();
		}
		return false;
	});
	
	//ouverture éléments supplémentaire module
	$(".elgg-module .suivant").hide();
	$(".elgg-module footer a").click(function() {
		$(this).parents(".elgg-module").children(".suivant").slideDown();
		$(this).remove(); //s'il n'y en a plus à afficher
		return false;
	});
});

// Fonction de gestion des menus
// Note : la variable menu doit correspondre à l'élément ul de premier niveau
function menu(menu) {
	$(menu+" ul").hide();
	var timeout;
	$(menu + " li a").hover(function() {
		var myLink = $(this);
		timeout = setTimeout(function(){myLink.next().slideDown(200);}, 50);
	},  function() {
		clearTimeout(timeout);
		$(this).next().hide();
	});
	$(menu + ">li>a").focus(function() {
		$(this).parent().prev("li").find("ul").hide();
		$(this).parent().next("li").find("ul").hide();
		$(this).next().slideDown(300);
		if($(this).parent().next("li").children("a.lastfocus").length>0) {
			$(".lastfocus").parent().find("ul").hide();
			$(this).parent().children("ul").children("li").each(function() {
				if($(this).next("li").length==0) {
					$(this).children("a").focus();
					$(".lastfocus").removeClass("lastfocus");
				}
			});
		}
	});
	$(menu + ">li>a").blur(function() {
		//$(this).next().hide();
		$(this).addClass("lastfocus");
	});
	$(menu + " ul").hover(function() {
		$(this).show();
		$(this).prev().addClass("active");
	}, function() {
		$(this).hide();
		$(this).prev().removeClass("active");
	});

	$(menu + " li a").focus(function() {
		$(".lastfocus").removeClass("lastfocus");
	});
	
	$(menu + " li a").click(function() {
		if($(this).next().children("li").size() > 0) {
			if($(this).next().is(":hidden")) {
				$(this).next().slideDown(200);	
			} else {
				$(this).next().hide();
			}
			//return false; // False si on veut que le clic ne déclenche pas le lien
			return true;
		} else {
			return true;
		}
	});
}

$("#iris-navigation .elgg-menu-navigation ul").hide(); // Plus rapide pour masquer les sous-menus


/**
 * Topbar menu toggle for small screens.
 */
$(document).ready(function() {
	var button = $('.menu-topbar-toggle');
	if (!button) return;
	// Hide button if menu is missing or empty.
	var menu = $('.elgg-menu-topbar');
	if (!menu) { button.hide(); return; }
	$('.menu-topbar-toggle').on('click', function() { menu.toggleClass('menu-enabled'); });
	//$('.menu-topbar-toggle').on('click', function() { menu.toggleClass('hidden'); }); // Easier
});

/**
 * Navigation menu toggle for small screens.
 */
$(document).ready(function() {
	var button = $('.menu-navigation-toggle');
	if (!button) return;
	// Hide button if menu is missing or empty.
	var menu = $('.elgg-menu-navigation');
	if (!menu) { button.hide(); return; }
	$('.menu-navigation-toggle').on('click', function() { menu.toggleClass('menu-enabled'); });
	//$('.menu-navigation-toggle').on('click', function() { menu.toggleClass('hidden'); }); // Easier
});

/**
 * Sidebar menu toggle for small screens.
 */
$(document).ready(function() {
	var button = $('.menu-sidebar-toggle');
	if (!button) return;
	// Hide button if menu is missing or empty.
	var menu = $('.elgg-sidebar');
	if (!menu) { button.hide(); return; }
	$('.menu-sidebar-toggle').on('click', function() { menu.toggleClass('menu-enabled'); });
	//$('.menu-sidebar-toggle').on('click', function() { menu.toggleClass('hidden'); }); // Easier
});



