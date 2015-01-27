<?php
namespace MTL\CodeGenerator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $generator = new Generator();

        $codes = $generator->generate(true, 100, 5, range('A', 'Z'));

        $this->assertEquals(100, count(array_unique($codes)));
    }

    public function testGenerateFromConfig()
    {
        $generator = new Generator();
        $mockConfig = $this->getMockBuilder('MTL\CodeGenerator\Config')
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

        $codes = $generator->generateFromConfig($mockConfig);

        $this->assertEquals(100, count(array_unique($codes)));
    }
}