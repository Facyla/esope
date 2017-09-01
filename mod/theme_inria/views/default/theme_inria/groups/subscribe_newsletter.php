<?php
/**
 * (un)subscribe to the newsletter of the container entity
 * This is shown in the sidebar
 *
 * @uses $vars['entity'] The container entity to (un)subscribe to/from
 */

$entity = elgg_extract('entity', $vars);

echo elgg_view_form('newsletter/subscribe', [], ['entity' => $entity]);

