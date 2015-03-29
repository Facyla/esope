elgg.provide('elgg.elgg_menus.edit');


// Total number of items
var numitems = 0;

/**
 * Initialize the elgg_menus editing javascript
 */
elgg.elgg_menus.edit.init = function() {
	numitems = parseInt($('#menu-editor-numitems').val());
	
	// Add menu item
	$(document).on('click', '#menu-editor-add-item', elgg.elgg_menus.edit.addMenuItem);
	
	// Remove menu item
	$(document).on('click', '.menu-editor-delete-item', elgg.elgg_menus.edit.deleteMenuItem);
	
	// Hide/show some menu_item edit form options
	$(document).on('click', '.menu-editor-input-toggle', elgg.elgg_menus.edit.toggleInput);
};


/**
 * Add a new empty menu item to the form
 *
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.addMenuItem = function(e) {
	
	// Increment total number of menu_items
	numitems++;
	$('#menu-editor-numitems').val(numitems);
	
	// Create a new menu_item fieldset elements, rewritten as JS to include numitems param
	// MenuItem object meta : title, description, input_type, options, empty_value, required
	
	// <?php //echo json_encode(elgg_view('elgg_menus/input/menu_item_type_help')); ?>
	
	var deleteLink = '<a href="javascript:void(0);" class="menu-editor-delete-item" title="' + elgg.echo('elgg_menus:delete') + '" data-id="menu-editor-item-' + numitems + '"><i class="fa fa-trash"></i></a>';
	
	var container = '<div class="menu-editor-item" id="menu-editor-item-' + numitems + '">' 
			+ '<span style="float:right; margin-left: 2ex;">' + deleteLink + '</span>' 
			+ '<a href="javascript:void(0);" onClick="$(\'#menu-editor-item-' + numitems + ' .menu-editor-item-content\').toggle();" style="float:right; margin-left: 2ex;"><i class="fa fa-cog"></i>' + elgg.echo('elgg_menus:item:edit') + '</a>' 
			+ '<div class="menu-editor-item-content">' 
			+ '<label>Name <input type="text" value="" name="name[]" class="elgg-input-text user-success" id=""></label>' 
			+ '<label>URL <input type="text" value="" name="href[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Text <input type="text" value="" name="text[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Tooltip <input type="text" value="" name="title[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Confirm <input type="text" value="" name="confirm[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Item class <input type="text" value="" name="item_class[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Link class <input type="text" value="" name="link_class[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Section <input type="text" value="" name="section[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Priority <input type="text" value="" name="priority[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Context <input type="text" value="" name="contexts[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Selected <input type="text" value="" name="selected[]" class="elgg-input-text" id=""></label>' 
			+ '<label>Parent name <input type="text" value="" name="parent_name[]" class="elgg-input-text" id=""></label>' 
			+ '</div>' 
		+ '</div>';
	
	$('#menu-editor-newitems').append(container);
	
	e.preventDefault();
};


/** Remove a elgg_menus menu_item
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.deleteMenuItem = function(e) {
	var id = $(this).data('id');
	if (confirm(elgg.echo('elgg_menus:delete:confirm'))) {
		$('#' + id).remove();
	}
	e.preventDefault();
}

/** Toggle an input elgg_menus menu_item
 * @param {Object} e The click event
 */
elgg.elgg_menus.edit.toggleInput = function(e) {
	var id = $(this).data('id');
	$('[name="' + id + '"]').toggle();
	e.preventDefault();
}

/** Show/Hide a elgg_menus menu_item input
 * @param {Object} e The change event
 */
elgg.elgg_menus.edit.showOptions = function(e) {
	var select = $(e.target);
	var val = select.val();
	var id = $(this).data('id');
	// Show/hide appropriate optional fields
	$('.menu_item_options_' + id).hide();
	$('.menu_item_empty_value_' + id).hide();
	if ((val == "dropdown") || (val == "pulldown") || (val == "checkboxes") || (val == "multiselect") || (val == "rating")) {
		$('.menu_item_options_' + id).show();
		if ((val == "dropdown") || (val == "pulldown") || (val == "rating")) {
			$('.menu_item_empty_value_' + id).show();
		}
	}
	// Show/hide appropriate help text
	$('#menu_item-container-' + id + ' .menu_item-help').hide();
	$('#menu_item-container-' + id + ' .menu_item-' + val).show();
	//return true;
	//e.preventDefault();
}


elgg.register_hook_handler('init', 'system', elgg.elgg_menus.edit.init);


