<?php
/**
 * Administrator sets the categories for the site
 *
 * @package ElggCategories
 */

// Get site categories
$site = elgg_get_site_entity();
$categories = $site->categories;

if (empty($categories)) { $categories = array(); }
sort($categories);
$categories = implode(",\n", $categories);

// @TODO : automatically add parent categories if missing

?>
<div>
	<p><?php echo elgg_echo('categories:explanation'); ?></p>
	<p><?php echo elgg_echo('esope:categories:tree:explanation'); ?></p>
	<?php
	//echo elgg_view('input/tags', array('value' => $categories, 'name' => 'categories'));
	// Note : we use 'name' without 'params[]' because we're intercepting the value before saving it
	echo elgg_view('input/plaintext', array('value' => $categories, 'name' => 'categories'));
	// @TODO : automatically add commas before newlines, smthg like : yourString.split(",").join("\n")
	?>
</div>

<script type="text/javascript">
// Normalize input before sending (add commas)
$("#categories-settings").on("submit", function(event) {
	var val = $('#categories-settings textarea[name=categories]').val();
	// Replace line breaks by commas (note the /g to match all occurrences)
	val = val.replace(/(\r\n|\n|\r)/gm, ',');
	// Replace multiple commas by single comma
	val = val.replace(/(,+)/g, ',\n');
	$('#categories-settings textarea[name=categories]').val(val);
});
</script>

