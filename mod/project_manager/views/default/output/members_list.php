<?php
$content ='';
$members_list = $vars['value'];

if (empty($members_list)) { echo '' . elgg_echo('members:none') . '<br /><br />'; return; }

if (!is_array($members_list)) { $members_list = array($members_list); }

foreach($members_list as $guid) {
  $ent = get_entity($guid);
  $content .= '<span style="float:left; margin:0 6px 6px 0;">' . elgg_view_entity_icon($ent, 'tiny') . ' <span style="float:right;">' . $ent->name . "</span></span>";
}

$content .= '<div style="clear:left;"></div>';

echo '<div>' . $content . '</div>';

