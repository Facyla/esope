<?php
/**
 * Administrator sets the categories for the site
 *
 * @package ElggCategories
 */

// Get site categories
$site = elgg_get_site_entity();
$categories = $site->categories;

//if (empty($categories)) { $categories = array(); }
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
	echo elgg_view('input/plaintext', array('value' => $categories, 'name' => 'categories'));
	// @TODO : automatically add commas before newlines, smthg like : yourString.split(",").join("\n")
	?>
</div>
