<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 22/03/2017
 * Time: 13:31
 */

namespace Labs\BackBundle\Services;


class GenerateService
{
    /**
     * @return string
     */
    public function  generatePassword()
    {
        return $this->RandomString(6);
    }

    /**
     * @return string
     */
    public function RamdomCodeValidate()
    {
        return $this->RandomNumeric(5);
    }

    /**
     * @return string
     */
    public function CodeReinitialisePassword()
    {
        return $this->RandomNumeric(4);
    }

    /**
     * @param int $length
     * @return string
     */
    private function RandomString($length = 32)
    {
        $randstr = '';
        mt_srand((double) microtime(TRUE) * 1000000);
        //our array add all letters and numbers if you wish
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
            'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
            '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        for ($rand = 0; $rand <= $length; $rand++) {
            $random = mt_rand(0, count($chars) - 1);
            $randstr .= $chars[$random];
        }
        return $randstr;
    }

    /**
     * @param int $length
     * @return string
     */
    private function RandomNumeric($length = 32)
    {
        $randstr = '';
        mt_srand((double) microtime(TRUE) * 1000000);
        //our array add all letters and numbers if you wish
        $chars = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
        for ($rand = 0; $rand <= $length; $rand++) {
            $random = mt_rand(0, count($chars) - 1);
            $randstr .= $chars[$random];
        }
        return $randstr;
    }
}