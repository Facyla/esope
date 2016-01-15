<?php
/**
 * Elgg Market Plugin
 * @package market
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_load_js('market');

$post = get_entity($vars['guid']);
if ($post) {
	$tu = $post->time_updated;
	$images = unserialize($post->images);
}

// Get plugin settings
$allowhtml = elgg_get_plugin_setting('market_allowhtml', 'market');
$currency = elgg_get_plugin_setting('market_currency', 'market');
$numchars = elgg_get_plugin_setting('market_numchars', 'market');
$marketcategories = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));
$custom_choices = string_to_tag_array(elgg_get_plugin_setting('market_custom_choices', 'market'));

if($numchars == ''){
	$numchars = '250';
}

echo "<div><label>";
echo elgg_echo('title') . "</label><span class='elgg-subtext mlm'>" . elgg_echo("market:title:help") . "</span>";
echo elgg_view("input/text", array(
				"name" => "title",
				"value" => $vars['title'],
				'autofocus' => true,
				//'required' => true,
				));
echo "</div>";

if (!empty($marketcategories)) {
	$options = array();
	$options[''] = elgg_echo("market:choose");
	foreach ($marketcategories as $option) {
		$options[$option] = elgg_echo("market:category:{$option}");
	}		
	unset($options['all']);
	echo "<div>";
	echo elgg_view('input/dropdown',array(
						'options_values' => $options,
						'value' => $vars['marketcategory'],
						'name' => 'marketcategory',
						//'required' => true,
						));
	echo "<label>" . elgg_echo('market:categories:choose') . "</label></div>";
}

$types = array('buy', 'sell', 'swap', 'free');
$options = array();
$options[''] = elgg_echo("market:choose");
foreach ($types as $type) {
	$options[$type] = elgg_echo("market:type:{$type}");
}		
echo "<div>";
echo elgg_view('input/dropdown',array(
				'options_values' => $options,
				'value' => $vars['market_type'],
				'name' => 'market_type',
				'id' => 'market-type',
				//'required' => true,
				));
echo "<label>" . elgg_echo('market:type:choose') . "</label></div>";

if (elgg_get_plugin_setting('market_custom', 'market') == 'yes' && !empty($custom_choices)) {
	$custom_options = array();
	$custom_options[''] = elgg_echo("market:choose");
	foreach ($custom_choices as $custom_choice) {
		$custom_options[$custom_choice] = elgg_echo("market:custom:{$custom_choice}");
	}		
	
	echo "<div>";
	echo elgg_view('input/dropdown',array(
						'options_values' => $custom_options,
						'value' => $vars['custom'],
						'name' => 'custom',
						//'required' => true,
						));
	echo "<label>" . elgg_echo('market:custom:select') . "</label></div>";
}

if (elgg_get_plugin_setting('location', 'market') == 'yes') {
	echo "<div><label>";
	echo elgg_echo('market:location') . "</label><span class='elgg-subtext mlm'>" . elgg_echo("market:location:help") . "</span>";
	echo elgg_view("input/location", array(
				"name" => "location",
				"value" => $vars['location'],
				));
	echo "</div>";
}

echo "<div><label>" . elgg_echo("market:text") . "</label>";
if ($allowhtml != 'yes') {
	echo "<span class='elgg-subtext mlm'>" . elgg_echo("market:text:help", array($numchars)) . "</span>";
	echo "<textarea name='description' class='mceNoEditor' id='plaintext-description' rows='5' cols='40'>{$vars['description']}</textarea><br />";
	echo "<div class='market_characters_remaining'><input readonly type='text' name='remLen1' size='3' maxlength='3' value='{$numchars}' class='market_charleft'>" . elgg_echo("market:charleft") . "</div>";
} else {
	echo elgg_view("input/longtext", array(
					'name' => 'description',
					'value' => $vars['description'],
					'required' => true,
					));
}
echo "</div>";

echo "<div><label>" . elgg_echo("market:price") . "</label>";
echo "<span class='elgg-subtext mlm'>" . elgg_echo("market:price:help", array($currency)) . "</span>";
echo elgg_view("input/text", array(
				"name" => "price",
				"value" => $vars['price'],
				"id" => "market-price",
				));
			
echo "</div>";

echo "<div><label>" . elgg_echo("market:tags") . "</label>";
echo "<span class='elgg-subtext mlm'>" . elgg_echo("market:tags:help") . "</span>";
echo elgg_view("input/tags", array(
				"name" => "tags",
				"value" => $vars['tags'],
				));
echo "</div>";

echo "<div><label>" . elgg_echo("market:uploadimages");
echo "</label><span class='elgg-subtext mlm'>" . elgg_echo("market:imagelimitation") . "</span>";
echo "</div>";

$image1 = elgg_view('market/thumbnail', array(
			'guid' => $post->guid,
			'imagenum' => 1,
			'size' => 'medium',
			'class' => 'market-form-image',
			'tu' => $tu
			));
$body1 = "<div><label>" . elgg_echo("market:uploadimage1") . "</label>";
if ($images[1]) {
	$body1 .= elgg_view('output/url', array(
			'href' => "action/market/delete_img?guid={$post->guid}&img=1",
			'text' => elgg_echo('delete'),
			'is_action' => true,
			'class' => 'elgg-button elgg-button-delete float-alt mrs',
			'data-confirm' => elgg_echo('market:delete:image'),
			));
}
$body1 .= elgg_view("input/file",array('name' => 'upload1'));
$body1 .= "</div>";

echo elgg_view_image_block($image1, $body1);

$image2 = elgg_view('market/thumbnail', array(
			'guid' => $post->guid,
			'imagenum' => 2,
			'size' => 'medium',
			'class' => 'market-form-image',
			'tu' => $tu
			));
$body2 = "<div><label>" . elgg_echo("market:uploadimage2") . "</label>";
if ($images[2]) {
	$body2 .= elgg_view('output/url', array(
			'href' => "action/market/delete_img?guid={$post->guid}&img=2",
			'text' => elgg_echo('delete'),
			'is_action' => true,
			'class' => 'elgg-button elgg-button-delete float-alt mrs',
			'data-confirm' => elgg_echo('market:delete:image'),
			));
}
$body2 .= elgg_view("input/file",array('name' => 'upload2'));
$body2 .= "</div>";

echo elgg_view_image_block($image2, $body2);

$image3 = elgg_view('market/thumbnail', array(
			'guid' => $post->guid,
			'imagenum' => 3,
			'size' => 'medium',
			'class' => 'market-form-image',
			'tu' => $tu
			));
$body3 = "<div><label>" . elgg_echo("market:uploadimage3") . "</label>";
if ($images[3]) {
	$body3 .= elgg_view('output/url', array(
			'href' => "action/market/delete_img?guid={$post->guid}&img=3",
			'text' => elgg_echo('delete'),
			'is_action' => true,
			'class' => 'elgg-button elgg-button-delete float-alt mrs',
			'data-confirm' => elgg_echo('market:delete:image'),
			));
}
$body3 .= elgg_view("input/file",array('name' => 'upload3'));
$body3 .= "</div>";

echo elgg_view_image_block($image3, $body3);

$image4 = elgg_view('market/thumbnail', array(
			'guid' => $post->guid,
			'imagenum' => 4,
			'size' => 'medium',
			'class' => 'market-form-image',
			'tu' => $tu
			));
$body4 = "<div><label>" . elgg_echo("market:uploadimage4") . "</label>";
if ($images[4]) {
	$body4 .= elgg_view('output/url', array(
			'href' => "action/market/delete_img?guid={$post->guid}&img=4",
			'text' => elgg_echo('delete'),
			'is_action' => true,
			'class' => 'elgg-button elgg-button-delete float-alt mrs',
			'data-confirm' => elgg_echo('market:delete:image'),
			));
}
$body4 .= elgg_view("input/file",array('name' => 'upload4'));
$body4 .= "</div>";

echo elgg_view_image_block($image4, $body4);

echo "<div>";
echo elgg_view('input/access', array('name' => 'access_id','value' => $vars['access_id']));
echo "<label>" . elgg_echo('access') . "</label><span class='elgg-subtext mlm'>" . elgg_echo("market:access:help") . "</span></div>";

echo "<div>";
// Terms checkbox and link
$termslink = elgg_view('output/url', array(
			'href' => "market/terms",
			'text' => elgg_echo('market:terms:title'),
			'class' => "elgg-lightbox",
			));
$termsaccept = elgg_echo("market:accept:terms", array($termslink));
echo "</div>";
echo "<input type='checkbox' name='accept_terms'><label>{$termsaccept}</label></p>";

echo "<div class='elgg-foot'>";
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));
echo "</div>";

