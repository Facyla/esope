
elgg.provide('elgg.upload_users');

elgg.upload_users.init = function() {

	var params = ({
		dataType : 'html',
		success : function(data) {
			$('#user-upload-admin-form').html(data);
		},
		iframe : true
	});

	$('#user-upload-admin-form').submit(function(event) {
		event.preventDefault();
		$(this).ajaxSubmit(params);
	});

};

elgg.register_hook_handler('init', 'system', elgg.upload_users.init);
