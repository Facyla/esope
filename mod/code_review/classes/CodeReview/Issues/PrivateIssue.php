<?php
namespace CodeReview\Issues;

class PrivateIssue extends AbstractIssue {

	public function __construct(array $params = array()) {
		$params['reason'] = 'private';
		parent::__construct($params);
	}

	protected function getExplanation() {
		return "(use of function marked private is unsafe)";
	}
} 