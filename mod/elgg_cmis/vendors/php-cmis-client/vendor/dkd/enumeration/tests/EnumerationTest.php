<?php
namespace Dkd\Enumeration\Tests;

/**
 * This file is part of the dkd\enumeration package.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use \Dkd\Enumeration\Tests\Fixture\Enumeration;

/**
 * Test case
 */
class EnumerationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationValueException
     */
    public function constructorThrowsExceptionIfNoConstantsAreDefined()
    {
        new Enumeration\MissingConstantsEnumeration();
    }

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationValueException
     */
    public function constructorThrowsExceptionIfInvalidValueIsRequested()
    {
        new Enumeration\CompleteEnumeration('bar');
    }

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationValueException
     */
    public function loadValuesThrowsExceptionIfGivenValueIsNotAvailableInEnumeration()
    {
        new Enumeration\MissingConstantsEnumeration(2);
    }

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationDefinitionException
     */
    public function loadValuesThrowsExceptionIfDisallowedTypeIsDefinedAsConstant()
    {
        new Enumeration\InvalidConstantEnumeration(1);
    }

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationValueException
     */
    public function loadValuesThrowsExceptionIfNoDefaultConstantIsDefinedAndNoValueIsGiven()
    {
        new Enumeration\MissingDefaultEnumeration();
    }

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationDefinitionException
     */
    public function loadValuesThrowsExceptionIfValueIsDefinedMultipleTimes()
    {
        new Enumeration\DuplicateConstantValueEnumeration(1);
    }

    /**
     * @test
     */
    public function loadValuesSetsStaticEnumConstants()
    {
        $enumeration = new Fixture\Enumeration\CompleteEnumeration;
        $enumClassName = get_class($enumeration);
        $expectedValue = array(
            'INTEGER_VALUE' => 1,
            'STRING_VALUE' => 'foo',
            '__DEFAULT' => 1
        );
        $result = $enumeration->_getStatic('enumConstants');
        $this->assertArrayHasKey($enumClassName, $result);
        $this->assertSame($expectedValue, $result[$enumClassName]);
    }

    /**
     * @test
     */
    public function constructorSetsValue()
    {
        $enumeration = new Fixture\Enumeration\CompleteEnumeration(1);
        $this->assertEquals(1, $enumeration->_get('value'));
    }

    /**
     * @test
     */
    public function setValueSetsValue()
    {
        $enumeration = new Fixture\Enumeration\CompleteEnumeration(1);
        $enumeration->_call('setValue', 'foo');
        $this->assertEquals('foo', $enumeration->_get('value'));
    }

    /**
     * @test
     * @expectedException \Dkd\Enumeration\Exception\InvalidEnumerationValueException
     */
    public function setValueToAnInvalidValueThrowsException()
    {
        $enumeration = new Fixture\Enumeration\CompleteEnumeration(1);
        $enumeration->_call('setValue', 2);
        $this->assertEquals(2, $enumeration->_get('value'));
    }

    /**
     * Array of value pairs and expected comparison result
     */
    public function isValidComparisonExpectations()
    {
        return array(
            array(
                1,
                1,
                true
            ),
            array(
                1,
                '1',
                true
            ),
            array(
                '1',
                1,
                true
            ),
            array(
                'a1',
                1,
                false
            ),
            array(
                1,
                'a1',
                false
            ),
            array(
                '1a',
                1,
                false
            ),
            array(
                1,
                '1a',
                false
            ),
            array(
                'foo',
                'foo',
                true
            ),
            array(
                'foo',
                'bar',
                false
            ),
            array(
                'foo',
                'foobar',
                false
            )
        );
    }

    /**
     * @test
     * @dataProvider isValidComparisonExpectations
     */
    public function isValidDoesTypeLooseComparison($enumerationValue, $testValue, $expectation)
    {
        $mockName = uniqid('CompleteEnumerationMock');
        /** @var Fixture\Enumeration\CompleteEnumeration|\PHPUnit_Framework_MockObject_MockObject $enumeration */
        $enumeration = $this->getMock(
            '\\Dkd\\Enumeration\\Tests\\Fixture\\Enumeration\\CompleteEnumeration',
            array('dummy'),
            array(),
            $mockName,
            false
        );
        $enumeration->_setStatic('enumConstants', array($mockName => array('CONSTANT_NAME' => $enumerationValue)));
        $enumeration->_set('value', $enumerationValue);
        $this->assertSame($expectation, $enumeration->_call('isValid', $testValue));
    }

    /**
     * @test
     */
    public function getConstantsReturnsArrayOfPossibleValuesWithoutDefault()
    {
        $enumeration = new Enumeration\CompleteEnumeration();
        $this->assertEquals(array('INTEGER_VALUE' => 1, 'STRING_VALUE' => 'foo'), $enumeration::getConstants());
    }

    /**
     * @test
     */
    public function getConstantsReturnsArrayOfPossibleValuesWithDefaultIfRequested()
    {
        $enumeration = new Enumeration\CompleteEnumeration();
        $this->assertEquals(
            array('INTEGER_VALUE' => 1, 'STRING_VALUE' => 'foo', '__DEFAULT' => 1),
            $enumeration::getConstants(true)
        );
    }

    /**
     * @test
     */
    public function toStringReturnsValueAsString()
    {
        $enumeration = new Enumeration\CompleteEnumeration();
        $this->assertSame('1', $enumeration->__toString());
    }

    /**
     * @test
     */
    public function castReturnsObjectOfEnumerationTypeIfSimpleValueIsGiven()
    {
        $enumeration = Enumeration\CompleteEnumeration::cast(1);
        $this->assertInstanceOf('\\Dkd\\Enumeration\\Tests\\Fixture\\Enumeration\\CompleteEnumeration', $enumeration);
    }

    /**
     * @test
     */
    public function castReturnsObjectOfCalledEnumerationTypeIfCalledWithValueOfDifferentType()
    {
        $initialEnumeration = new Enumeration\MissingDefaultEnumeration(1);
        $enumeration = Enumeration\CompleteEnumeration::cast($initialEnumeration);
        $this->assertInstanceOf('\\Dkd\\Enumeration\\Tests\\Fixture\\Enumeration\\CompleteEnumeration', $enumeration);
    }

    /**
     * @test
     */
    public function castReturnsGivenObjectIfCalledWithValueOfSameType()
    {
        $initialEnumeration = new Enumeration\CompleteEnumeration(1);
        $enumeration = Enumeration\CompleteEnumeration::cast($initialEnumeration);
        $this->assertSame($initialEnumeration, $enumeration);
    }

    /**
     * @test
     */
    public function castCastsStringToEnumerationWithCorrespondingValue()
    {
        $enumeration = new Enumeration\CompleteEnumeration(1);
        $this->assertSame(1, $enumeration->_get('value'));
    }

    /**
     * @test
     */
    public function castCastsIntegerToEnumerationWithCorrespondingValue()
    {
        $enumeration = new Enumeration\CompleteEnumeration(1);
        $this->assertSame(1, $enumeration->_get('value'));
    }

    /**
     * @test
     */
    public function equalsReturnsTrueIfIntegerIsGivenThatEqualsEnumerationsIntegerValue()
    {
        $enumeration = new Enumeration\CompleteEnumeration(1);
        $this->assertTrue($enumeration->equals(1));
    }

    /**
     * @test
     */
    public function equalsReturnsTrueIfStringIsGivenThatEqualsEnumerationsIntegerValue()
    {
        $enumeration = new Enumeration\CompleteEnumeration(1);
        $this->assertTrue($enumeration->equals('1'));
    }

    /**
     * @test
     */
    public function equalsReturnsTrueIfEqualEnumerationIsGiven()
    {
        $enumerationFoo = new Enumeration\CompleteEnumeration(1);
        $enumerationBar = new Enumeration\CompleteEnumeration(1);
        $this->assertTrue($enumerationFoo->equals($enumerationBar));
    }

    /**
     * @test
     */
    public function equalsReturnsTrueIfDifferentEnumerationWithSameValueIsGiven()
    {
        $enumerationFoo = new Enumeration\CompleteEnumeration(1);
        $enumerationBar = new Enumeration\MissingDefaultEnumeration(1);
        $this->assertTrue($enumerationFoo->equals($enumerationBar));
    }

    /**
     * @test
     */
    public function equalsReturnsFalseIfDifferentEnumerationWithDifferentValueIsGiven()
    {
        $enumerationFoo = new Enumeration\CompleteEnumeration('foo');
        $enumerationBar = new Enumeration\MissingDefaultEnumeration(1);
        $this->assertFalse($enumerationFoo->equals($enumerationBar));
    }

    /**
     * @test
     */
    public function equalsReturnsFalseIfEnumerationOfSameTypeWithDifferentValueIsGiven()
    {
        $enumerationFoo = new Enumeration\CompleteEnumeration(1);
        $enumerationBar = new Enumeration\CompleteEnumeration('foo');
        $this->assertFalse($enumerationFoo->equals($enumerationBar));
    }
}
