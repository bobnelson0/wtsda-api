<?php
namespace src\App\Util;

use App\Util\Request;

class RequestTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before() {
        ini_set('display_errors', 1);
        ini_set('error_reporting', 'E_ALL');
    }

    protected function _after() {}

    public function testGetRangeUsingNullValues() {
        $expected = array('offset' => Request::getDefaultOffset(), 'limit' => Request::getDefaultLimit());
        $actual = Request::getRange(0, null, null);
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => Request::getDefaultOffset(), 'limit' => Request::getDefaultLimit());
        $actual = Request::getRange(null, 25, null);
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => Request::getDefaultOffset(), 'limit' => Request::getDefaultLimit());
        $actual = Request::getRange(null, null, null);
        $this->assertEquals($expected, $actual);
    }

    public function testGetRangeUsingGoodParams()
    {
        $expected = array('offset' => 0, 'limit' => 5);
        $actual = Request::getRange(0, 5, null);
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 1, 'limit' => 25);
        $actual = Request::getRange(1, 25, null);
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 25, 'limit' => 25);
        $actual = Request::getRange(25, 25, null);
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 30, 'limit' => 5);
        $actual = Request::getRange(30, 5, null);
        $this->assertEquals($expected, $actual);
    }

    public function testGetRangeUsingGoodHeaders()
    {
        $expected = array('offset' => 0, 'limit' => 5);
        $actual = Request::getRange(null, null, '0-4');
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 0, 'limit' => 25);
        $actual = Request::getRange(null, null, '0-24');
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 25, 'limit' => 25);
        $actual = Request::getRange(null, null, '25-49');
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 30, 'limit' => 5);
        $actual = Request::getRange(null, null, '30-34');
        $this->assertEquals($expected, $actual);
    }

    public function testGetRangeUsingBadParams()
    {
        try {
            Request::getRange('A', 5, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(0, 'B', null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange('A', 'B', null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(1.5, 25, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(1, 25.5, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(1.5, 25.5, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(-1, 25, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(0, -25, null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }

    public function testGetRangeUsingBadHeaders()
    {
        try {
            Request::getRange(null, null, 'A-5');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, '0-B');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, 'A-B');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, '1.5-25');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, '1-25.5');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, '1.5-25.5');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, '-1-25');;
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getRange(null, null, '1--25');;
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }
}