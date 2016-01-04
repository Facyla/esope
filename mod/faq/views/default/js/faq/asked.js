define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function show(id) {
		$("div[id^='question']").each(function() {
			$('#' + this.id).show();
		});

		$("div[id^='formDiv']").each(function() {
			$('#' + this.id).hide();
		});

		$("#question" + id).hide();
		$("#formDiv" + id).show();
	}

	function cancelForm(id) {
		$("#question" + id).show();
		$("#formDiv" + id).hide();
	}

	function addQuestion(id) {
		var addVal = $("#answer" + id + " input[name='add']:checked").val();

		if(addVal == "yes") {
			$("#answer" + id + " #oldCat").removeAttr("disabled");
			$("#answer" + id + " #access").removeAttr("disabled");
			$("#answer" + id + " #oldCat").removeAttr("readonly");
			$("#answer" + id + " #access").removeAttr("readonly");
			checkCat(id);
		} else {
			$("#answer" + id + " #oldCat").attr("disabled", "disabled");
			$("#answer" + id + " #access").attr("disabled", "disabled");
			$("#answer" + id + " input[name='newCat']").attr("disabled", "disabled");
		}
	}

	function checkCat(id) {
		var cat = $("#answer" + id + " #oldCat").val();

		if(cat == "newCat") {
			$("#answer" + id + " input[name='newCat']").removeAttr("disabled");
			$("#answer" + id + " input[name='newCat']").removeAttr("readonly");
			$("#answer" + id + " input[name='newCat']").focus();
		} else {
			$("#answer" + id + " input[name='newCat']").attr("disabled", "disabled");
		}
	}

	function validateForm(faqguid) {
		var formID = '#answer' + faqguid;
		if (typeof tinyMCE != "undefined") {
			tinyMCE.triggerSave();
		}
		var title = $(formID + ' input[name="question"]').val();
		var addVal = $(formID + " input[name='add']:checked").val();
		var oldCat = $(formID + ' #oldCat').val();
		var text = $(formID + ' textarea[name="textanswer'+faqguid+'"]').val();

		var result = true;
		var focus = false;
		var msg = "";

		// Is there a question
		if(title == "") {
			result = false;
			msg = msg + elgg.echo("faq:add:check:question") + "\n";
			$(formID + ' input[name="question"]').focus();
			focus = true;
		}

		// Add to FAQ?
		if(addVal == undefined) {
			result = false;
			msg = msg + elgg.echo("faq:asked:check:add") + "\n";
		} else if (addVal == "yes") {
			// Yes!!
			// Check category
			if(oldCat == "") {
				result = false;
				msg = msg + elgg.echo("faq:add:check:category") + "\n";
			}
			// Check new category
			if(oldCat == "newCat") {
				var newCat = $(formID + ' input[name="newCat"]').val();
				if(newCat == "") {
					result = false;
					msg = msg + elgg.echo("faq:add:check:category") + "\n";
					if(!focus) {
						$(formID + ' input[name="newCat"]').focus();
						focus = true;
					}
				}
			}
		}

		// Check answer
		if(text == "") {
			result = false;
			msg = msg + elgg.echo("faq:add:check:answer") + "\n";
			if(!focus) {
				$(formID + ' textarea[name="textanswer'+faqguid+'"]').focus();
				focus = true;
			}
		}

		if(!result) {
			alert(msg);
		}

		return result;
	}

	$(document).on('submit', '.answerform', function() {
		var faqguid = $(this).data('faqguid');
		return validateForm(faqguid);
	});

	$(document).on('click', '.askedLink a', function() {
		var faqguid = $(this).data('faqguid');
		show(faqguid);
	});

	$(document).on('change', '#oldCat', function() {
		var faqguid = $(this).data('faqguid');
		checkCat(faqguid);
	});

	$(document).on('change', 'input[name=add]', function() {
		var faqguid = $(this).data('faqguid');
		addQuestion(faqguid);
	});

	$(document).on('click', 'input[name="cancel"]', function() {
		var faqguid = $(this).data('faqguid');
		cancelForm(faqguid);
	});
});
