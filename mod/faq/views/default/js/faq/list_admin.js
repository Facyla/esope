define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function showEditOptions() {
		$('#beginEdit').hide();

		$('#editOptions').show();
		$('div[id^="faqSelect"]').each(function() {
			$('#' + this.id).show();
		});
	}

	function hideEditOptions() {
		$('#editOptions').hide();
		$('div[id^="faqSelect"]').each(function() {
			$('#' + this.id).hide();
		});

		$('#beginEdit').show();
	}

	function selectAll() {
		$('div[id^="faqSelect"] input[type="checkbox"]').each(function() {
			$('input[id="' + this.id + '"]').attr("checked", true);
		});
	}

	function selectNone(){
		$('div[id^="faqSelect"] input[type="checkbox"]').each(function() {
			$('input[id="' + this.id + '"]').attr("checked", false);
		});
	}

	function changeCategory() {
		var selVal = $('#newCategory').val();

		if(selVal != "") {
			var i = 0;
			var postData = "";

			$('div[id^="faqSelect"] input[type="checkbox"]:checked').each(function() {
				postData = postData + "<input type='hidden' value='" + this.value + "' name='faqGuid[" + i + "]' />";
				i++;
			});

			if(i > 0) {
				if(selVal == "new") {
					var retVal = prompt(elgg.echo("faq:list:edit:new_category"), "");
					if (retVal != "" && retVal != null) {
						selVal = retVal;
					} else {
						$('#newCategory').val('');
						return null;
					}
				}

				postData = postData + "<input type='hidden' value='" + selVal + "' name='category' />";

				if (confirm(elgg.echo("faq:list:edit:confirm:question") + i + elgg.echo("faq:list:edit:confirm:category") + selVal)) {
					$('#changeCategoryForm').append(postData);
					$('#changeCategoryForm').submit();
				} else {
					$('#newCategory').val('');
				}
			} else {
				alert(elgg.echo("faq:list:edit:category:please"));
				$('#newCategory').val('');
			}
		}
	}

	$(document).on('click', 'input[name="beginEdit"]', function() {
		showEditOptions();
	});

	$(document).on('click', 'input[name="all"]', function() {
		selectAll();
	});

	$(document).on('click', 'input[name="none"]', function() {
		selectNone();
	});

	$(document).on('click', 'input[name="cancel"]', function() {
		hideEditOptions();
	});

	$(document).on('change', '#newCategory', function() {
		changeCategory();
	});
});
