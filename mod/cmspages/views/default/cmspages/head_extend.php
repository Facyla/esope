<?php
// SEO META
if (!empty($vars['meta_description'])) { echo '<meta name="description" content="' . $vars['meta_description'] . '" />'; }
if (!empty($vars['meta_keywords'])) { echo '<meta name="keywords" content="' . $vars['meta_keywords'] . '" />'; }
if (!empty($vars['meta_robots'])) { echo '<meta name="robots" content="' . $vars['meta_robots'] . '" />'; }
if (!empty($vars['canonical_url'])) {
	echo '<link rel="canonical" href="' . $vars['canonical_url'] . '" />';
	echo '<link rel="bookmark" href="' . $vars['canonical_url'] . '" />';
}


