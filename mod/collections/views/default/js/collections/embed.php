<?php ?>
//<script>

elgg.provide("elgg.collections.embed");

elgg.collections.embed.init = function() {
	
	elgg.register_hook_handler('embed', 'editor', elgg.collections.embed.hook);
	
	$("#collections-embed-list li").live("click", function(event) {
		elgg.collections.embed.embed_format(this);

		event.preventDefault();
	});

	$("#collections-embed-pagination a").live("click", function(event) {
		var url = $(this).attr("href");
		$("#collections-embed-pagination").parent().parent().load(url);
		event.preventDefault();
	});

	$("#collections-embed-search").live("submit", function(event) {

		event.preventDefault();

		var query = $(this).serialize();
		var url = $(this).attr("action");
			
		$(this).parent().parent().load(url, query, function() {
			$.colorbox.resize();
		});
	});

	$("#collections-embed-format-description, #collections-embed-format-icon").live("change", function() {
		elgg.collections.embed.embed_format_preview();
	});
}

elgg.collections.embed.embed_format = function(elem) {
	var data = $(elem).find("> div").data();
	if (!data) {
		return false;
	}
	
	$("#collections-embed-format-icon").parent().hide();
	if (data.iconUrl) {
		$("#collections-embed-format-icon").parent().show();
	}
		
	$("#collections-embed-wrapper, #collections-embed-format").toggleClass("hidden");
	
	$("#collections-embed-format-preview").data(data);

	elgg.collections.embed.embed_format_preview();
}

elgg.collections.embed.embed_format_preview = function() {
	var $preview = $("#collections-embed-format-preview");
	var data = $preview.data();
	var content = "";
	var content_description = "";
	var content_icon = "";

	var description_option = $("#collections-embed-format-description").val();
	var icon_option = $("#collections-embed-format-icon").val();
	
	
	if (description_option === "full") {
		content_description += data.description;
	} else if (description_option === "excerpt") {
		content_description += data.excerpt;
		content_description += "<p class='collections-embed-item-read-more'><a href='" + data.url + "'>" + elgg.echo("collections:embed:read_more") + " ></a></p>"; 
	}

	if (data.iconUrl) {
		if (icon_option === "left" || icon_option === "right") {
			content_icon += "<img src='" + data.iconUrl + "' />";
		}
	}
	
	content += "<table class='collections-embed-item'><tr>";

	if (content_icon) {
		if (icon_option === "left") {
			content += "<td class='collections-embed-item-icon'>" + content_icon + "</td>";
		}
	}

	content += "<td class='collections-embed-item-title'>";
	content += "<table><tr><td><h3><a href='" + data.url + "'>" + data.title + "</a></h3></td></tr><tr><td class='collections-embed-item-description'>" + content_description + "</td></tr></table>";
	content += "</td>";

	if (content_icon) {
		if (icon_option === "right") {
			content += "<td class='collections-embed-item-icon'>" + content_icon + "</td>"; 
		}
	}
	
	content += "</tr></table>";
	
	$preview.html(content);
	$.colorbox.resize();
}

elgg.collections.embed.embed_format_submit = function() {
	elgg.collections.embed.embed($("#collections-embed-format-preview").html());
}

elgg.collections.embed.embed = function(content) {
	var textAreaId = $(".elgg-form-collections-edit-content textarea").attr("id");
	var textArea = $("#" + textAreaId);
	
	textArea.val(textArea.val() + content);
	textArea.focus();

	<?php
		// See the TinyMCE plugin for an example of this view
		// @TODO
		echo elgg_view('embed/custom_insert_js');
	?>

	elgg.ui.lightbox.close();
}


/**
 * Replaces embed/custom_insert_js deprecated views
 *
 * @param {String} hook
 * @param {String} type
 * @param {Object} params
 * @param {String|Boolean} value
 * @returns {String|Boolean}
 * @private
 */
elgg.collections.embed.hook = function(hook, type, params, value) {
	var textAreaId = params.textAreaId;
	var content = params.content;
	var event = params.event;
};


//register init hook
elgg.register_hook_handler("init", "system", elgg.collections.embed.init);

