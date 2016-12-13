<?php
$offer = elgg_extract('entity', $vars, FALSE);

$content = '';

// Set form values and defaults
if (!elgg_instanceof($offer, 'object', 'uhb_offer')) {
	echo elgg_echo('uhb_annonces:error:noentity');
	return;
}

// Set dropdown options_values
$yes_no_opt = array('yes' => elgg_echo('uhb_annonces:option:yes'), 'no' => elgg_echo('uhb_annonces:option:no'));


// Get saved values in case it failed...
if (elgg_is_sticky_form('uhb_candidate')) {
	$fields = uhb_annonces_get_fields('edit');
	extract(elgg_get_sticky_values('uhb_candidate'));
	elgg_clear_sticky_form('uhb_candidate');
}


// Note : need to force the form for encoding ?
$content .= '<form id="uhb_annonces-candidate-form" method="POST" enctype="multipart/form-data" action="' . $CONFIG->url . 'action/uhb_annonces/candidate" class="elgg-form-uhb-annonces-candidate">';
$content .= elgg_view('input/securitytoken');

// Hidden fields (required but non-editable)
$content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $offer->guid));

$content .= '<fieldset>';
$content .= '<legend>' . elgg_echo('uhb_annonces:form:candidate:attachment') . '</legend>';
// case cochée non modifiable, affichage seulement
$content .= '<p><label>' . elgg_view('input/checkbox', array('disabled' => 'disabled', 'checked' => 'checked')) . elgg_echo('uhb_annonces:apply:attachfiles') . '</label></p>';

// Un fichier joint obligatoire
$content .= '<p><label>' . elgg_echo('uhb_annonces:apply:file1') . elgg_view('input/file', array('name' => 'uhb_offer_file1', 'required' => 'required')) . '</label></p>';
// Un 2e fichier joint facultatif
$content .= '<p><label>' . elgg_echo('uhb_annonces:apply:file2') . elgg_view('input/file', array('name' => 'uhb_offer_file2')) . '</label></p>';
$content .= '</fieldset>';


// Profil joint (lien vers le profil)
$content .= '<fieldset>';
$content .= '<legend>' . elgg_echo('uhb_annonces:form:candidate:profilelink') . '</legend>';
$content .= '<p><em>' . elgg_echo('uhb_annonces:apply:profile:details') . '</em></p>';
// Conditions nécessaire pour cocher : avoir renseigné Formation, Expérience et Compétences, en visibilité Public, sinon grisé décoché
// Check conditions
$complete = uhb_annonces_is_profile_complete();
if ($complete) {
	$content .= '<p><label>' . elgg_view('input/checkbox', array('name' => 'addprofile')) . elgg_echo('uhb_annonces:apply:profile:attach') . '</label></p>';
} else {
	$content .= '<p class="disabled"><label>' . elgg_view('input/checkbox', array('disabled' => 'disabled')) . elgg_echo('uhb_annonces:apply:profile:attach') . '</label></p>';
	$content .= '<p><blockquote>' . elgg_echo('uhb_annonces:apply:profile:cantattach') . '</blockquote></p>';
}
$content .= '</fieldset>';



$content .= '<div class="clearfloat"></div><br />';
$content .= '<div class="uhb_annonces-wait" style="display:none;">' . elgg_echo('uhb_annonces:action:candidate:waitwhilesending') . '</div>';

// Message d'attente pendant l'envoi
$content .= elgg_view('input/submit', array('value' => elgg_echo('uhb_annonces:form:action:candidate'), 'onClick' => ""));

// Interception envoi pour ajouter une légère temporisation et laisser lire le message
$content .= '<script>
$(\'#uhb_annonces-candidate-form\').submit( function(event) {
	var formId = this.id, form = this;
	event.preventDefault();
	$(\'.uhb_annonces-wait\').show();
	setTimeout(
		function(){
			form.submit();
		}, 2000);
});
</script>';

$content .= '</form>';



echo $content;

