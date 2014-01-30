<?php
$pad_baseurl = 'https://notepad.inria.fr/';
$uid = esope_unique_id();

echo '<h3>' . elgg_echo('theme_inria:etherpad:title') . '</h3>';
echo '<p>' . elgg_echo('theme_inria:etherpad:details') . '</p>';
echo '<p><strong>' . elgg_echo('theme_inria:etherpad:warning') . '</strong></p>';
echo '<p>' . elgg_echo('theme_inria:etherpad:iframe') . '</p>';
echo '<br />';

echo '<hr />';
// Embed Pad block
echo '<p><label>' . elgg_echo('theme_inria:etherpad:padurl') . ' ' . elgg_view('input/url', array('name' => 'pad_url', 'onChange' => "document.getElementById('" . $uid . "').src = this.value")) . '</label></p>';
echo '<ul>';
	echo '<li class="embed-item" style="cursor: pointer;">';
		echo '<span class="elgg-button elgg-button-action">';
		echo elgg_echo('theme_inria:etherpad:existing');
		echo '</span>';
		echo '<p><em>' . elgg_echo('theme_inria:etherpad:existing:help') . '</em></p>';
		// Hide iframe - will display once embedded
		echo '<div class="hidden">';
			echo '<iframe id="' . $uid . '" class="embed-insert" style="width:100%; height:400px;"></iframe>';
		echo '</div>';
	echo '</li>';
echo '</ul>';
echo '<br />';

echo '<hr />';
// New pad link
echo '<a target="_blank" href="' . $pad_baseurl . '" class="elgg-button elgg-button-action">' . elgg_echo('theme_inria:etherpad:new') . '</a>';
echo '<p><em>' . elgg_echo('theme_inria:etherpad:new:help') . '</em></p>';
echo '<br />';

