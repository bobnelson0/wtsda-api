<?php
namespace src\App\Util;

use App\Util\Config;

class ConfigTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    /**
     * @var string $configFile
     */
    protected $configFile = 'config_test.ini';

    protected function _before()
    {
        $ini = <<<INI
[section1]
key1 = 'val1'

[section2]
key1 = 'val1'
key2 = 'val2'

[section3]
key1 = 'val1'
key2 = 'val2'
key3 = 'val3'
INI;
        file_put_contents($this->configFile, $ini);

    }

    protected function _after()
    {
        unlink($this->configFile);
    }

    public function testGetBySectionWithGoodArgs()
    {
        $expected = array(
            'key1' => 'val1'
        );
        $actual = Config::getSection($this->configFile, 'section1');
        $this->assertEquals($expected, $actual);

        $expected = array(
            'key1' => 'val1',
            'key2' => 'val2',
            'key3' => 'val3'
        );
        $actual = Config::getSection($this->configFile, 'section3');
        $this->assertEquals($expected, $actual);

        $expected = array();
        $actual = Config::getSection($this->configFile, 'notASection');
        $this->assertEquals($expected, $actual);
    }

    public function testGetBySectionWithBadArgs() {
        try {
            Config::getSection($this->configFile, '');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Config::getSection($this->configFile, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Config::getSection($this->configFile, array());
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }

    public function testGetByKeyWithGoodArgs()
    {
        $expected = 'val1';
        $actual = Config::getKey($this->configFile, 'section1.key1');
        $this->assertEquals($expected, $actual);

        $expected = 'val3';
        $actual = Config::getKey($this->configFile, 'section3.key3');
        $this->assertEquals($expected, $actual);

        $expected = null;
        $actual = Config::getKey($this->configFile, 'sectionX.key1');
        $this->assertEquals($expected, $actual);

        $expected = null;
        $actual = Config::getKey($this->configFile, 'section1.keyX');
        $this->assertEquals($expected, $actual);
    }

    public function testGetByKeyWithBadArgs() {
        try {
            Config::getKey($this->configFile, '');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Config::getKey($this->configFile, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Config::getKey($this->configFile, array());
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }

}