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
        $availableCharacters = $config->getAvailableCharacters();
        $expected = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        $this->assertSame(array_diff($expected, $availableCharacters), array_diff($availableCharacters, $expected));
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
        $availableCharacters = $config->getAvailableCharacters();
        $expected = range('A', 'Z');
        $this->assertSame(array_diff($expected, $availableCharacters), array_diff($availableCharacters, $expected));
    }
}