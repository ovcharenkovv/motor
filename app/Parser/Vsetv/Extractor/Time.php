<?php

namespace App\Parser\Vsetv\Extractor;

class Time
{
    private $zero;

    function __construct($zero)
    {
        $this->zero = $zero;
    }

    /**
     * @param $string
     * @return string
     */
    public function parse($string)
    {
        $pieces = explode(":", $string);
        return $this->extract(trim($pieces[0])) . ':' . $this->extract(trim($pieces[1]));
    }

    /**
     * @param $string
     * @return string
     */
    private function extract($string)
    {
        return $this->getFirst($string) . $this->getSecond($string);
    }

    /**
     * @param $string
     * @return string
     */
    private function getFirst($string)
    {
        return $string{0} != '<' ?
            $string{0} :
            ((substr($string, 15, 2) == $this->zero) ? '0' : '5');
    }

    /**
     * @param $string
     * @return string
     */
    private function getSecond($string)
    {
        return $string{strlen($string) - 1} != '>' ?
            $string{strlen($string) - 1} :
            ((substr($string, -8, 2) == $this->zero) ? '0' : '5');
    }
}