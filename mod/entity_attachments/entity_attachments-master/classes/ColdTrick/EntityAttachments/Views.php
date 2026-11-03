<?php

namespace ColdTrick\EntityAttachments;

/**
 * View related callbacks
 */
class Views {
	
	/**
	 * Set the attachments vars
	 *
	 * @param \Elgg\Event $event 'view_vars', 'object/elements/full'
	 *
	 * @return null|array
	 */
	public static function addAttachments(\Elgg\Event $event): ?array {
		$vars = $event->getValue();
		if (isset($vars['attachments'])) {
			return null;
		}
		
		$entity = elgg_extract('entity', $vars);
		if (!$entity instanceof \ElggObject) {
			return null;
		}
		
		$attachments = elgg_view('entity_attachments/list', ['entity' => $entity]);
		if (empty($attachments)) {
			return null;
		}
		
		$vars['attachments'] = $attachments;
		
		return $vars;
	}
}
