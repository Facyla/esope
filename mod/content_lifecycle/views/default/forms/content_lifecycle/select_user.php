<?php

// Formulaire de sélection initial (équivalent de User > Admin > Supprimer)
$content .= '<blockquote>' . elgg_echo('content_lifecycle:user:select:nouser') . '</blockquote>';

// Origin
$content .= '<fieldset style="border: 1px solid #CCC; padding: .5rem; margin: 0 0 .5rem 0;">';
	$content .= '<legend style="border: 1px solid #CCC; padding: 0 .5rem;">' . elgg_echo('content_lifecycle:user:select:user') . '</legend>';
	$content .= '<div><label>' . elgg_echo('content_lifecycle:user:select:user') . '</label>' . elgg_view('input/userpicker', ['name' => "guid", 'value' => '', 'limit' => 1]) . '</div>';
$content .= '</fieldset>';

$footer = elgg_view('input/submit', [
	'value' => elgg_echo('content_lifecycle:user:select:submit'),
]);

elgg_set_form_footer($footer);

echo $content;

