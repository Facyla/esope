<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof Newsletter) {
	return;
}

$header = '';
if ($entity->hasIcon('newsletter_header')) {
	$header = elgg_format_element('img', [
		'src' => elgg_normalize_url($entity->getIconURL([
			'size' => 'newsletter_header',
		])),
		'style' => 'display:block;',
		'width' => '100%',
	]);
}

$url = elgg_get_site_url();
$logo = '<img src="' . $url . 'mod/theme_adf/graphics/titre-departements-en-reseaux-France-ADF.png" />';
?>

<div id="newsletter_online">
	{online}
</div>

<div id="newsletter_container">
	<div>
		<div id="newsletter_header">
			<?php echo $logo; ?>
			<h1>{title}</h1>
		</div>
		<?php echo $header; ?>
		<div id="newsletter_content">
			<div class="elgg-module-newsletter">
				{content}
			</div>
		</div>
		<div id="newsletter_footer">
		</div>
		<div id="newsletter_unsubscribe">
			{unsub}
		</div>
	</div>
</div>
