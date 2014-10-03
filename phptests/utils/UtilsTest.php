<?php


class UtilsTest extends PHPUnit_Framework_TestCase {

    public function testParseBool()
    {
        $this->assertTrue(\asm\utils\Utils::parseBool('true'));
        $this->assertTrue(\asm\utils\Utils::parseBool('yes'));
        $this->assertTrue(\asm\utils\Utils::parseBool('y'));

        $this->assertFalse(\asm\utils\Utils::parseBool('false'));
        $this->assertFalse(\asm\utils\Utils::parseBool('no'));
        $this->assertFalse(\asm\utils\Utils::parseBool('n'));
        $this->assertFalse(\asm\utils\Utils::parseBool('0'));
        $this->assertFalse(\asm\utils\Utils::parseBool(''));

        $this->assertNull(\asm\utils\Utils::parseBool('sthelse'));
    }
}
 