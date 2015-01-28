<?php
namespace MTL\UniqueGenerator;

use MTL\UniqueGenerator\Handler\HandlerInterface;

class Generator extends AbstractGenerator
{
    /**
     * @var boolean
     */
    protected $repeated;

    /**
     * @var int
     */
    protected $number;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var array
     */
    protected $availableCharacters = array();

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @param $repeated
     * @param $number
     * @param $length
     * @param array $availableCharacters
     * @param Validator $validator
     */
    public function __construct($repeated, $number, $length, array $availableCharacters, Validator $validator = null)
    {
        $this->repeated = $repeated;
        $this->number = $number;
        $this->length = $length;
        $this->availableCharacters = $availableCharacters;
        $this->validator = $validator ?: new Validator();
    }

    /**
     * @param Config $config
     * @return Generator
     */
    public static function fromConfig(Config $config)
    {
        return new self($config->getRepeated(), $config->getNumber(), $config->getLength(), $config->getAvailableCharacters());
    }

    /**
     * @param HandlerInterface $handler
     * @return array
     *
     * @throws \Exception
     */
    public function generate(HandlerInterface $handler = null)
    {
        $violations = $this->validator->validate($this->repeated, $this->number, $this->length, count($this->availableCharacters));

        if (count($violations) > 0) {
            throw $violations[0];
        }

        $codes = $this->getCodes();

        if ($handler) {
            $handler->handle($codes);
        }

        return $codes;
    }

    /**
     * @param $length
     * @param $repeated
     * @return string
     */
    protected function getRandomString($length, $repeated)
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

    /**
     * @return array
     */
    private function getCodes()
    {
        $codes = array();

        $need = $this->number;

        while ($need > 0) {
            $next = array_flip(array_flip(($this->getNext($need))));
            $intersect = array_intersect($codes, $next);
            $codes = array_merge($codes, array_diff($next, $intersect));
            $need = $need - count($next) + count($intersect);
        }

        return $codes;
    }

    /**
     * @param $number
     * @return array
     */
    private function getNext($number)
    {
        $result = array();

        for ($i=0; $i<$number; $i++) {
            $result[] = $this->getRandomString($this->length, $this->repeated);
        }

        return $result;
    }
}