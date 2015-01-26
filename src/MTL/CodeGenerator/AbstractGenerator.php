<?php
namespace MTL\CodeGenerator;

class AbstractGenerator 
{
    public function getRandomString($length, $repeated)
    {
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $char = '';
            while($char == '') {
                $temp = $this->availableCharacters[mt_rand(0, count($this->availableCharacters) - 1)];
                if (!$repeated && strpos($str, (string)$temp) !== false) {
                    $char = '';
                } else {
                    $char = $temp;
                }
            }

            $str .= (string)$char;
        }

        return $str;
    }
}