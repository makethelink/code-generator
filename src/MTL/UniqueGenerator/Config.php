<?php
namespace MTL\UniqueGenerator;

class Config 
{
    private $repeated;

    private $number;

    private $length;

    private $availableCharacters = array();

    public function __construct($config = array())
    {
        $this->repeated = isset($config['repeated']) ? $config['repeated'] : false;
        if (!isset($config['number'])) {
            throw new \InvalidArgumentException('Number of codes to generate must be set');
        }

        if (!isset($config['length'])) {
            throw new \InvalidArgumentException('The length of each code to generate must be set');
        }

        $this->number = $config['number'];
        $this->length = $config['length'];
        $this->availableCharacters = !empty($config['availableCharacters']) ? $config['availableCharacters'] : array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    }

    /**
     * @return boolean
     */
    public function getRepeated()
    {
        return $this->repeated;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return array
     */
    public function getAvailableCharacters()
    {
        return $this->availableCharacters;
    }
}