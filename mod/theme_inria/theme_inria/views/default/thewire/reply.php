<?php
/**
 * Reply header
 */

$post = $vars['post'];
$poster = $post->getOwnerEntity();
$poster_details = array(
	htmlspecialchars($poster->name,  ENT_QUOTES, 'UTF-8'),
	htmlspecialchars($poster->username,  ENT_QUOTES, 'UTF-8'),
);
?>

<div class="iris-box home-wire elgg-list-container">
	<b><?php echo elgg_echo('thewire:replying', $poster_details); ?>: </b>
	<?php echo $post->description;
	?>
</div>

