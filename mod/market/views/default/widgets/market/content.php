<?php
/**
 * Elgg Market Plugin
 * @package market
 */

//the page owner
$owner = get_user($vars['entity']->owner_guid);

//the number of files to display
$num = (int) $vars['entity']->num_display;
if (!$num) {
	$num = 4;
}		
		
$posts = elgg_get_entities(array('type'=>'object','subtype'=>'market', 'owner_guid' => $owner->guid, 'limit'=>$num));

echo '<ul class="elgg-list">';		
// display the posts, if there are any
if (is_array($posts) && sizeof($posts) > 0) {

	if (!$size || $size == 1){
		foreach($posts as $post) {
			echo "<li class=\"pvs\">";
			$category = "<b>" . elgg_echo('market:category') . ":</b> " . elgg_echo('market:category:' . $post->marketcategory);
			$type = "<b>" . elgg_echo('market:type') . ":</b> " . elgg_echo("market:type:{$post->market_type}");
			$price = "<b>" . elgg_echo('market:price') . ":</b> {$post->price}";
			$comments_count = $post->countComments();
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
						'href' => $post->getURL() . '#market-comments',
						'text' => $text,
						));
			$img = elgg_view('output/img', array(
						'src' => "market/image/{$post->guid}/1/small/{$tu}",
						'alt' => $post->guid,
						));
			$market_img = elgg_view('output/url', array(
						'href' => $post->getURL(),
						'text' => $img,
						));
			$subtitle = "$category<br>$type<br>$price";
			$subtitle .= "<br>{$author_text} {$date} {$comments_link}";
			$params = array(
				'entity' => $post,
				'metadata' => $metadata,
				'subtitle' => $subtitle,
				'tags' => $tags,
				'content' => $excerpt,
			);
			$params = $params + $vars;
			$list_body = elgg_view('object/elements/summary', $params);
			echo elgg_view_image_block($market_img, $list_body);
			echo "</li>";
		}
			
	}
	echo "</ul>";
	echo "<div><a href=\"" . elgg_get_site_url() . "market/" . $owner->username . "\">" . elgg_echo("market:widget:viewall") . "</a></div>";

}

