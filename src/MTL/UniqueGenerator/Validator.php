<?php
namespace MTL\UniqueGenerator;

class Validator 
{
    private $guessFactor = 0.1;

    /**
     * @param float $guessFactor
     */
    public function __construct($guessFactor = null)
    {
        if ($guessFactor > 0) {
            $this->guessFactor = $guessFactor;
        }
    }

    /**
     * @param $repeated
     * @param $number
     * @param $length
     * @param $characterCount
     * @return array
     */
    public function validate($repeated, $number, $length, $characterCount)
    {
        $violations = array();

        if ($repeated) {
            //When characters could be repeated, there are literally $characterCount^$length possibilities
            $possibleCount = pow($characterCount, $length);
        } else {
            if ($characterCount < $length) {
                $violations[] = new \InvalidArgumentException('Available characters is not enough to generate');
            }
            //When characters could not be repeated, there are literally $characterCount! / ($characterCount - $length)! possibilities
            $possibleCount = $this->factorial($characterCount) / $this->factorial($characterCount - $length);
        }

        if ($possibleCount < $number) {
            $violations[] = new \InvalidArgumentException('Number of codes required is greater than number of codes available');
        }
        if (($number / $possibleCount) > $this->guessFactor) {
            $violations[] = new \InvalidArgumentException('Too easy to guess');
        }

        return $violations;
    }

    public function factorial($number)
    {
        $result = 1;
        for ($i = 1; $i <= $number; $i++)
        {
            $result *= $i;
        }

        return $result;
    }
}