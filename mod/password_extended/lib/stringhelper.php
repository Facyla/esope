<?php

/**
 * Class StringHelper
 */
class StringHelper
{
    /**
     * @param $string
     * @return int
     */
    public function countLowerCaseLetters($string)
    {
        $count = 0;
        foreach (str_split($string) as $letter) {
            if ($this->isLowerCase($letter)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param $string
     * @return int
     */
    public function countUpperCaseLetters($string)
    {
        $count = 0;
        foreach (str_split($string) as $letter) {
            if ($this->isUpperCase($letter)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param $string
     * @return int
     */
    public function countNumbers($string)
    {
        $count = 0;
        foreach (str_split($string) as $letter) {
            if ($this->isNumber($letter)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param $string
     * @return int
     */
    public function countSymbols($string)
    {
        $count = 0;
        foreach (str_split($string) as $letter) {
            if ($this->isSymbol($letter)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param $letter
     * @return bool
     */
    protected function isSymbol($letter)
    {
        return !$this->isNumber($letter) && !$this->isLowerCase($letter) && !$this->isUpperCase($letter);
    }

    /**
     * @param $letter
     * @return bool
     */
    protected function isNumber($letter)
    {
        return $this->isCharBetween(0, 9, $letter);
    }

    /**
     * @param $letter
     * @return bool
     */
    protected function isLowerCase($letter)
    {
        return $this->isCharBetween('a', 'z', $letter);
    }

    /**
     * @param $letter
     * @return bool
     */
    protected function isUpperCase($letter)
    {
        return $this->isCharBetween('A', 'Z', $letter);
    }

    /**
     * @param $i
     * @param $j
     * @param $char
     * @return bool
     */
    protected function isCharBetween($i, $j, $char)
    {
        return ord($i) <= ord($char) && ord($char) <= ord($j);
    }
}