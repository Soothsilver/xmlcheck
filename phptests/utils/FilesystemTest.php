<?php


use asm\utils\Filesystem;


class FilesystemTest extends \PHPUnit_Framework_TestCase {
    const TEST_DIRECTORY = '__filesystemTest';

    protected function setUp()
    {
        mkdir(self::TEST_DIRECTORY);
        touch(self::TEST_DIRECTORY . "/a.txt");
        touch(self::TEST_DIRECTORY . "/b.txt");
    }
    protected function tearDown()
    {
        unlink(self::TEST_DIRECTORY . "/a.txt");
        unlink(self::TEST_DIRECTORY . "/b.txt");
        rmdir(self::TEST_DIRECTORY);
    }

    public function testGetFiles()
    {
        $this->assertEquals(['a.txt', 'b.txt'],
            Filesystem::getFiles(self::TEST_DIRECTORY));
    }
}
 