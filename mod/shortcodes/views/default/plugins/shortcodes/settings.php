<?php
/**
 * Shortcodes settings
 */

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

// Default required settings
?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('shortcodes:settings:title');?></legend>
		
		<?php
		global $shortcode_tags;
		// Liste des shortcodes actifs : attention à la manière de les désactiver, si on veut pouvoir les lister automatiquement !
		foreach ($shortcode_tags as $tag => $shortcode_func) {
			echo '<label>' . elgg_echo('shortcodes:available:'.$tag) . '</label><br/>' . elgg_view('input/dropdown', array( 'name' => 'params['.$tag.']', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->$tag )) . '<br/>';
		}
		?>
		
	</fieldset>
</p>

