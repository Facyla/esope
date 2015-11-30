<?php
/**
 * Class that represents an object of subtype ElggDataviz
 * @TODO : WIP - need to determine if we actually store data, or rather datavisualisaiton configuraiton (seems better)
 */
class ElggDataviz extends ElggObject {
	const SUBTYPE = "dataviz";
	
	/** @var array $responses Cache for number of responders for each question */
	//private $responses_by_question = array();
	
	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	// Return language-aware labels (if translation keys set)
	public function getLabels() {
		$labels = $this->labels;
		foreach ($labels as $label) {
			$tr_label = elgg_echo("elgg_dataviz:label:$label");
			if ($tr_label == "elgg_dataviz:label:$label") { $tr_label = $label; }
			$translated_labels[$label] = $tr_label;
		}
		return $translated_labels;
	}
	
	// Return all raw data
	public function getData() {
		return unserialize($this->data)
	}
	
	// Return a given serie
	public function getSerie($name) {
		$data = $this->getData();
		return $data[$name];
	}
	
	
}

