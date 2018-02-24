<?php

if (!function_exists('strpos_arr')) {

    /**
     * @param $haystack
     * @param $needle
     * @return bool|int
     */
    function strpos_arr($haystack, array $needle)
    {
        foreach ($needle as $what) {
            if (($pos = strpos($haystack, $what)) !== false) {
                return $pos;
            }
        }
        return false;
    }
}
