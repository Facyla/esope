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
	//$(menu+" ul").hide();
	var timeout;
	
	$(menu + " li a").click(function() {
		if($(this).next().children("li").size() > 0) {
			if($(this).next().is(":hidden")) {
				$(this).next().slideToggle('slow');
			} else {
				$(this).next().hide();
			}
			//return false; // False si on veut que le clic ne déclenche pas le lien
			return true;
		} else {
			return true;
		}
	});
	
	
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
	
	
}

$("#iris-navigation .elgg-menu-navigation ul").hide(); // Plus rapide pour masquer les sous-menus

/**
 * Navigation menu toggle for small screens.
 */
$(document).ready(function() {
	var button = $('.menu-navigation-toggle');
	if (!button) return;
	// Hide button if menu is missing or empty.
	var menu = $('#iris-navigation');
	if (!menu) { button.hide(); return; }
	button.on('click', function() {
		menu.toggleClass('menu-enabled');
		//menu.toggle();
		//button.toggleClass('hidden');
	});
});

/**
 * Sidebar menu toggle for small screens.
 */
$(document).ready(function() {
	var button = $('.menu-sidebar-toggle');
	if (!button) return;
	// Hide button if menu is missing or empty.
	var menu = $('.elgg-sidebar');
	var menu2 = $('.sidebar-alt');
	if (!menu) { button.hide(); return; }
	button.on('click', function() {
		menu.toggleClass('menu-enabled');
		menu2.toggleClass('menu-enabled');
		button.toggleClass('hidden');
	});
	//$('.menu-sidebar-toggle').on('click', function() { menu.toggleClass('hidden'); }); // Easier
});


/* Topbar tab switcher (Iris v2) */
$(document).ready(function() {
	$('#notifications .notifications-panel .tabs a').on('click', function(){
		// Select tab
		$('#notifications .notifications-panel .tabs a').removeClass('elgg-state-selected');
		$(this).addClass('elgg-state-selected');
		// Display block
		$('.iris-topbar-notifications-tab').hide();
		var display_div = $(this).attr('href');
		$(display_div).show();
	});
});


/* Group workspace add content tab switcher (Iris v2) */
$(document).ready(function() {
	$('#group-workspace-addcontent .group-workspace-add-tabs a').on('click', function(){
		// Select tab
		$('#group-workspace-addcontent .group-workspace-add-tabs a').removeClass('elgg-state-selected');
		$(this).addClass('elgg-state-selected');
		// Display block
		$('.group-workspace-addcontent-tab').hide();
		var display_div = $(this).attr('href');
		$(display_div).show();
		return false;
	});
});


/* Iris members search : sync external input fields sync with main advanced search form
 * Intercepts topbar search form and replace it with main advanced form, if exists
 * topbar search term
 * results order and sort
 * limit
 */
$(document).ready(function() {
	// Replace topbar form by main search form
	$("#iris-topbar-search").on("submit", function(e){
		// If advanced search exists, block form and use advanced form instead
		if ($("#esope-search-form").length) {
			e.preventDefault();  //prevent form from submitting
			$('#esope-search-form').submit();
		}
	});
	// Replace header form by main search form
	$("#iris-search-quickform").on("submit", function(e){
		// If advanced search exists, block form and use advanced form instead
		if ($("#esope-search-form").length) {
			e.preventDefault();  //prevent form from submitting
			$('#esope-search-form').submit();
		}
		if ($("#advanced-search-form").length) {
			e.preventDefault();  //prevent form from submitting
			$('#advanced-search-form').submit();
		}
	});
	
	
	/* Sync search fields */
	
	// Topbar search input
	$('#iris-topbar-search input[name="q"]').on('change paste keyup', function(e) {
		$('.iris-search-fulltext input[name="q"]').val($(this).val());
		$('#advanced-search-form input[name="q"]').val($(this).val());
	});
	// Iris search header input
	$('#iris-search-header-input').on('change paste keyup', function() {
		$('.iris-search-fulltext input[name="q"]').val($(this).val());
		$('#advanced-search-form input[name="q"]').val($(this).val());
	});
	
	// Objects order sync and submit form
	$('.iris-search-sort select[name="iris_objects_search_order"]').on('change', function(e) {
		if ($("#advanced-search-form").length) {
			$('#advanced-search-form input[name="sort"]').val(this.value);
			e.preventDefault();  //prevent form from submitting
			$('#advanced-search-form').submit();
		}
	});
	// Members order sync and submit form
	$('.iris-search-sort select[name="iris_members_search_order"]').on('change', function(e) {
		if ($("#esope-search-form").length) {
			$('#esope-search-form input[name="order_by"]').val(this.value);
			e.preventDefault();  //prevent form from submitting
			$('#esope-search-form').submit();
		}
	});
	// Groups order sync and submit form
	$('.iris-search-sort select[name="iris_groups_search_order"]').on('change', function(e) {
		if ($("#esope-search-form").length) {
			$('#esope-search-form input[name="order_by"]').val(this.value);
			e.preventDefault();  //prevent form from submitting
			$('#esope-search-form').submit();
		}
	});
	/*
	// Limit ?
	$('.iris-search-sort select[name="iris_members_search_limit"]').on('change', function(e) {
		if ($("#esope-search-form").length) {
			$('#esope-search-form #limit').val(this.value);
			e.preventDefault();  //prevent form from submitting
			$('#esope-search-form').submit();
		}
	});
	*/
	
	// New jQuery selector - cf. eg. http://webtopian.com/find-element-with-jquery-containing-case-insensitive-text
	// Usage : use instead of :contains to select case-insensitive
	$.expr[':'].icontains = $.expr.createPseudo(function(text) {
		return function(e) {
			return $(e).text().toUpperCase().indexOf(text.toUpperCase()) >= 0;
		};
	});
	
	// Live members filter
	$('#group-members-filter').on('change paste keyup', function(e) {
		var filter = $(this).val(); // get the value of the input, which we filter on
		$('#group-members-live .group-member').find("p:not(:icontains(" + filter + "))").parent().slideUp();
		$('#group-members-live .group-member').find("p:icontains(" + filter + ")").parent().slideDown();
	});
	
});



/* Use Taggle input for main search input
 * @TODO use something else, jquery plugin...
 */
//$(document).ready(function() {
/*
require(['taggle.js'], function($) {
	new Taggle('iris-search-header-input');
});
*/


