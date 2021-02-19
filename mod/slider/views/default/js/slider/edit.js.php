/**
 * @package ElggSlider
 */

define(['elgg', 'jquery'], function (elgg, $) {
	$(document).ready(function(){
		
		var moduleInit = function() {
			// Add slide
			$(document).on('click', '#slider-edit-add-slide', addSlide);
			
			// Remove slide
			$(document).on('click', '.slider-edit-delete-slide', deleteSlide);
			
			// Basic|full mode toggle
			//$('#slider-edit-mode-basic').on('click', {mode: "basic"}, editMode);
			$(document).on('click', '#slider-edit-mode-basic', {mode: "basic"}, editMode);
			//$('#slider-edit-mode-full').on('click', {mode: "full"}, editMode);
			$(document).on('click', '#slider-edit-mode-full', {mode: "full"}, editMode);
			
			// Add sortable feature
			addSortable();
		};


		/** Add a new empty slide to the form
		 * @param {Object} e The click event
		 */
		var addSlide = function(e) {
			// Create a new slide element (without editor)
			var new_slide = <?php echo json_encode(elgg_view('slider/input/slide', array($editor = 'plaintext'))); ?>;
			$('.slider-edit-slides').append(new_slide);
			// Refresh the sortable items to be able to sort into the new section
			addSortable();
			e.preventDefault();
		};

		/** Removes a slide
		 * @param {Object} e The click event
		 */
		var deleteSlide = function(e) {
			var slide = $(this).parent();
			if (confirm(elgg.echo('slider:edit:deleteslide:confirm'))) { slide.remove(); }
			e.preventDefault();
		}

		/* Sortable init function : make slides sortable
		 * @param {Object} e The click event
		 */
		var addSortable = function() {
			// initialisation de Sortable sur le container parent
			$(".slider-edit-slides").sortable({
				placeholder: 'slider-edit-highlight', // classe du placeholder ajouté lors du déplacement
				connectWith: '.slider-edit-slides', 
				// Custom callback function
				update: function(event, ui) {}
			});
		};
		
		// Toggle edit mode basic|advanced
		var editMode = function(e) {
			switchMode(e.data.mode);
			e.preventDefault();
		};
		// Toggle edit mode basic|advanced
		var switchMode = function(mode) {
			if (mode == 'basic') {
				$(".slider-mode-full").addClass('hidden');
				$(".slider-mode-basic").removeClass('hidden');
			} else if (mode == 'full') {
				$(".slider-mode-full").removeClass('hidden');
				$(".slider-mode-basic").addClass('hidden');
			}
			$("input[name=edit_mode]").val(mode);
		};
		
		// Init module
		elgg.register_hook_handler('init', 'system', moduleInit);
		
		// return a module (can be used as slider.switchMode)
		return {
			editMode: editMode,
			switchMode: switchMode,
			addSlide: addSlide
		};
		
	});
});

