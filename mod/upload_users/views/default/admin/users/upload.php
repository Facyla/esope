<?php
elgg_load_css('upload_users.css');
elgg_load_js('jquery.form');
elgg_load_js('upload_users.js');

$upload = new UploadUsers();

/// Get the upload form
$body = $upload->getUploadForm();

echo $body;