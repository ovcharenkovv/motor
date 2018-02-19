<?php

namespace App\Vsetv\Parser;

class Time
{
    private $zero;

    /**
     * @param $zero
     */
    public function __construct(string $zero)
    {
        $this->zero = $zero;
    }

    /**
     * @param $string
     * @return string
     */
    public function parse(string $string): string
    {
        $pieces = explode(":", $string);
        return $this->extract(trim($pieces[0])) . ':' . $this->extract(trim($pieces[1]));
    }

    /**
     * @param $string
     * @return string
     */
    private function extract(string $string): string
    {
        return $this->getFirst($string) . $this->getSecond($string);
    }

    /**
     * @param $string
     * @return string
     */
    private function getFirst(string $string): string
    {
        return $string{0} != '<' ?
            $string{0} :
            ((substr($string, 15, 2) == $this->zero) ? '0' : '5');
    }

    /**
     * @param $string
     * @return string
     */
    private function getSecond(string $string): string
    {
        return $string{strlen($string) - 1} != '>' ?
            $string{strlen($string) - 1} :
            ((substr($string, -8, 2) == $this->zero) ? '0' : '5');
    }
}
