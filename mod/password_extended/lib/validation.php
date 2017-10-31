<?php

/**
 * Class Validator
 */
class Validator
{
    const INVALID_LENGTH = 1;
    const INVALID_COUNT_LOWER_CASE_LETTERS = 2;
    const INVALID_COUNT_UPPER_CASE_LETTERS = 3;
    const INVALID_COUNT_NUMBERS = 4;
    const INVALID_COUNT_SYMBOLS = 5;

    protected $stringHelper;
    protected $minLength = 5;
    protected $maxLength = 20;
    protected $minLowerCaseLetters = 0;
    protected $minUpperCaseLetters = 0;
    protected $minNumbers = 0;
    protected $minSymbols = 0;
    protected $expired = 'no';
    protected $errors = array();

    protected $settings = [
        'minLength' => 'no',
        'maxLength' => 'no',
        'minLowerCaseLetters' => 'no',
        'minUpperCaseLetters' => 'no',
        'minNumbers' => 'no',
        'minSymbols' => 'no',
        'expired' => 'no',
    ];

    /**
     * Validator constructor.
     * @param StringHelper $stringHelper
     */
    public function __construct(StringHelper $stringHelper)
    {
        $this->stringHelper = $stringHelper;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param $options
     * @return $this
     */
    public function setSettings($options)
    {
        $this->settings = array_merge($this->settings, $options);
        return $this->settings;
    }

    /**
     * @param $minLength
     * @return $this
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
        return $this;
    }

    /**
     * @param $maxLength
     * @return $this
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * @param $minLowerCaseLetters
     * @return $this
     */
    public function setMinLowerCaseLetters($minLowerCaseLetters)
    {
        $this->minLowerCaseLetters = $minLowerCaseLetters;
        return $this;
    }

    /**
     * @param $minUpperCaseLetters
     * @return $this
     */
    public function setMinUpperCaseLetters($minUpperCaseLetters)
    {
        $this->minUpperCaseLetters = $minUpperCaseLetters;
        return $this;
    }

    /**
     * @param $minNumbers
     * @return $this
     */
    public function setMinNumbers($minNumbers)
    {
        $this->minNumbers = $minNumbers;
        return $this;
    }

    /**
     * @param $minSymbols
     * @return $this
     */
    public function setMinSymbols($minSymbols)
    {
        $this->minSymbols = $minSymbols;
        return $this;
    }

    /**
     * @return bool
     */
    public function getExpired()
    {
        if($this->settings['expired'] === 'no'){
            return false;
        }
        return true;
    }

    /**
     * @param $string
     * @return bool
     */
    public function isValid($string)
    {
        $this->errors = [];
        $string = (string) $string;

        if($this->settings['minLength'] !=='no' ) {
            if (strlen($string) < $this->minLength) {
                $this->errors[] = self::INVALID_LENGTH;
            }
        }
        if($this->settings['maxLength'] !=='no' ) {
            if (strlen($string) > $this->maxLength) {
                $this->errors[] = self::INVALID_LENGTH;
            }
        }

        if($this->settings['minLowerCaseLetters'] !=='no' ) {
            if ($this->stringHelper->countLowerCaseLetters($string) < $this->minLowerCaseLetters) {
                $this->errors[] = self::INVALID_COUNT_LOWER_CASE_LETTERS;
            }
        }
        if($this->settings['minUpperCaseLetters'] !=='no' ) {
            if ($this->stringHelper->countUpperCaseLetters($string) < $this->minUpperCaseLetters) {
                $this->errors[] = self::INVALID_COUNT_UPPER_CASE_LETTERS;
            }
        }
        if($this->settings['minNumbers'] !=='no' ) {
            if ($this->stringHelper->countNumbers($string) < $this->minNumbers) {
                $this->errors[] = self::INVALID_COUNT_NUMBERS;
            }
        }
        if($this->settings['minSymbols'] !=='no' ) {
            if ($this->stringHelper->countSymbols($string) < $this->minSymbols) {
                $this->errors[] = self::INVALID_COUNT_SYMBOLS;
            }
        }
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}