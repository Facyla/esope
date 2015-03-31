elgg.provide('elgg.elgg_menus.edit');


/** Initialize the elgg_menus editing javascript */
elgg.elgg_menus.edit.init = function() {
	// Add menu item
	$(document).on('click', '#menu-editor-add-item', elgg.elgg_menus.edit.addMenuItem);
	
	// Remove menu item
	$(document).on('click', '.menu-editor-delete-item', elgg.elgg_menus.edit.deleteMenuItem);
	
	// Hide/show some menu_item edit form options
	$(document).on('click', '.menu-editor-toggle-options', elgg.elgg_menus.edit.showOptions);
};


/** Remove a elgg_menus menu_item
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.deleteMenuItem = function(e) {
	var menu_item = $(this).parent();
	if (confirm(elgg.echo('elgg_menus:delete:confirm'))) { menu_item.remove(); }
	e.preventDefault();
}


/** Toggle an input elgg_menus menu_item
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.showOptions = function(e) {
	$(this).parent().children('.menu-editor-item-content').toggle();
	e.preventDefault();
}


/**
 * Add a new empty menu item to the form
 *
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.addMenuItem = function(e) {
	// Create a new menu_item element
	// MenuItem object meta : title, description, input_type, options, empty_value, required
	var new_item = <?php echo json_encode(elgg_view('elgg_menus/input/menu_item')); ?>;
	
	$('#menu-editor-newitems').append(new_item);
	e.preventDefault();
};


elgg.register_hook_handler('init', 'system', elgg.elgg_menus.edit.init);

