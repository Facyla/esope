<?php
/**
 * Elgg select transitions filter switch
 */


$filter_opt = array(
		'featured' => elgg_echo('transitions:filter:featured'), 
		'read' => elgg_echo('transitions:filter:read'), 
		'recent' => elgg_echo('transitions:filter:recent'), 
		'commented' => elgg_echo('transitions:filter:commented'), 
		'enriched' => elgg_echo('transitions:filter:enriched'),
	);
echo '<span class="float-alt">';

echo elgg_view('input/select', array('class' => "float-alt", 'name' => "transitions-filter", 'options_values' => $filter_opt, 'onChange' => "theme_transitions2_filter_switch(this.value)"));

echo '<noscript>';
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));
//echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('theme_transitions2:home_article:select')));
echo '</noscript>';

echo '</span>';
?>
<script>
//$('#transitions-form-switch-filter').live('submit', theme_transitions2_filter_switch);
//$('#transitions-form-switch-filter').change('submit', theme_transitions2_filter_switch);
function theme_transitions2_filter_switch(filter) {
	$('.transitions-gallery').hide();
	$('.transitions-gallery-'+filter).show();
	event.preventDefault();
	event.stopPropagation();
}
</script>

