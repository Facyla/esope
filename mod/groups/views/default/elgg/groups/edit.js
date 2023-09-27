/**
 * JavaScript used on group creation/editing form
 */
define(['jquery', 'elgg'], function($, elgg) {

	/**
	 * Toggle the availability of content access field
	 *
	 * Content access field gets disabled in the group edit form when
	 * group is made visible only to members. When the visibility is
	 * made less restrictive, the field is enabled again.
	 *
	 * @param {Object} event
	 */
	var toggleContentAccessMode = function(event) {
		var accessModeField = $('#groups-content-access-mode');

		if ($(this).val() == 0) {
			// Group is hidden, so force members_only mode and disable the field
			accessModeField.val('members_only').prop('disabled', true);
		} else {
			// Enable the field
			accessModeField.prop('disabled', false);
		}
	};

	$('#groups-vis').on('change', toggleContentAccessMode);

	return {
		toggleContentAccessMode: toggleContentAccessMode
	};
});
