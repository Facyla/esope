<?php

namespace Elgg;

use Elgg\Exceptions\InvalidArgumentException;

/**
 * System messages service
 *
 * Use elgg()->system_messages
 *
 * @since 1.11.0
 */
class SystemMessagesService {

	const SUCCESS = 'success';
	const ERROR = 'error';
	const SESSION_KEY = '_elgg_msgs';

	/**
	 * @var \ElggSession
	 */
	protected $session;

	/**
	 * Constructor
	 *
	 * @param \ElggSession $session The Elgg session
	 */
	public function __construct(\ElggSession $session) {
		$this->session = $session;
	}

	/**
	 * Empty and return the given register or all registers. In each case, the return value is
	 * a filtered version of the full registers array.
	 *
	 * @param string $register_name The register. Empty string for all.
	 *
	 * @return array The array of registers dumped
	 * @internal
	 */
	public function dumpRegister(string $register_name = ''): array {
		$set = $this->loadRegisters();
		$return = [];

		foreach ($set as $prop => $values) {
			if ($register_name === $prop || $register_name === '') {
				if ($values || $register_name === $prop) {
					$return[$prop] = $values;
				}

				$set[$prop] = [];
			}
		}

		// support arbitrary registers for 2.0 BC
		if ($register_name && !isset($return[$register_name])) {
			$return[$register_name] = [];
		}

		$this->saveRegisters($set);
		return $return;
	}

	/**
	 * Counts the number of messages, either globally or in a particular register
	 *
	 * @param string $register_name Optionally, the register
	 *
	 * @return integer The number of messages
	 */
	public function count(string $register_name = ''): int {
		$set = $this->loadRegisters();
		$count = 0;

		foreach ($set as $prop => $values) {
			if ($register_name === $prop || $register_name === '') {
				$count += count($values);
			}
		}

		return $count;
	}

	/**
	 * Display a system message on next page load.
	 *
	 * @param string $message Message or messages to add
	 *
	 * @return void
	 */
	public function addSuccessMessage(string $message): void {
		$this->addMessage(new \ElggSystemMessage($message, 'success'));
	}

	/**
	 * Display an error on next page load.
	 *
	 * @param string $message Error or errors to add
	 *
	 * @return void
	 */
	public function addErrorMessage(string $message): void {
		$this->addMessage(new \ElggSystemMessage($message, 'error'));
	}

	/**
	 * Adds a message to the registry
	 *
	 * @param \ElggSystemMessage|array $message Error or errors to add
	 *
	 * @see \ElggSystemMessage::factory()
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *
	 * @since 4.2.0
	 */
	public function addMessage($message): void {
		if (is_array($message)) {
			$message = \ElggSystemMessage::factory($message);
		}
		
		if (!$message instanceof \ElggSystemMessage) {
			throw new InvalidArgumentException(__METHOD__ . ' $message needs to be an \ElggSystemMessage or an array of options');
		}
		
		$set = $this->loadRegisters();
		$set[$message->getType()][] = $message;
		$this->saveRegisters($set);
	}

	/**
	 * Load the registers from the session
	 *
	 * @return array
	 */
	public function loadRegisters(): array {
		return $this->session->get(self::SESSION_KEY, []);
	}

	/**
	 * Save the registers to the session
	 *
	 * The method of displaying these messages differs depending upon plugins and
	 * viewtypes.  The core default viewtype retrieves messages in
	 * {@link views/default/page/shells/default.php} and displays messages as
	 * javascript popups.
	 *
	 * Messages are stored as strings in the Elgg session as ['msg'][$register] array.
	 *
	 * @param array $set The set of registers
	 * @return void
	 */
	public function saveRegisters(array $set): void {
		$filter = function ($el) {
			return ($el instanceof \ElggSystemMessage) && $el->getMessage() !== '';
		};

		$data = [];
		foreach ($set as $prop => $values) {
			if (!is_array($values)) {
				continue;
			}
			
			$arr = array_filter($values, $filter);
			if (!empty($arr)) {
				$data[$prop] = array_values($arr);
			}
		}

		$this->session->set(self::SESSION_KEY, $data);
	}
}
