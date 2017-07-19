<?php
/**
 * Group summary : infos complémentaires => access, membership, group admins, num of members
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity metadata and actions (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (optional)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

//echo elgg_view('object/elements/summary', $vars);

/**
 * Object summary
 *
 * Sample output
 * <ul class="elgg-menu elgg-menu-entity"><li>Public</li><li>Like this</li></ul>
 * <h3><a href="">Title</a></h3>
 * <p class="elgg-subtext">Posted 3 hours ago by George</p>
 * <p class="elgg-tags"><a href="">one</a>, <a href="">two</a></p>
 * <div class="elgg-content">Excerpt text</div>
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (default is tags on entity, pass false for no tags)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

$entity = $vars['entity'];

$group_url = $entity->getURL();
if ($entity->isMember()) { $group_url = elgg_get_site_url() . 'groups/workspace/' . $entity->guid; }
$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {
	if (isset($entity->title)) { $text = $entity->title; } else { $text = $entity->name; }
	$params = array(
		'text' => elgg_get_excerpt($text, 100),
		'href' => $group_url,
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') { $tags = elgg_view('output/tags', array('tags' => $entity->tags)); }


echo '<div class="iris-group-body">';

	if ($metadata) { echo $metadata; }
	if ($title_link) { echo "<h3>$title_link</h3>"; }
	echo "<div class=\"elgg-subtext\"><p>$subtitle</p></div>";
	echo $tags;

	echo elgg_view('object/summary/extend', $vars);

	if ($content) { echo "<div class=\"elgg-content\">$content</div>"; }


	// Display some group details only in owner_block
	if (!elgg_in_context('owner_block')) { return; }

	echo '<div style="font-size:80%">';

		echo '<p>';
		// Access
		echo '<span class="group-access">' .elgg_echo('theme_inria:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $entity)) . '</span><br />';

		// Membership
		if ($entity->membership == ACCESS_PUBLIC) {
			//echo '<span title="' . elgg_echo("theme_inria:groupmembership:open:details") . '">' . elgg_echo("theme_inria:groupmembership:open") . '</span>';
			echo elgg_echo('theme_inria:groupmembership') . '&nbsp;: <span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . ' - ' . elgg_echo("theme_inria:groupmembership:open:details");
		} else {
			//echo '<span title="' . elgg_echo("theme_inria:groupmembership:closed:details") . '">' . elgg_echo("theme_inria:groupmembership:closed") . '</span>';
			echo elgg_echo('theme_inria:groupmembership') . '&nbsp;: <span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . ' - ' . elgg_echo("theme_inria:groupmembership:closed:details");
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
		//$active_members = $entity->getMembers(array('count' => true));
		// Inria : count only accounts that are not closed
		$active_members_wheres[] = "NOT EXISTS (
				SELECT 1 FROM " . elgg_get_config('dbprefix') . "metadata md
				WHERE md.entity_guid = e.guid
				    AND md.name_id = " . elgg_get_metastring_id('memberstatus') . "
				    AND md.value_id = " . elgg_get_metastring_id('closed') . ")";
		$active_members = $entity->getMembers(array('wheres' => $active_members_wheres, 'count' => true));
		// Total count
		$all_members = $entity->getMembers(array('count' => true));


		$members_string = $all_members . ' ' . elgg_echo('groups:member');
	
		if ($all_members != $active_members) {
			if ($active_members > 1) {
				$members_string = elgg_echo('theme_inria:groups:entity_menu', array($all_members, $active_members));
			} else {
				if ($all_members > 1) {
					$members_string = elgg_echo('theme_inria:groups:entity_menu:singular', array($all_members, $active_members));
				} else {
					$members_string = elgg_echo('theme_inria:groups:entity_menu:none', array($all_members, $active_members));
				}
			}
		}
		echo '<p><a href="' . elgg_get_site_url() . 'groups/members/' . $entity->guid . '" class="viewall" title="' . elgg_echo('groups:members:more') . '">' . $members_string . '</a></p>';
		?>
	</div>
	<br />
	<strong><?php echo elgg_echo('theme_inria:grouptools'); ?></strong><br />
</div>

