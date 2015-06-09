elgg.provide('elgg.elgg_menus.edit');


/** Initialize the elgg_menus editing javascript */
elgg.elgg_menus.edit.init = function() {
	// Add menu item
	$(document).on('click', '#menu-editor-add-item', elgg.elgg_menus.edit.addMenuItem);
	
	// Remove menu item
	$(document).on('click', '.menu-editor-delete-item', elgg.elgg_menus.edit.deleteMenuItem);
	
	// Hide/show some menu_item edit form options
	$(document).on('click', '.menu-editor-toggle-details', elgg.elgg_menus.edit.showDetails);
	
	// Add menu section
	$(document).on('click', '#menu-editor-add-section', elgg.elgg_menus.edit.addMenuSection);
	
	
	elgg.elgg_menus.edit.addSortable();
	
};


/** Removes a menu item
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.deleteMenuItem = function(e) {
	var menu_item = $(this).parent();
	if (confirm(elgg.echo('elgg_menus:delete:confirm'))) { menu_item.remove(); }
	e.preventDefault();
}


/** Toggles an item settings input
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.showDetails = function(e) {
	$(this).parent().children('.menu-editor-item-content').toggle();
	// Updates the menu item title (so that we can see what we sort)
	var new_item_title = $(this).parent().find('input[name^="text"]')[0].value + " (" + $(this).parent().find('input[name^="name"]')[0].value + ") => " + $(this).parent().find('input[name^="href"]')[0].value;
	$(this).parent().children('.menu-editor-item-title').html(new_item_title);
	e.preventDefault();
}

/* Add a new empty menu item to the form
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.addMenuItem = function(e) {
	// Create a new menu_item element
	// MenuItem object meta : title, description, input_type, options, empty_value, required
	var new_item = <?php echo json_encode(elgg_view('elgg_menus/input/menu_item')); ?>;
	$('#menu-editor-newitems').append(new_item);
	// Refresh the sortable items to be able to sort into the new section
	elgg.elgg_menus.edit.addSortable();
	e.preventDefault();
};


/* Add a new empty menu section to the form
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.addMenuSection = function(e) {
	// Create a new section element
	<?php $new_section_prompt = str_replace("'", "\'", elgg_echo('elgg_menus:edit:newsection:prompt')); ?>
	var new_section=prompt(<?php echo json_encode($new_section_prompt); ?>);
	if (new_section) {
		$('#menu-editor-newsections').append('<fieldset class="elgg-menus-section" data-section="' + new_section + '"><legend>' + new_section + '</legend><div class="menu-editor-items"></div></fieldset>');
		// Refresh the sortable items to be able to sort into the new section
		elgg.elgg_menus.edit.addSortable();
	}
	e.preventDefault();
};



/* Sortable init function
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.addSortable = function() {
	// initialisation de Sortable sur le container parent
	$(".menu-editor-items").sortable({
		placeholder: 'menu-editor-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.menu-editor-items', 
		// Custom callback function
		update: function(event, ui) {
			// Get parent section name and set section to parent section name, or default
			var section = ui.item.find('input[name^="section"]')[0];
			var new_section = ui.item.parents('fieldset').attr('data-section');
			if (new_section) section.value=new_section;
			else section.value='default';
		
			// Get parent item name (enclosing item), and set parent_name = empty, or parent name
			var parent_name = ui.item.find('input[name^="parent_name"]')[0];
			var new_parent_name = ui.item.parents('.menu-editor-item').find('input[name^="name"]')[0];
			if (new_parent_name) parent_name.value=new_parent_name.value;
			else parent_name.value='';
		
			/* Get siblings item priority and set priority = same as previous item, or 100
			 * Changement d'ordre : priorité = celle du précédent item, ou celle du suivant, ou reste inchangée
			 * Note : l'ordre sera conservé de facto si on enregistre le menu (et qu'on l'affiche par ordre d'enregistrement)
			 */
			var priority = ui.item.find('input[name^="priority"]')[0]; // OK
			var prev_priority = ui.item.prev().find('input[name^="priority"]')[0]; // OK
			var next_priority = ui.item.next().find('input[name^="priority"]')[0]; // OK
			// Set to previous item if set, to next item otherwise, and leave unchanged if no sibling
			if (prev_priority) priority.value=prev_priority.value;
			else if (next_priority) priority.value=next_priority.value;
			//else priority.value='100';
		}
	});
};


elgg.register_hook_handler('init', 'system', elgg.elgg_menus.edit.init);

