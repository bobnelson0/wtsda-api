<?php
namespace src\App\Util;

use App\Util\Validation;

class ValidationTest extends \Codeception\TestCase\Test
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

    public function testIsValidOrdForIntegerGreaterThanZeroReturnsTrue()
    {
        $expected = true;
        $actual = Validation::isValidOrd(1);
        $this->assertEquals($expected, $actual);
    }

    public function testIsValidOrdForZeroReturnsFalse()
    {
        $expected = false;
        $actual = Validation::isValidOrd(0);
        $this->assertEquals($expected, $actual);
    }

    public function testIsValidOrdForStringReturnsFalse()
    {
        $expected = false;
        $actual = Validation::isValidOrd('string');
        $this->assertEquals($expected, $actual);
    }

    public function testIsValidOrdForArrayReturnsFalse()
    {
        $expected = false;
        $actual = Validation::isValidOrd(array());
        $this->assertEquals($expected, $actual);
    }

    public function testIsValidOrdForObjReturnsFalse()
    {
        $expected = false;
        $actual = Validation::isValidOrd(new \stdClass());
        $this->assertEquals($expected, $actual);
    }

}