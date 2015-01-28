<?php
namespace MTL\UniqueGenerator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $generator = new Generator(true, 100, 5, range('A', 'Z'));

        $codes = $generator->generate();

        $this->assertEquals(100, count(array_unique($codes)));
    }

    public function testGenerateFromConfig()
    {
        $mockConfig = $this->getMockBuilder('MTL\UniqueGenerator\Config')
            ->disableOriginalConstructor()
            ->getMock();

        $mockConfig->expects($this->once())
            ->method('getNumber')
            ->willReturn(100);

        $mockConfig->expects($this->once())
            ->method('getLength')
            ->willReturn(5);

        $mockConfig->expects($this->once())
            ->method('getRepeated')
            ->willReturn(true);

        $mockConfig->expects($this->once())
            ->method('getAvailableCharacters')
            ->willReturn(range('A', 'Z'));

        $generator = Generator::fromConfig($mockConfig);
        $codes = $generator->generate();

        $this->assertEquals(100, count(array_unique($codes)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Too easy to guess
     */
    public function testGenerateValidatorTooEasyToGuess()
    {
        $generator = new Generator(true, 9, 1, range('0', '9'));
        $generator->generate();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Number of codes required is greater than number of codes available
     */
    public function testGenerateValidatorNotPass()
    {
        $generator = new Generator(true, 100, 1, range('0', '9'));
        $generator->generate();
    }
}