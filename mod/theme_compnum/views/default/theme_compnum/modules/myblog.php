<?php
$user = $vars['entity'];

"<h3>Mon BLOG</h3>";
elgg_push_context('widgets');
$myblog = elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'owner_guid' => $user->guid, 'limit' => 3, 'full_view' => false, 'pagination' => false));
elgg_pop_context();
if (empty($myblog)) $myblog = '<p>Aucun article publié pour le moment.</p>';
echo $myblog;

