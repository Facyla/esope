<?php
/**
 * Class that represents an object of subtype survey
 */
class Survey extends ElggObject {
	const SUBTYPE = "survey";

	/**
	 * @var array $responses Cache for number of responses for each voting choice
	 */
	private $responses_by_choice = array();

	/**
	 * @var int $response_count Total amount of responses
	 */
	private $response_count = 0;

	/**
	 * Set subtype
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = $this::SUBTYPE;
	}

	/**
	 * Check whether the user has responded in this survey
	 *
	 * @param ElggUser $user
	 * @return boolean
	 */
	public function hasResponded($user) {
		$responses = elgg_get_annotations(array(
			'guid' => $this->guid,
			'type' => "object",
			'subtype' => "survey",
			'annotation_name' => "response",
			'annotation_owner_guid' => $user->guid,
			'limit' => 1
		));

		if ($responses) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get choice objects
	 *
	 * @return ElggObject[] $choices
	 */
	public function getChoices() {
		$choices = $this->getEntitiesFromRelationship(array(
			'relationship' => 'survey_choice',
			'inverse_relationship' => true,
			'order_by_metadata' => array(
				'name' => 'display_order',
				'direction' => 'ASC'
			),
		));
		if (!$choices) { $choices = array(); }
		return $choices;
	}

	/**
	 * Delete all choices associated with this survey
	 */
	public function deleteChoices() {
		foreach ($this->getChoices() as $choice) { $choice->delete(); }
	}

	/**
	 * Adds or updates survey choices
	 *
	 * @param array $choices
	 */
	public function setChoices(array $choices) {
		if (empty($choices)) { return false; }
		$this->deleteChoices();
		$i = 0;
		foreach ($choices as $choice) {
			$survey_choice = new ElggObject();
			$survey_choice->owner_guid = $this->owner_guid;
			$survey_choice->container_guid = $this->container_guid;
			$survey_choice->subtype = "survey_choice";
			$survey_choice->text = $choice;
			$survey_choice->display_order = $i*10;
			$survey_choice->access_id = $this->access_id;
			$survey_choice->save();

			add_entity_relationship($survey_choice->guid, 'survey_choice', $this->guid);
			$i += 1;
		}
	}

	
	// @TODO : duplicate same logic for "questions" instead of questions
	/**
	 * Get questions objects
	 *
	 * @return ElggObject[] $questions
	 */
	public function getQuestions() {
		$questions = $this->getEntitiesFromRelationship(array(
			'relationship' => 'survey_question', 'inverse_relationship' => true,
			'order_by_metadata' => array('name' => 'display_order', 'direction' => 'ASC'),
		));
		if (!$questions) { $questions = array(); }
		return $questions;
	}

	/**
	 * Delete all questions associated with this survey
	 */
	public function deleteQuestions() {
		foreach ($this->getQuestions() as $question) { $question->delete(); }
	}

	/**
	 * Adds or updates survey questions
	 *
	 * @param array $questions
	 */
	public function setQuestions(array $questions) {
		if (empty($questions)) { return false; }
		$this->deleteQuestions();
		$i = 0;
		foreach ($questions as $question) {
			$survey_question = new ElggObject();
			$survey_question->owner_guid = $this->owner_guid;
			$survey_question->container_guid = $this->container_guid;
			$survey_question->subtype = "survey_question";
			
			$survey_question->title = $question; // @TODO
			$survey_question->description = $question; // @TODO
			$survey_question->input_type = $question; // @TODO
			$survey_question->options = $question; // @TODO
			$survey_question->empty_value = $question; // @TODO
			$survey_question->required = $question; // @TODO
			
			$survey_question->display_order = $i*10;
			$survey_question->access_id = $this->access_id;
			$survey_question->save();

			add_entity_relationship($survey_question->guid, 'survey_question', $this->guid);
			$i += 1;
		}
	}



	/**
	 * Is the survey open for new responses?
	 *
	 * @return boolean
	 */
	public function isOpen() {
		if (empty($this->close_date)) {
			// There is no closing date so this survey is always open
			return true;
		}

		$now = time();

		// input/date saves beginning of day and we want to include closing date day in survey
		$deadline = $this->close_date + 86400;

		return $deadline > $now;
	}


	// @TODO : attention à modifier l logique de comptage pour permettre d'inclure les questions, ayant elle-même diverses options et réponses
	
	/**
	 * Fetch and cache amount of responses for each choice
	 *
	 * Caches the data in form:
	 *     array(
	 *         'choice 1' => 5,
	 *         'choice 2' => 13,
	 *         'choice 3' => 2,
	 *     )
	 */
	private function fetchResponses() {
		if ($this->responses_by_choice) {
			return;
		}

		// Make sure choices without responses are included in the result
		foreach ($this->getChoices() as $choice) {
			$this->responses_by_choice[$choice->text] = 0;
		}

		// Get responses
		$responses = new ElggBatch('elgg_get_annotations', array(
			'guid' => $this->guid,
			'annotation_name' => 'response',
			'limit' => false,
		));

		// Cache the amount of results for each choice
		foreach ($responses as $response) {
			$this->responses_by_choice[$response->value] += 1;
		}

		// Cache the total amount of responses
		$this->response_count = array_sum($this->responses_by_choice);
	}

	/**
	 * Get amount of responses for the given choice
	 *
	 * @param string $choice
	 * @return int Response count
	 */
	public function getResponseCountForChoice($choice) {
		// Make sure the values have been populated
		$this->fetchResponses();

		return $this->responses_by_choice[$choice];
	}

	/**
	 * Get total amount of responses
	 *
	 * @todo Save the total amount as survey metadata in the voting action
	 *
	 * @return int
	 */
	public function getResponseCount() {
		// Make sure the values have been populated
		$this->fetchResponses();

		return $this->response_count;
	}
}

