<?php
/**
 * Group summary
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity metadata and actions (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (optional)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

echo elgg_view('object/elements/summary', $vars);

/*
$entity = $vars['entity'];

$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {
	if (isset($entity->title)) { $text = $entity->title; } else { $text = $entity->name; }
	$params = array(
		'text' => elgg_get_excerpt($text, 100),
		'href' => $entity->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') { $tags = elgg_view('output/tags', array('tags' => $entity->tags)); }

if ($metadata) { echo $metadata; }
if ($title_link) { echo "<h3>$title_link</h3>"; }
echo "<div class=\"elgg-subtext\">$subtitle</div>";
echo $tags;

echo elgg_view('object/summary/extend', $vars);

if ($content) { echo "<div class=\"elgg-content\">$content</div>"; }


// Display some group details only in owner_block
if (!elgg_in_context('owner_block')) { return; }

echo '<div style="font-size:80%">';

echo '<p>';
// Access
echo '<span class="group-access">' .elgg_echo('esope:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $entity)) . '</span><br />';

// Membership
if ($entity->membership == ACCESS_PUBLIC) {
	//echo '<span title="' . elgg_echo("esope:groupmembership:open:details") . '">' . elgg_echo("esope:groupmembership:open") . '</span>';
	echo elgg_echo('esope:groupmembership') . '&nbsp;: <span class="membership-group-open">' . elgg_echo("esope:groupmembership:open") . ' - ' . elgg_echo("esope:groupmembership:open:details");
} else {
	//echo '<span title="' . elgg_echo("esope:groupmembership:closed:details") . '">' . elgg_echo("esope:groupmembership:closed") . '</span>';
	echo elgg_echo('esope:groupmembership') . '&nbsp;: <span class="membership-group-closed">' . elgg_echo("esope:groupmembership:closed") . ' - ' . elgg_echo("esope:groupmembership:closed:details");
}
echo '</p>';

// Propriétaire un peu à part, en premier
echo '<strong>' . elgg_echo('group_operators:operators') . '</strong><br />';
$groupowner = $entity->getOwnerEntity();
echo '<span style="float:left;" title="' . elgg_echo('group_operators:owner') . '">' . elgg_view_entity_icon($groupowner, 'tiny') . '</span>';
// @TODO : risque de doublon dans le cas où un responsable a récupéré la propriété du groupe
echo elgg_list_entities_from_relationship(array('types'=>'user', 'relationship' => 'operator', 'relationship_guid' => $entity->guid, 'inverse_relationship' => TRUE, 'order_by' => 'r.time_created DESC', "list_type" => "gallery", "gallery_class" => "elgg-gallery-users", "pagination" => false, 'size' => 'tiny', 'wheres' => "e.guid != {$groupowner->guid}", 'limit' => 0));
echo '<div class="clearfloat"></div>';
// Lien admin des responsables de groupes
if ($entity->canEdit()) {
	echo '<a href="' . elgg_get_site_url() . 'group_operators/manage/' . $entity->guid . '">' . elgg_echo('group_operators:manage') . '</a>';
}
?>
<div class="clearfloat"></div><br />
<?php
// Number of members
//echo '<p>' . elgg_echo('groups:members') . ' : ' . $entity->getMembers(0, 0, TRUE) . '<br /><a href="' . elgg_get_site_url() . 'groups/members/' . $entity->guid . '" class="viewall">' . elgg_echo('groups:members:more') . '</a></p>';
$nb_members = $entity->getMembers(array('count' => true));
if ($nb_members > 1) {
	echo '<p><a href="' . elgg_get_site_url() . 'groups/members/' . $entity->guid . '" class="viewall" title="' . elgg_echo('groups:members:more') . '">' . $nb_members . ' ' . elgg_echo('groups:members') . '</a></p>';
} else {
	echo '<p><a href="' . elgg_get_site_url() . 'groups/members/' . $entity->guid . '" class="viewall" title="' . elgg_echo('groups:members:more') . '">' . $nb_members . ' ' . elgg_echo('groups:member') . '</a></p>';
}
?>
</div>
<br />
<strong><?php echo elgg_echo('esope:grouptools'); ?></strong><br />

*/
