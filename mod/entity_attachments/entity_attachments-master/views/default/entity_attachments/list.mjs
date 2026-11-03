import 'jquery';
import 'jquery-ui';
import Ajax from 'elgg/Ajax';

function initSorting() {
	$('.entity-attachments').sortable({
		containment: 'parent',
		axis: 'y',
		forceHelperSize: true,
		forcePlaceholderSize: true,
		update: function() {
			var ajax = new Ajax();
			
			var order = $('.entity-attachments').sortable('serialize', {key: 'order[]'});

			ajax.action('entity_attachments/sort?' + order);
		},
	});
};

$(document).on('change', '.elgg-form-entity-attachments-add .elgg-input-radio[name="type"]', function() {
	$('.entity-attachments-type').hide().find('[required]').prop('disabled', true);
	
	$('.entity-attachments-type-' + $(this).val()).show().find('[required]').prop('disabled', false);
	
	$(window).trigger('resize.lightbox');
});

$(document).on('submit', '.elgg-form-entity-attachments-add', function(event) {
	event.preventDefault();

	var guid = $(this).find('input[name="guid"]').val();
	
	var ajax = new Ajax();
	ajax.action('entity_attachments/add', {
		data: ajax.objectify(this),
	}).done(function(output) {
		$('.elgg-listing-full[data-guid="' + guid + '"] .elgg-module-entity_attachments > .elgg-body').html(output);
		$('.elgg-listing-full[data-guid="' + guid + '"] .elgg-module-entity_attachments').removeClass('hidden');
		initSorting();
		
		$.colorbox.close();
	});
});

initSorting();
