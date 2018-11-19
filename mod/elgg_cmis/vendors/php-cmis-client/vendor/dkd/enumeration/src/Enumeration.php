<?php
namespace Dkd\Enumeration;

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
use Dkd\Enumeration\Exception;

/**
 * Abstract class for Enumeration.
 * Inspired by SplEnum.
 *
 * The prefix "Abstract" has been left out by intention because
 * a "type" is abstract by definition.
 */
abstract class Enumeration
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var array
     */
    protected static $enumConstants;

    /**
     * @param mixed $value
     * @throws Exception\InvalidEnumerationValueException
     */
    public function __construct($value = null)
    {
        if ($value === null && !defined('static::__DEFAULT')) {
            throw new Exception\InvalidEnumerationValueException(
                sprintf('A value for %s is required if no __DEFAULT is defined.', get_class($this)),
                1381512753
            );
        }
        if ($value === null) {
            $value = static::__DEFAULT;
        }
        $this->loadValues();
        if (!$this->isValid($value)) {
            throw new Exception\InvalidEnumerationValueException(
                sprintf('Invalid value %s for %s', $value, get_class($this)),
                1381512761
            );
        }
        $this->setValue($value);
    }

    /**
     * @throws Exception\InvalidEnumerationValueException
     * @throws Exception\InvalidEnumerationDefinitionException
     * @internal param string $class
     */
    protected function loadValues()
    {
        $class = get_class($this);
        if (isset(static::$enumConstants[$class])) {
            return;
        }
        $reflection = new \ReflectionClass($class);
        $constants = $reflection->getConstants();
        $defaultValue = null;
        if (isset($constants['__DEFAULT'])) {
            $defaultValue = $constants['__DEFAULT'];
            unset($constants['__DEFAULT']);
        }
        if (empty($constants)) {
            throw new Exception\InvalidEnumerationValueException(
                sprintf(
                    'No enumeration constants defined for "%s"',
                    $class
                ),
                1381512807
            );
        }
        foreach ($constants as $constant => $value) {
            if (!is_int($value) && !is_string($value)) {
                throw new Exception\InvalidEnumerationDefinitionException(
                    sprintf(
                        'Constant value must be of type integer or string; constant=%s; type=%s',
                        $constant,
                        is_object($value) ? get_class($value) : gettype($value)
                    ),
                    1381512797
                );
            }
        }
        $constantValueCounts = array_count_values($constants);
        arsort($constantValueCounts, SORT_NUMERIC);
        $constantValueCount = current($constantValueCounts);
        $constant = key($constantValueCounts);
        if ($constantValueCount > 1) {
            throw new Exception\InvalidEnumerationDefinitionException(
                sprintf(
                    'Constant value is not unique; constant=%s; value=%s; enum=%s',
                    $constant,
                    $constantValueCount,
                    $class
                ),
                1381512859
            );
        }
        if ($defaultValue !== null) {
            $constants['__DEFAULT'] = $defaultValue;
        }
        static::$enumConstants[$class] = $constants;
    }

    /**
     * Set the Enumeration value to the associated enumeration value by a loose comparison.
     * The value, that is used as the enumeration value, will be of the same type like defined in the enumeration
     *
     * @param mixed $value
     * @throws Exception\InvalidEnumerationValueException
     */
    protected function setValue($value)
    {
        $enumKey = array_search((string) $value, static::$enumConstants[get_class($this)]);
        if ($enumKey === false) {
            throw new Exception\InvalidEnumerationValueException(
                sprintf('Invalid value %s for %s', $value, __CLASS__),
                1381615295
            );
        }
        $this->value = static::$enumConstants[get_class($this)][$enumKey];
    }

    /**
     * Check if the value on this enum is a valid value for the enum
     *
     * @param mixed $value
     * @return boolean
     */
    protected function isValid($value)
    {
        $value = (string) $value;
        foreach (static::$enumConstants[get_class($this)] as $constantValue) {
            if ($value === (string) $constantValue) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the valid values for this enum
     * Defaults to constants you define in your subclass
     * override to provide custom functionality
     *
     * @param boolean $include_default
     * @return array
     */
    public static function getConstants($include_default = false)
    {
        $enumConstants = static::$enumConstants[get_called_class()];
        if (!$include_default) {
            unset($enumConstants['__DEFAULT']);
        }
        return $enumConstants;
    }

    /**
     * Cast value to enumeration type
     *
     * @param mixed $value Value that has to be casted
     * @return static
     */
    public static function cast($value)
    {
        $currentClass = get_called_class();
        if (!is_object($value) || get_class($value) !== $currentClass) {
            $value = new $currentClass($value);
        }
        return $value;
    }

    /**
     * Compare if the value of the current object value equals the given value
     *
     * @param mixed $value default
     * @return boolean
     */
    public function equals($value)
    {
        $value = static::cast($value);
        return $this == $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
