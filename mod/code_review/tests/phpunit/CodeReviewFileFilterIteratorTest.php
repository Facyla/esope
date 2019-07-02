<?php
namespace CodeReview\Tests;

class CodeReviewFileFilterIteratorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests normal operation
	 */
	public function testIteratingOverFiles() {

		$paths = array(
			array(dirname(__FILE__) . '/test_files/fake_elgg/', false),
			array(dirname(__FILE__) . '/test_files/fake_elgg' . DIRECTORY_SEPARATOR, false),
			array(dirname(__FILE__) . '/test_files/fake_elgg', false),
		);
		foreach ($paths as $row) {
			list($path, $skipInactive) = $row;

			$config = new \CodeReview\Config(array(
				'includeDisabledPlugins' => !$skipInactive,
			));

			$baseFileInfo = new \SplFileInfo($path);
			$i = new \RecursiveDirectoryIterator($path);
			$i = new \RecursiveIteratorIterator($i, \RecursiveIteratorIterator::LEAVES_ONLY);
			$i = new \CodeReview\FileFilterIterator($i, $path, $config);

			$filesFound = array();
			/** @var $file \SplFileInfo */
			foreach ($i as $file) {
				$this->assertInstanceOf('\SplFileInfo', $file);
				$this->assertNotEquals('.dummy_config', $file->getBasename());
				$entry = substr($file->getRealPath(), strlen($path));
				if ($entry) {
					$entry = trim(str_replace('\\', '/', $entry), '/');
					$filesFound[] = $entry;
				} else {
					//we allow only root dir as exception
					$this->assertEquals($baseFileInfo->getInode(), $file->getInode());
				}
			}
			$expected = array(
				'engine/lib/deprecated-1.2.php',
				'not_filtered_file',
				'mod/inactive_plugin/start.php',
				'mod/inactive_plugin/manifest.xml',
				'mod/ugly_plugin/start.php',
				'mod/ugly_plugin/pages/page17.php',
				'mod/ugly_plugin/manifest.xml',
//				'mod/ugly_plugin',//FIXME fails on PHP 5.2.17
			);
			$missingFiles = array_diff($expected, $filesFound);
			$this->assertEquals($missingFiles, array(), "Missing expected files: " . print_r($missingFiles, true));

			$unexpected = array(
				'.dummy_config',
				'vendor/unwanted_file',
				'vendors/unwanted_file',
			);
			$unwantedFiles = array_intersect($unexpected, $filesFound);
			$this->assertEquals($unwantedFiles, array(), "Got some unwanted files: " . print_r($unwantedFiles, true));
		}
	}

	public function mocked_plugins_getter() {
		return array(
			'ugly_plugin'
		);
	}

	/**
	 * Tests normal operation
	 *
	 * @requires PHP 5.3
	 */
	public function testIteratingOverFilesFilteringIncactive() {

		$path = dirname(__FILE__) . '/test_files/fake_elgg/';

		require_once($path . 'engine/start.php');

		\code_review::initConfig(array(
			'path' => $path,
			'engine_path' => $path . 'engine/',
			'pluginspath' => $path . 'mod/',
			'plugins_getter' => array($this, 'mocked_plugins_getter'),
		));

		$paths = array(
			array(dirname(__FILE__) . '/test_files/fake_elgg/', true),
			array(dirname(__FILE__) . '/test_files/fake_elgg' . DIRECTORY_SEPARATOR, true),
			array(dirname(__FILE__) . '/test_files/fake_elgg', true),
		);
		foreach ($paths as $row) {
			list($path, $skipInactive) = $row;

			$config = new \CodeReview\Config(array(
				'includeDisabledPlugins' => !$skipInactive,
			));

			$baseFileInfo = new \SplFileInfo($path);
			$i = new \RecursiveDirectoryIterator($path);
			$i = new \RecursiveIteratorIterator($i, \RecursiveIteratorIterator::LEAVES_ONLY);
			$i = new \CodeReview\FileFilterIterator($i, $path, $config);

			$filesFound = array();
			/** @var $file \SplFileInfo */
			foreach ($i as $file) {
				$this->assertInstanceOf('\SplFileInfo', $file);
				$this->assertNotEquals('.dummy_config', $file->getBasename());
				$entry = substr($file->getRealPath(), strlen($path));
				if ($entry) {
					$entry = trim(str_replace('\\', '/', $entry), '/');
					$filesFound[] = $entry;
				} else {
					//we allow only root dir as exception
					$this->assertEquals($baseFileInfo->getInode(), $file->getInode());
				}
			}
			$expected = array(
				'engine/lib/deprecated-1.2.php',
				'not_filtered_file',
				'mod/ugly_plugin/start.php',
				'mod/ugly_plugin/pages/page17.php',
				'mod/ugly_plugin/manifest.xml',
//				'mod/ugly_plugin',//FIXME fails on PHP 5.2.17
			);
			$missingFiles = array_diff($expected, $filesFound);
			$this->assertEquals($missingFiles, array(), "Missing expected files: " . print_r($missingFiles, true));

			$unexpected = array(
				'.dummy_config',
				'mod/inactive_plugin/start.php',
				'mod/inactive_plugin/manifest.xml',
				'vendor/unwanted_file',
				'vendors/unwanted_file',
			);
			$unwantedFiles = array_intersect($unexpected, $filesFound);
			$this->assertEquals($unwantedFiles, array(), "Got some unwanted files: " . print_r($unwantedFiles, true));
		}
	}

	/**
	 * Passing not existing base dir parameter
	 */
	public function testNonExistingPath() {
		$config = new \CodeReview\Config();
		$path = dirname(__FILE__) . '/test_files/fake_elgg/';
		$bad_path = dirname(__FILE__) . '/test_files/non_existing_path/';
		$i = new \RecursiveDirectoryIterator($path);
		$i = new \RecursiveIteratorIterator($i, \RecursiveIteratorIterator::LEAVES_ONLY);
		$this->setExpectedException('\CodeReview\IOException', "Directory $bad_path does not exists");
		new \CodeReview\FileFilterIterator($i, $bad_path, $config);
	}

}