<?php

namespace Facyla\ThemeADF;

use Elgg\Groups\ToolContainerLogicCheck;

/**
 * Prevent files from being created if the group tool option is disabled
 */
class FileGroupToolContainerLogicCheck extends ToolContainerLogicCheck {
	public function __invoke(\Elgg\Hook $hook) {
		
		if ($hook->getType() !== $this->getContentType()) {
			// not the correct hook registration
			return;
		}
		
		$container = $hook->getParam('container');
		if (!$container instanceof \ElggGroup) {
			return;
		}
		
		if ($hook->getParam('subtype') !== $this->getContentSubtype()) {
			return;
		}
		
		if ($container->isToolEnabled($this->getToolName())) {
			return;
		}
		
		// ADF : Allow uploading files for embed if user is group member (or admin)
		$upload_context = get_input('file_upload_context');
		if ($upload_context == 'embed' && ($container->isMember() || $container->canEdit())) {
			return;
		}
		
		return false;
	}
	/**
	 * {@inheritDoc}
	 */
	public function getContentType(): string {
		return 'object';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getContentSubtype(): string {
		return 'file';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getToolName(): string {
		return 'file';
	}
}
