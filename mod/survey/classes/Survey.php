<?php
/**
 * Class that represents an object of subtype survey
 */
class Survey extends ElggObject {
	const SUBTYPE = "survey";

	/** @var array $responses Cache for number of responders for each question */
	private $responses_by_question = array();

	/** @var array $responses Cache for number of responses for each choice (per question) */
	private $responses_by_question_choice = array();

	/** @var int $response_count Total amount of responses */
	private $response_count = 0;

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}

	/** Check whether the user has responded in this survey
	 *
	 * @param ElggUser $user
	 * @return boolean
	 */
	public function hasResponded($user) {
		$responses = elgg_get_annotations(array(
			'guid' => $this->guid,
			'type' => "object", 'subtype' => "survey",
			'annotation_name' => "response", 'annotation_owner_guid' => $user->guid,
			'limit' => 1
		));
		if ($responses) { return true; } else { return false; }
	}
	
	
	/** Get questions objects
	 *
	 * @return ElggObject[] $questions
	 */
	public function getQuestions() {
		/* Elgg 1.10
		$questions = $this->getEntitiesFromRelationship(array(
			//'type' => 'object', 'subtype' => 'survey_question', 
			'relationship' => 'survey_question', 'inverse_relationship' => true,
			//'order_by_metadata' => array('name' => 'display_order', 'direction' => 'ASC'),
		));
		*/
		//$questions = $this->getEntitiesFromRelationship('survey_question', true, 0);
		$questions_ent = elgg_get_entities_from_relationship(array(
				'relationship' => 'survey_question', 'relationship_guid' => $this->guid, 'inverse_relationship' => true,
				'order_by_metadata' => array('name' => 'display_order', 'direction' => 'ASC'),
				'limit' => 0,
			));
		$questions = array();
		// Sort by display_order (because otherwise we would get 20 after 100 : 1, 10, 11, 2, 3, etc.)
		if ($questions_ent) {
			foreach ($questions_ent as $question) {
				$questions[$question->display_order] = $question;
			}
			ksort($questions);
		}
		
		return $questions;
	}

	/** Get all questions, indexed by their GUID */
	public function getQuestionsGuids() {
		$guids = array();
		foreach ($this->getQuestions() as $question) { $guids[$question->guid] = $question; }
		return $guids;
	}

	/** Delete all questions associated with this survey */
	public function deleteQuestions() {
		foreach ($this->getQuestions() as $question) { $question->delete(); }
	}

	/** Adds or updates survey questions
	 *
	 * @param array $questions
	 */
	public function setQuestions(array $questions) {
		if (empty($questions)) { return false; }
		
		// Note : we will not batch delete questions blindly, but rather update existing questions, and delete only removed ones
		//$this->deleteQuestions();
		$new_questions = array();
		$old_questions = $this->getQuestionsGuids();
		
		// Process new questions
		$i = 0;
		foreach ($questions as $question) {
			$i++;
			$survey_question = get_entity($question['guid']);
			// Load and edit existing question, if any
			if (!elgg_instanceof($survey_question, 'object', 'survey_question')) { $survey_question = false; }
			
			// Create entity if invalid or does not exist yet
			if (!$survey_question) {
				$survey_question = new ElggObject();
				$survey_question->owner_guid = $this->owner_guid;
				$survey_question->container_guid = $this->container_guid;
				$survey_question->subtype = "survey_question";
			}
			
			// Question object meta : title, description, input_type, options, empty_value, required
			$survey_question->title = $question['title'];
			$survey_question->description = $question['description'];
			$survey_question->input_type = $question['input_type'];
			$survey_question->options = $question['options'];
			$survey_question->empty_value = $question['empty_value'];
			$survey_question->required = $question['required'];
			
			$survey_question->display_order = $i*10;
			$survey_question->access_id = $this->access_id;
			$survey_question->save();
			
			// Link to survey
			add_entity_relationship($survey_question->guid, 'survey_question', $this->guid);
			// Add to "new questions" list
			$new_questions[] = $survey_question->guid;
		}
		
		// Now clean removed questions
		foreach ($old_questions as $guid => $survey_question) {
			if (!in_array($guid, $new_questions)) {
				$survey_question->delete();
				//error_log("Remove OLD question $guid => {$survey_question->title}");
			}
		}
	}



	/**
	 * Is the survey open for new responses?
	 *
	 * @return boolean
	 */
	public function isOpen() {
		// There is no closing date so this survey is always open
		if (empty($this->close_date)) { return true; }
		$now = time();
		// input/date saves beginning of day and we want to include closing date day in survey
		$deadline = $this->close_date + 86400;
		return $deadline > $now;
	}


	// @TODO : attention à modifier la logique de comptage pour permettre d'inclure les questions, ayant elle-même diverses options et réponses
	
	/**
	 * Fetch and cache amount of responses (users who responded) for each question
	 *
	 * Caches the data in form:
	 *     array(
	 *         'question GUID 1' => 5,
	 *         'question GUID 2' => 13,
	 *         'question GUID 3' => 2,
	 *     )
	 */
	private function fetchResponses() {
		if ($this->responses_by_question) { return; }
		
		// Make sure questions without responses are included in the result
		foreach ($this->getQuestions() as $question) {
			$guid = $question->guid;
			$this->responses_by_question[$guid] = array();
			
			// Get responses count for each question
			/* Does not work as expected
			$responses_count = $question->countAnnotations('response');
			$this->responses_by_question[$guid] = $responses_count;
			*/
			
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
	
	/** Get total amount of responses
	 * @todo Save the total amount as survey metadata in the voting action
	 * @return int
	 */
	public function getResponseCount() {
		// Update responses count
		$count = $this->countAnnotations('response');
		// Cache the total amount of responses
		$this->response_count = $count;
		return $this->response_count;
	}
	
	/** Get amount of responses for the given question
	 *
	 * @param string $question
	 * @return int Response count
	 */
	public function getResponseCountForQuestion($question) {
		// Make sure the values have been populated
		$this->fetchResponses();
		return sizeof($this->responses_by_question[$question->guid]);
	}
	
	
	/** Get GUID of responders for the survey
	 *
	 * @return array Users GUIDs
	 */
	public function getResponders() {
		// Make sure the values have been populated
		$guids = array();
		$responses = $this->getAnnotations('response', 0);
		foreach($responses as $annotation) { $guids[] = $annotation->owner_guid; }
		return $guids;
	}
	
	/** Get GUID of responders for the given question
	 *
	 * @param string $question
	 * @return array Users GUIDs
	 */
	public function getRespondersForQuestion($question) {
		// Make sure the values have been populated
		$this->fetchResponses();
		$guids = array();
		foreach($this->responses_by_question[$question->guid] as $guid => $val) { $guids[] = $guid; }
		return $guids;
	}
	
	/** Get response values for the given question
	 *
	 * @param string $question
	 * @return array Values => count
	 */
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
	
}

