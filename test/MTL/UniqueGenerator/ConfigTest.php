<?php
namespace MTL\UniqueGenerator;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNotEnoughLength()
    {
        $config = new Config(array(
            'number' => 10
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNotEnoughNumber()
    {
        $config = new Config(array(
            'length' => 10
        ));
    }

    public function testDefaultConfig()
    {
        $config = new Config(array(
            'number' => 5,
            'length' => 10,
        ));

        $this->assertFalse($config->getRepeated());
        $this->assertEquals(sort(array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9))), sort($config->getAvailableCharacters()));
    }

    public function testConfig()
    {
        $config = new Config(array(
            'number' => 5,
            'length' => 10,
            'repeated' => true,
            'availableCharacters' => range('A', 'Z'),
        ));

        $this->assertEquals(5, $config->getNumber());
        $this->assertEquals(10, $config->getLength());
        $this->assertTrue($config->getRepeated());
        $this->assertEquals(sort(range('A', 'Z')), sort($config->getAvailableCharacters()));
    }
}