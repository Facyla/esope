<?php

/**
 * upload_users Class.
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @copyright Mediamaisteri Group 2009
 * @link http://www.mediamaisteri.com/
 */
class UploadUsers {

	var $encoding;
	var $delimiter;
	var $notification;
	var $raw_data;
	var $confirmation_report;
	var $creation_report;
	var $headers;
	var $number_of_failed_users = 0;
	var $users_to_confirm = NULL; /// An array containing user info from csv file
	var $users_to_create = NULL; /// An array of users to create

	function __construct() {

	}

	/**
	 * Set encoding of the CSV file
	 *
	 * @param $encoding
	 */
	function setEncoding($encoding) {
		$this->encoding = $encoding;
	}

	/**
	 * Set delimiter of the CSV file
	 *
	 * @param $delimiter
	 */
	function setDelimiter($delimiter) {
		$this->delimiter = $delimiter;
	}

	/**
	 * Set wether to send user accounts on email or not
	 *
	 * @param $notification boolean
	 */
	function setNotification($notification) {
		$this->notification = $notification;
	}

	/**
	 * Process the file
	 *
	 * @param $file
	 * @return boolean
	 */
	function openFile($file) {
		if (!$contents = get_uploaded_file($file)) {
			register_error(elgg_echo('upload_users:error:cannot_open_file'));
			return false;
		}

		/// Check the encoding
		if ($this->encoding == 'ISO-8859-1') {
			$contents = utf8_encode($contents);
		}

		$this->raw_data = $contents;
		return true;
	}

	/**
	 * Process user accounts from the raw data from the file
	 *
	 * @param $data
	 * @return boolean
	 */
	function processFile() {
		/// Turn the string into an array
		$rows = explode("\n", $this->raw_data);

		/// First row includes headers
		$headers = $rows[0];
		$headers = explode($this->delimiter, $headers);

		/// Trim spaces from $headers
		$headers = array_map('trim', $headers);

		/// Check that there are no empty headers. This can happen if there are delimiters at the end of the file
		foreach ($headers as $header) {
			if (!empty($header)) {
				$headers2[] = $header;
			}
		}
		$headers = $headers2;

		if (!in_array('password', $headers)) {
			/// Add password column for generated passwords
			$headers[] = 'password';
		}
		/// Add status column to the headers
		$headers[] = 'status';


		$this->headers = $headers;

		/// Check that at least username, name and email are provided in the headers
		if (!in_array('username', $headers) ||
				!in_array('name', $headers) ||
				!in_array('email', $headers)) {
			register_error(elgg_echo('upload_users:error:wrong_csv_format'));
			return false;
		}

		/// Create a nicer array of users for processing
		$users = array();

		/// Go through the user rows
		for ($i = 1; $i < count($rows); $i++) {
			$rows[$i] = trim($rows[$i]);
			if (empty($rows[$i])) {
				continue;
			}
			$user_details = explode($this->delimiter, $rows[$i]);

			$user = array();
			$metadata = array();

			/// Go through user information
			foreach ($user_details as $key => $field) {
				$fieldname = trim($headers[$key]); /// Remove whitespaces
				$field = trim($field);   /// and other garbage.

				if ($fieldname == 'username' ||
						$fieldname == 'name' ||
						$fieldname == 'email' ||
						$fieldname == 'password') {
					$user[$fieldname] = $field;
				} else {
					/// Add all other fields as metadata
					$metadata[$fieldname] = $field;
				}
			}
			$user['metadata'] = $metadata;
			$users[] = $user;
		}

		$this->users_to_confirm = $users;
		return true;
	}

	function checkUsers() {
		global $CONFIG;
		$final_report = array(); /// Final report of the upload process
		/// Check all the users from $users_to_confirm array
		foreach ($this->users_to_confirm as $user) {
			/// CHeck for password or generate a new one
			if (empty($user['password'])) {
				$user['password'] = $this->generatePassword();
			}

			$report = array('username' => $user['username'],
				'password' => $user['password'],
				'name' => $user['name'],
				'email' => $user['email'],
				'status' => '',
				'create_user' => true);

			/// Check if the username has already been registered
			if (get_user_by_username($user['username'])) {
				$report['status'] .= '<span class="error">' . elgg_echo('registration:userexists') . '</span>';
				$report['create_user'] = false;
			}

			/// Check if the email has already been registered
			if (get_user_by_email($user['email'])) {
				$report['status'] .= '<span class="error">' . elgg_echo('registration:dupeemail') . '</span>';
				$report['create_user'] = false;
			}

			/// Check that the email is valid
			try {
				validate_email_address($user['email']);
			} catch (RegistrationException $r) {
				$report['status'] .= ' <span class="error">' . $r->getMessage() . '</span>';
				$report['create_user'] = false;
			}

			/// CHeck for valid password
			try {
				validate_password($user['password']);
			} catch (RegistrationException $r) {
				$report['status'] .= ' <span class="error">' . $r->getMessage() . '</span>';
				$report['create_user'] = false;
			}


			/// Process metadata
			foreach ($user['metadata'] as $key => $metadata) {
				$report[$key] = $metadata;
			}

			/// Add the user to the creation list if we can create the user
			if ($report['status'] == '') {
				$report['status'] = elgg_echo('upload_users:statusok'); /// Set status to ok
				$this->users_to_create[] = $user;
			} else {
				$this->number_of_failed_users++;
			}

			$final_report[] = $report;
		}

		$this->confirmation_report = $final_report;
		return true;
	}

	/**
	 * createUsers Create the users in Elgg
	 *
	 * @return boolean
	 */
	function createUsers($post_data) {
		global $CONFIG;
		$final_report = array(); /// Final report of the creation process

		foreach ($post_data['header'] as $header => $mapping) {
			$metadata_name = $mapping['mapping'];
			if ($metadata_name == 'custom') {
				$metadata_name = $mapping['custom'];
			}
			$mapped_headers[$header] = $metadata_name;
		}
		$this->headers = $mapped_headers;

		/// Create the users from the $users array
		for ($i = 0; $i < $post_data['num_of_users']; $i++) {
			$user = array();
			/// Get the user details from POST data for all headers

			foreach ($this->headers as $header => $metadata_name) {
				if ($value = $post_data[$header][$i]) {
					$user[$metadata_name] = $value;
				} else {
					unset($user[$metadata_name]);
				}
			}


			/// Add the basic fields to the report
			$report = array('username' => $user['username'],
				'password' => $user['password'],
				'name' => $user['name'],
				'email' => $user['email']);

			/// Try to create the user
			try {

				if ($guid = register_user($user['username'], $user['password'], $user['name'], $user['email'])) {
					$new_user = get_entity($guid);

					/// Validate the user.
					set_user_validation_status($guid, true);

					//$new_user->user_role = 'student';
					/// Add all other fields as metadata
					foreach ($this->headers as $header => $metadata_name) {
						switch ($metadata_name) {
							case 'username' :
							case 'password' :
							case 'name' :
							case 'email' :
								continue;
								break;

							default :
								$hook_params = array(
									'header' => $header,
									'metadata_name' => $metadata_name,
									'value' => $user[$metadata_name],
									'user' => $new_user
								);
								if (elgg_trigger_plugin_hook('header:custom_method', 'upload_users', $hook_params, false)) {
									continue;
								}

								/// Metadata could be a comma separated list if the delimiter is something else than a comma
								if ($this->delimiter != ',' && strpos($user[$metadata_name], ',')) {
									/// Multiple tags found
									$tags = string_to_tag_array($user[$metadata_name]);
									foreach ($tags as $tag) {
										create_metadata($guid, $metadata_name, $tag, 'text', $guid, ACCESS_PRIVATE, true);
									}
								} else {
									create_metadata($guid, $metadata_name, $user[$metadata_name], 'text', $guid);
								}
								break;
						}
						/// Add this metadata field to the report
						$report[$metadata_name] = $user[$metadata_name];
					}

					/// Add status message to the report
					$report['status'] = elgg_echo('upload_users:success');

					/// Send an email to the user if this was needed
					if ($this->notification) {
						$subject = sprintf(elgg_echo('upload_users:email:subject'), $CONFIG->sitename);
						$message = sprintf(elgg_echo('upload_users:email:message'), $user['name'], $CONFIG->sitename, $user['username'], $user['password'], $CONFIG->wwwroot);
						notify_user($guid, 1, $subject, $message);
					}
				}
			} catch (RegistrationException $r) {
				//register_error($r->getMessage());
				$report['status'] = '<span class="error">' . $r->getMessage() . '</span>';
				$report['password'] = ''; /// Reset password in failed cases
				$this->number_of_failed_users++;
			}
			$final_report[] = $report;
		}
		$this->creation_report = $final_report;
		return true;
	}

	/**
	 * Get a display friendly status report of the accounts creation
	 *
	 * @return unknown_type
	 */
	public function getCreationReport() {
		$data = array('headers' => $this->headers, 'report' => $this->creation_report, 'num_of_failed' => $this->number_of_failed_users);

		return elgg_view('upload_users/creation_report', $data);
	}

	/**
	 * Get a display friendly status report of the accounts creation
	 *
	 * @return unknown_type
	 */
	public function getConfirmationReport() {
		$data = array('headers' => $this->headers,
			'report' => $this->confirmation_report,
			'num_of_failed' => $this->number_of_failed_users,
			'notification' => $this->notification,
			'delimiter' => $this->delimiter,
			'encoding' => $this->encoding);
		$return = elgg_view('upload_users/confirmation_report', $data);

		return $return;
	}

	/**
	 * A function to generate a new random password
	 *
	 * @param $length Length of the password
	 * @return string
	 */
	private function generatePassword($length = 6) {
		$possible = "ABCDEFGHIJKLMNOPQRSTYWXYZabcdefghijkmnopqrstuvwxyz023456789";

		// start with a blank password
		$password = "";

		// set up a counter
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length) {

			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

			// we don't want this character if it's already in the password
			if (!strstr($password, $char)) {
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}

	/**
	 * Returns the upload form. Uses Elgg view to do this.
	 *
	 * @param $data
	 * @return string
	 */
	function getUploadForm($data = NULL) {
		return elgg_view_form('upload_users/upload', array(
					'enctype' => 'multipart/form-data',
					'method' => 'POST',
					'id' => 'user-upload-admin-form'
						), $data);
	}

}
