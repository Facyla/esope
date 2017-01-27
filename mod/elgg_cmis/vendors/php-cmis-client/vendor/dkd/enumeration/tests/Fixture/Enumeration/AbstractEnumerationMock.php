<?php
namespace Dkd\Enumeration\Tests\Fixture\Enumeration;

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

/**
 * Abstract mock that implements some basic helper functions
 */
abstract class AbstractEnumerationMock extends \Dkd\Enumeration\Enumeration
{
    /**
     * Get a static class property.
     *
     * @param string $propertyName The name of the property
     * @return mixed The property content
     */
    public function _getStatic($propertyName)
    {
        if (empty($propertyName)) {
            throw new \InvalidArgumentException('$propertyName must not be empty.');
        }
        return self::$$propertyName;
    }

    /**
     * Set a static class property to the given value.
     *
     * @param string $propertyName the name of the property
     * @param $value The value that should be assigned to the property
     */
    public function _setStatic($propertyName, $value)
    {
        if (empty($propertyName)) {
            throw new \InvalidArgumentException('$propertyName must not be empty.');
        }
        self::$$propertyName = $value;
    }

    /**
     * Set a property to the given value. This adds the possibility to set protected properties from the outside.
     *
     * @param string $propertyName the name of the property
     * @param $value mixed The value that should be assigned to the property
     */
    public function _set($propertyName, $value)
    {
        if (empty($propertyName)) {
            throw new \InvalidArgumentException('$propertyName must not be empty.');
        }
        $this->$propertyName = $value;
    }

    /**
     * Get a class property. This adds the possibility to get protected properties from the outside.
     *
     * @param string $propertyName the name of the property
     * @return mixed The value of the property
     */
    public function _get($propertyName)
    {
        if (empty($propertyName)) {
            throw new \InvalidArgumentException('$propertyName must not be empty.');
        }
        return $this->$propertyName;
    }

    /**
     * Calls the method with the given method name. This is used to call protected methods from the outside.
     *
     * @param string $methodName The name of the method that should be called.
     * @return mixed returns the method return value
     */
    public function _call($methodName)
    {
        if (empty($methodName)) {
            throw new \InvalidArgumentException('$methodName must not be empty.');
        }
        $args = func_get_args();
        return call_user_func_array(array($this, $methodName), array_slice($args, 1));
    }
}
