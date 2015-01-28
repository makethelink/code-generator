<?php
namespace MTL\UniqueGenerator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidNonRepeated()
    {
        $validator = new Validator(0.1);

        //Generate 10 codes of length 20 from 2 possible characters
        $violations = $validator->validate(false, 10, 20, 2);

        $this->assertNotEmpty($violations);
        $this->assertEquals('Available characters is not enough to generate', $violations[0]->getMessage());

        //Generate 10 codes of length 1 from 2 possible characters
        $violations = $validator->validate(false, 10, 1, 2);
        $this->assertEquals('Number of codes required is greater than number of codes available', $violations[0]->getMessage());

        //Generate 10 codes of length 1 from 10 possible characters
        $violations = $validator->validate(false, 10, 1, 10);
        $this->assertEquals('Too easy to guess', $violations[0]->getMessage());
    }
}