<?php
?>
//<script>
elgg.provide("elgg.profile_manager");

var profile_manager_register_form_timers = new Array();
var profile_manager_register_form_validate_xhr = new Array();

elgg.profile_manager.init = function(){
	// more info tooltips
	$("span.custom_fields_more_info").live('mouseover', function(e) {
			var tooltip = $("#text_" + $(this).attr('id'));
			$("body").append("<p id='custom_fields_more_info_tooltip'>"+ $(tooltip).html() + "</p>");
		
			if (e.pageX < 900) {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX + 10) + "px")
					.fadeIn("medium");
			}
			else {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX - 260) + "px")
					.fadeIn("medium");
			}
		}).live('mouseout', function() {
			$("#custom_fields_more_info_tooltip").remove();
		}
	);

	// tab switcher on edit form
	$("#profile_manager_profile_edit_tabs a").click(function(event) {
		var id = $(this).attr("href").replace("#", "");
		$("#profile_manager_profile_edit_tabs li").removeClass("elgg-state-selected");
		$(this).parent().addClass("elgg-state-selected");
	
		$('#profile_manager_profile_edit_tab_content_wrapper>div').hide();
		$('#profile_manager_profile_edit_tab_content_' + id).show();

		// do not jump to the anchor
		event.preventDefault();
	});
	
	var hash = window.location.hash;
	if(hash && hash !== "#" && $("#profile_manager_profile_edit_tabs " + hash).length > 0){
		var $tab = $("#profile_manager_profile_edit_tabs " + hash + " a:visible");
		if($tab.length > 0){
			$tab.click();
		} else {
			$("#profile_manager_profile_edit_tabs a:first:visible").click();
		}
	} else {
		$("#profile_manager_profile_edit_tabs a:first:visible").click();
	}

	// registration form adjustments
	
	// validate on submit
	$(".elgg-form-register").live("submit", function() {
		var error_count = 0;
		var result = false;

		var $form = $(this);
		var selProfileType =  $("#custom_profile_fields_custom_profile_type").val();
		if(selProfileType == ""){
			selProfileType = 0;
		}
		
		$form.find(".mandatory").find("input, select, textarea").each(function(index, elem) {
			
			switch($(elem).attr("type")){
				case "radio":
				case "checkbox":
					$(elem).parent(".mandatory").removeClass("profile_manager_register_missing");

					// check parents
					var $parents = $(elem).parents(".profile_manager_register_category");
					if(($parents.length == 0) || ($parents.hasClass("category_" + selProfileType) || $parents.hasClass("category_0"))){
						if($form.find("input[name='" + $(elem).attr("name") + "']:checked").length == 0){
							
							$(elem).parent(".mandatory").addClass("profile_manager_register_missing");
							error_count++;
						}
					}
					break;
				default:
					$(elem).removeClass("profile_manager_register_missing");
					// also remove class from multiselect element
					$(elem).next(".ui-multiselect").removeClass("profile_manager_register_missing");

					// check parents
					var $parents = $(elem).parents(".profile_manager_register_category");
					if(($parents.length == 0) || ($parents.hasClass("profile_type_" + selProfileType) || $parents.hasClass("profile_type_0"))){
					
						if($(elem).is("select")){
							if(($(elem).val() == null) || ($(elem).val() == "")){
								$(elem).addClass("profile_manager_register_missing");
								// also add class to multiselect element
								$(elem).next(".ui-multiselect").addClass("profile_manager_register_missing");
								
								error_count++;
							}
						} else {
							
							if($(elem).val().trim() == ""){
								$(elem).addClass("profile_manager_register_missing");
								error_count++;
							}
						}
					}
					break;
			}
		});
	
		if(error_count > 0){
			alert(elgg.echo("profile_manager:register:mandatory"));
		} else {
			result = true;
		}
	
		return result;
	});
	
	// add username generation when a email adress has been entered
	$(".elgg-form-register input[name='email']").live("blur", function(){
		var email_value = $(this).val();
		if(email_value.indexOf("@") !== -1){
			var pre = email_value.split("@");
			if(pre[0]){
				if($(".elgg-form-register input[name='username']").val() == ""){
					// change value and trigger change
					var new_val = pre[0].replace(/[^a-zA-Z0-9]/g, "");
					$(".elgg-form-register input[name='username']").val(new_val).keyup();
				}
			}
		}
	});

	// add live validation of username and emailaddress
	$(".elgg-form-register input[name='username'], .elgg-form-register input[name='email'], .elgg-form-register input[name='password']").live("keyup", function(event){
		var fieldname = $(event.currentTarget).attr("name");
		var form = $(this).parents(".elgg-form-register");
		clearTimeout(profile_manager_register_form_timers[fieldname]);
		profile_manager_register_form_timers[fieldname] = setTimeout(function(){
			elgg.profile_manager.register_form_validate(form, $(event.currentTarget));
		}, 500);
	});

	// password compare check
	$(".elgg-form-register input[name='password'], .elgg-form-register input[name='password2']").live("keyup", function(event){
		var form = $(this).parents(".elgg-form-register");
		
		var password1 = form.find("input[name='password']").val();
		var password2 = form.find("input[name='password2']").val();
		
		$field = form.find("input[name='password2']");
		$field_icon = $field.next(".profile_manager_validate_icon");
		$field_icon.attr("class", "elgg-icon profile_manager_validate_icon").attr("title", "");
		if((password1 !== "") && (password2 !== "")){
			if(password1 == password2){
				$field_icon.addClass("profile_manager_validate_icon_valid");
				$field.removeClass("profile_manager_register_missing");
			} else {
				$field_icon.addClass("profile_manager_validate_icon_invalid").attr("title", elgg.echo("RegistrationException:PasswordMismatch"));
			}
		}
	});

	// username change
	$("#profile_manager_username .elgg-input-text").live("keyup", function(event) {
		elgg.profile_manager.profile_manager_username(event, $(this));
	});

	// profile details accordion
	$("#custom_fields_userdetails.profile-manager-accordion").accordion({
		header: "h3",
		heightStyle: "content"
	});

	// rating initialisation
	$(".profile-manager-input-pm-rating .elgg-icon").live({
		mouseover: function() {
			$(this).parent().find(".elgg-icon-star-alt").addClass("pm-rating-selected elgg-icon-star-empty").removeClass("elgg-icon-star-alt");
			
			$(this).addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty").prevAll(".elgg-icon").addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty");
		},
		mouseout: function() {
			$(this).parent().find(".elgg-icon").removeClass("elgg-icon-star-alt elgg-icon-star-empty").addClass("elgg-icon-star-empty").filter(".pm-rating-selected").toggleClass("elgg-icon-star-empty elgg-icon-star-alt");
		},
		click: function() {
			$(this).parent().find(".elgg-icon").removeClass("pm-rating-selected");
			$(this).addClass("pm-rating-selected").prevAll(".elgg-icon").addClass("pm-rating-selected");
			var newVal = $(this).parent().find(".elgg-icon").index(this) + 1;
			$(this).parent().find("input").val(newVal);
		}
	});

	$(".profile-manager-input-pm-rating a").live("click", function(event) {
		$(this).parent().find(".elgg-icon").removeClass("pm-rating-selected elgg-icon-star-alt").addClass("elgg-icon-star-empty");
		$(this).parent().find("input").val("");
		event.preventDefault();
	});
}

elgg.profile_manager.profile_manager_username = function(event, elem) {
	if(event.which != 13){
		var username = $(elem).val();
		$container = $(elem).parent();
		$container.find(".elgg-icon").hide();
		
		if(username !== $(elem).attr("rel")){
			$container.find(".elgg-icon-profile-manager-loading").show();
			
			$.getJSON(elgg.get_site_url() + "profile_manager/validate_username", { "username": username }, function(data){
				if($("#profile_manager_username .elgg-input-text").val() == username){
					if(data.valid){
						$container.find(".elgg-icon-profile-manager-valid").show();
					} else {
						$container.find(".elgg-icon-profile-manager-invalid").show();
					}
					
					$("#profile_manager_username .elgg-icon-profile-manager-loading").hide();
				}
			});
		}
	}
}

// live input validation
elgg.profile_manager.register_form_validate = function(form, field){
	var fieldname = $(field).attr("name");
	var fieldvalue = $(field).val();
	if(profile_manager_register_form_validate_xhr[fieldname]){
		// cancel running ajax calls
		profile_manager_register_form_validate_xhr[fieldname].abort();
	}
	if(fieldvalue){
		var data = new Object();
		data.name=fieldname;
		data[fieldname] = fieldvalue;
	
		form.find("input[name='" + fieldname + "']").next(".profile_manager_validate_icon").attr("class", "elgg-icon profile_manager_validate_icon profile_manager_validate_icon_loading").attr("title", "");
		
		profile_manager_register_form_validate_xhr[fieldname] = elgg.action("profile_manager/register/validate", {
				data: data,
				success: function(data){
					// process results
					if(data.output){
						$field = form.find("input[name='" + data.output.name + "']");
						$field_icon = $field.next(".profile_manager_validate_icon");
						$field_icon.removeClass("profile_manager_validate_icon_loading");
						if(data.output.status == false){
							// something went wrong; show error icon and add title
							$field_icon.addClass("profile_manager_validate_icon_invalid");
						}
	
						if(data.output.status == true){
							// something went right; show success icon
							$field_icon.addClass("profile_manager_validate_icon_valid");
							$field.removeClass("profile_manager_register_missing");
						}
						if(data.output.text){
							$field_icon.attr("title", data.output.text);
						}
					}
					
				}
			});
	} else {
		form.find("input[name='" + fieldname + "']").next(".profile_manager_validate_icon").attr("class", "elgg-icon profile_manager_validate_icon").attr("title", "");
	}
}

// show description and fields based on selected profile type (profile edit)
elgg.profile_manager.change_profile_type = function(){
	var selVal = $('#custom_profile_type').val();
	
	$('.custom_fields_edit_profile_category').hide();
	$('.custom_profile_type_description').hide();

	if(selVal != ""){
		$('.custom_profile_type_' + selVal).show();
		$('#custom_profile_type_description_'+ selVal).show();
	}
	
	if($("#profile_manager_profile_edit_tabs li.elgg-state-selected:visible").length == 0){
		$('#profile_manager_profile_edit_tab_content_wrapper>div').hide();
		$("#profile_manager_profile_edit_tabs a:first:visible").click();
	}
}

//show description and fields based on selected profile type (register form)
elgg.profile_manager.change_profile_type_register = function(){
	var selVal = $('#custom_profile_fields_custom_profile_type').val();
	if(selVal == "" || selVal == "undefined"){
		selVal = 0;
	}

	// profile type description
	$('div.custom_profile_type_description').hide();
	$('#'+ selVal).show();

	// tabs
	var $tabs = $('#profile_manager_register_tabbed');
	if($tabs.length > 0){
		$tabs.find('li').hide();
		$tabs.find(".profile_type_0, .profile_type_" + selVal).show();
		if($tabs.find('li.selected:visible').length == 0){
			$tabs.find('li:visible:first>a').click();
		} else {
			$tabs.find('li.selected:visible').click();
		}
	} else {
		// list
		$(".profile_manager_register_category").hide();
		$(".profile_manager_register_category.profile_type_0, .profile_manager_register_category.profile_type_" + selVal).show();
	}
}

// tab switcher on register form
elgg.profile_manager.toggle_tabbed_nav = function(div_id, element){
	$content_container = $('#profile_manager_register_tabbed').next();
	$content_container.find('>div').hide();
	$content_container.find('>div.category_' + div_id).show();

	$('#profile_manager_register_tabbed li.elgg-state-selected').removeClass('elgg-state-selected');
	$(element).parent('li').addClass("elgg-state-selected");
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init);