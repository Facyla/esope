<?php
/**
 * Class that represents an object of subtype survey
 */
class CMSPage extends ElggObject {
	const SUBTYPE = "cmspage";

	/** @var array $responses Cache for number of responders for each question */
	private $responses_by_question = array();

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}



	/** Returns page immediate children
	 *
	 * @param ElggUser $cmspage
	 * @return array cmspage
	 */
	public function getChildren() {
		// Get cmspages where parent_guid = $this->guid
		$cmspages = elgg_get_entities_from_metadata(array(
			'type' => "object", 'subtype' => "cmspage",
			'metadata_name_value_pairs' => array('name' => 'parent_guid', 'value' => $this->guid),
			'limit' => 1
		));
		return $cmspages;
	}
	
	
	
	
	/** Check whether the user has responded in this survey
	 *
	 * @param ElggUser $user
	 * @return boolean
	 */
	/*
	public function hasResponded($user) {
		$responses = elgg_get_annotations(array(
			'guid' => $this->guid,
			'type' => "object", 'subtype' => "survey",
			'annotation_name' => "response", 'annotation_owner_guid' => $user->guid,
			'limit' => 1
		));
		if ($responses) { return true; } else { return false; }
	}
	*/
	



	// @TODO : attention à modifier la logique de comptage pour permettre d'inclure les questions, ayant elle-même diverses options et réponses
	
	/**
	 * Fetch and cache amount of responses (users who responded) for each question
	 *
	 */
	/*
	private function fetchResponses() {
		if ($this->responses_by_question) { return; }
		
		// Make sure questions without responses are included in the result
		foreach ($this->getQuestions() as $question) {
			$guid = $question->guid;
			$this->responses_by_question[$guid] = array();
			
			// Get responses count for each question
			// Does not work as expected
			//$responses_count = $question->countAnnotations('response');
			//$this->responses_by_question[$guid] = $responses_count;
			//
			
			// Get responses
			$responses = new ElggBatch('elgg_get_annotations', array('guid' => $guid, 'annotation_name' => 'response', 'limit' => 0));
			//error_log("Survey : question $guid = $question->title => $count");
			
			// Cache the amount of responses for each question choice (1 per user)
			$responses_count = array();
			foreach ($responses as $response) {
				//error_log("Survey : question $guid = $question->title => " . print_r($response, true));
				if (!isset($this->responses_by_question[$guid]["{$response->owner_guid}"])) { $this->responses_by_question[$guid]["{$response->owner_guid}"] = 0; }
				// Cache the amount of results (members who responded) for each question
				$this->responses_by_question[$guid]["{$response->owner_guid}"]++;
				
				// Cache the amount of results for each choice, for each question
				if (!isset($this->responses_by_question_choice[$guid][$response->value])) { $this->responses_by_question_choice[$guid][$response->value] = 0; }
				$this->responses_by_question_choice[$guid][$response->value]++;
			}
			
		}
	}
	*/
	
	
	
	/** Get response values for the given question
	 *
	 * @param string $question
	 * @return array Values => count
	 */
	/*
	public function getValuesForQuestion($question) {
		$values = array();
		// Make sure the values have been populated
		//$this->fetchResponses();
		// @TODO add count stats for question values
		
		$responses = new ElggBatch('elgg_get_annotations', array('guid' => $question->guid, 'annotation_name' => 'response', 'limit' => 0));
		
		if (in_array($question->input_type, array('text', 'plaintext', 'longtext', 'date'))) {
			// Free text or value
			foreach($responses as $response) {
				$values[] = $response->value;
			}
		} else {
			// Closed list values
			// @TODO clean option list (add function for that)
			//$question->options
			// @TODO add empty value
			//$question->empty_value
			foreach($responses as $response) {
				$values[] = $response->value;
			}
		}
		return $values;
	}
	*/
	
}

