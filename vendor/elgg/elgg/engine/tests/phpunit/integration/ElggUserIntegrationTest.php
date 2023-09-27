<?php

use Elgg\IntegrationTestCase;

/**
 * @group IntegrationTests
 * @group Users
 * @group ElggUser
 */
class ElggUserIntegrationTest extends IntegrationTestCase {

	/**
	 * @var \ElggUser User during tests
	 */
	protected $user;
	
	/**
	 * @dataProvider correctAdminBannedValues
	 */
	public function testSetCorrectBannedValue($value, $boolean_value) {
		$user = $this->user = $this->createUser();
		
		elgg_call(ELGG_IGNORE_ACCESS, function () use ($user, $value) {
			if ($value === 'yes') {
				$user->ban();
			} else {
				$user->unban();
			}
		});
		
		$this->assertEquals($value, $user->banned);
		$this->assertEquals($boolean_value, $user->isBanned());
	}
	
	/**
	 * @dataProvider correctAdminBannedValues
	 */
	public function testSetCorrectAdminValue($value, $boolean_value) {
		$user = $this->user = $this->createUser();
		
		if ($value === 'yes') {
			$user->makeAdmin();
		} else {
			$user->removeAdmin();
		}
		
		$this->assertEquals($value, $user->admin);
		$this->assertEquals($boolean_value, $user->isAdmin());
	}
	
	public function correctAdminBannedValues() {
		return [
			['no', false],
			['yes', true],
		];
	}
	
	public function testSetValidationStatus() {
		$validate_event = $this->registerTestingEvent('validate:after', 'user', function(\Elgg\Event $event) {});
		$invalidate_event = $this->registerTestingEvent('invalidate:after', 'user', function(\Elgg\Event $event) {});
		
		$name = $this->faker()->name;
		$username = $this->getRandomUsername($name);
		
		$user = $this->user = elgg_register_user([
			'username' => $username,
			'password' => elgg_generate_password(),
			'name' => $name,
			'email' => $this->getRandomEmail($username),
			'validated' => false,
		]);
		
		$validate_event->assertNumberOfCalls(0);
		$invalidate_event->assertNumberOfCalls(0);
		
		$this->assertEmpty($user->validated);
		$this->assertEmpty($user->validated_method);
		$this->assertEmpty($user->validated_ts);
		$this->assertNull($user->isValidated());
		
		$user->setValidationStatus(false);
		$validate_event->assertNumberOfCalls(0);
		$invalidate_event->assertNumberOfCalls(1);
		
		$this->assertEmpty($user->validated);
		$this->assertEmpty($user->validated_method);
		$this->assertEmpty($user->validated_ts);
		$this->assertFalse($user->isValidated());
		
		$user->setValidationStatus(true, 'testing_validation');
		$validate_event->assertNumberOfCalls(1);
		$invalidate_event->assertNumberOfCalls(1);
		
		$this->assertNotEmpty($user->validated);
		$this->assertTrue($user->isValidated());

		$this->assertEquals('testing_validation', $user->validated_method);
		$this->assertNotEmpty($user->validated_ts);
		
		$user->setValidationStatus(false);
		$validate_event->assertNumberOfCalls(1);
		$invalidate_event->assertNumberOfCalls(2);
		
		$this->assertEmpty($user->validated);
		$this->assertEmpty($user->validated_method);
		$this->assertEmpty($user->validated_ts);
		$this->assertFalse($user->isValidated());
	}
}
