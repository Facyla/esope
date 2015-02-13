<?php
// Displays the group chat in standalone page
// Note : chat access control should be done in the view

global $CONFIG;

gatekeeper();
$group_guid = get_input('group_guid', false);
$group = get_entity($group_guid);
if (!elgg_instanceof($group, 'group')) { return; }
elgg_set_page_owner_guid($group_guid);

$title = elgg_echo('group_chat:group_chat', array($group->name));
$vars['title'] = $title;
$content = '';
$content .= elgg_view('group_chat/group_chat', array('entity' => $group, 'chat_id' => $group_guid));

// Render pure content (for popup, lightbox or embed/iframe use)
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo $title; ?></title>
	<?php echo elgg_view('page/elements/head', $vars); ?>
	<style>
	html, body { background:#FFFFFF !important; }
	</style>
</head>
<body style="height:100%; margin:0; border:0;">
	<div style="padding:0 4px;">
		<?php echo $content; ?>
	</div>
</body>
</html>

