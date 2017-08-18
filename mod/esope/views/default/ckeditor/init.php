<?php
/**
 * Initialize the CKEditor script
 * 
 * Doing this inline enables the editor to initialize textareas loaded through ajax
 */

/* Notes sur configs et démarrage de l'éditeur :
 * Pour démarrer avec éditeur désactivé : appeler input/longtext avec la propriété data-cke-init => true
 * Pour utiliser != configs, les définir dans js/elgg/ckeditor/config.js.php puis les associer aux classes CSS dans js/elgg/ckeditor.js (pour activation manuelle) et ci-dessous (pour activation au premier lancement)
*/

?>
<script>
// This global variable must be set before the editor script loading.
CKEDITOR_BASEPATH = elgg.config.wwwroot + 'mod/ckeditor/vendors/ckeditor/';


require(['elgg/ckeditor', 'jquery', 'jquery.ckeditor'], function(elggCKEditor, $) {
	
	$('.elgg-input-longtext:not([data-cke-init]):not(.elgg-input-longtext-basic)')
		.attr('data-cke-init', true)
		.ckeditor(elggCKEditor.init, elggCKEditor.config);
	
	var elggCKEditor_basic = $.extend(true,{},elggCKEditor);
	elggCKEditor_basic.config.toolbar = 'basic';
	$('.elgg-input-longtext-basic:not([data-cke-init])')
		.attr('data-cke-init', true)
		.ckeditor(elggCKEditor_basic.init, elggCKEditor_basic.config);
	
});
</script>
