define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function checkCat() {
		var cat = $('#oldCat').val();

		if (cat == "newCat") {
			$('input[name="newCat"]').removeAttr("disabled");
			$('input[name="newCat"]').removeAttr("readonly");
			$('input[name="newCat"]').focus();
		} else {
			$('input[name="newCat"]').attr("disabled", "disabled");
		}
	}

	function validateForm() {
		var title = $('input[name="question"]').val();
		var oldCat = $('#oldCat').val();

		if (typeof tinyMCE != "undefined") {
			tinyMCE.triggerSave();
		}
		var text = $('textarea[name="answer"]').val();

		var result = true;
		var focus = false;
		var msg = "";

		if (title == "") {
			result = false;
			msg = msg + elgg.echo("faq:add:check:question") + "\n";
			$('input[name="question"]').focus();
			focus = true;
		}
		if (oldCat == "") {
			result = false;
			msg = msg + elgg.echo("faq:add:check:category") + "\n";
		}
		if (oldCat == "newCat") {
			var newCat = $('input[name="newCat"]').val();
			if (newCat == "") {
				result = false;
				msg = msg + elgg.echo("faq:add:check:category") + "\n";
				if (!focus) {
					$('input[name="newCat"]').focus();
					focus = true;
				}
			}
		}
		if (text == "") {
			result = false;
			msg = msg + elgg.echo("faq:add:check:answer") + "\n";
			if (!focus) {
				$('textarea[name="answer"]').focus();
				focus = true;
			}
		}

		if (!result) {
			alert(msg);
		}

		return result;
	}

	$(document).ready(function() {
		$('#questionForm').submit(function() {
			return validateForm();
		});
	});

	$(document).on('change', '#oldCat', function() {
		checkCat();
	});
});
