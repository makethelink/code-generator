<?php
namespace MTL\CodeGenerator;

use MTL\CodeGenerator\Handler\HandlerInterface;

class Generator extends AbstractGenerator
{
    protected $availableCharacters = array();
    protected $repeated = true;


    public function __construct()
    {
        $this->availableCharacters = array_merge(range('A', 'Z'), range(0, 9));
    }

    public function generate($repeated = true, $number = 1, $length = 5, $availableCharacters = array(), HandlerInterface $handler = null)
    {
        $this->availableCharacters = $availableCharacters;
//        $this->availableCharacters = array_values(array_diff($availableCharacters, $excludedCharacters));
        $this->repeated = $repeated;

//        if ($this->repeated) {
//            Validator::validateBaseN($this->availableCharacters, $number, $length);
//        } else {
//            Validator::validatePermutation($this->availableCharacters, $number, $length);
//        }

        return $this->generateCodes($number, $length, $handler);
    }

    public function generateFromConfig(Config $config, HandlerInterface $handler = null)
    {
        return $this->generate($config->getRepeated(), $config->getNumber(), $config->getLength(), $config->getAvailableCharacters(), $handler);
    }

    protected function generateCodes($number, $length, HandlerInterface $handler = null)
    {
        $codes = $this->getCodes($number, $length);

        if ($handler) {
            $handler->handle($codes);
        }

        return $codes;
    }



    private function getCodes($number, $length)
    {
        $codes = array();

        $need = $number;

        while ($need > 0) {
            $next = array_flip(array_flip(($this->getNext($need, $length))));
            $intersect = array_intersect($codes, $next);
            $codes = array_merge($codes, array_diff($next, $intersect));
            $need = $need - count($next) + count($intersect);
        }

        return $codes;
    }

    private function getNext($number, $length)
    {
        $result = array();

        for ($i=0; $i<$number; $i++) {
            $result[] = $this->getRandomString($length, $this->repeated);
        }

        return $result;
    }
}