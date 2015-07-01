<?php
/**
 * Extended class to override the time_created
 * 
 * @property string $status      The published status of the transitions post (published, draft)
 * @property string $comments_on Whether commenting is allowed (Off, On)
 * @property string $excerpt     An excerpt of the transitions post used when displaying the post
 */
class ElggTransitions extends ElggObject {

	/**
	 * Set subtype to transitions.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "transitions";
	}

	/**
	 * Can a user comment on this transitions?
	 *
	 * @see ElggObject::canComment()
	 *
	 * @param int $user_guid User guid (default is logged in user)
	 * @return bool
	 * @since 1.8.0
	 */
	public function canComment($user_guid = 0) {
		$result = parent::canComment($user_guid);
		if ($result == false) {
			return $result;
		}

		if ($this->comments_on == 'Off') {
			return false;
		}
		
		return true;
	}

	/**
	 * Get the excerpt for this transitions post
	 * 
	 * @param int $length Length of the excerpt (optional)
	 * @return string
	 * @since 1.9.0
	 */
	public function getExcerpt($length = 250) {
		if ($this->excerpt) {
			return $this->excerpt;
		} else {
			return elgg_get_excerpt($this->description, $length);
		}
	}

}
