<?php

namespace test\src\App\Util;

use App\Util\Response;

class ResponseTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetResponseDataForSuccess()
    {
        $expected = array(
            'code' => 200,
            'status' => 'success',
            'message' => 'message',
            'data' => array('key' => 'data')
        );
        $actual = Response::getResponseData(200,'message','key','data');
        $this->assertEquals($expected, $actual);
    }

    public function testGetResponseDataFor400()
    {
        $expected = array(
            'code' => 400,
            'status' => 'failure',
            'message' => 'message',
            'data' => array('key' => 'data')
        );
        $actual = Response::getResponseData(400,'message','key','data');
        $this->assertEquals($expected, $actual);
    }

    public function testGetResponseDataFor500()
    {
        $expected = array(
            'code' => 500,
            'status' => 'error',
            'message' => 'message',
            'data' => array('key' => 'data')
        );
        $actual = Response::getResponseData(500,'message','key','data');
        $this->assertEquals($expected, $actual);
    }

}