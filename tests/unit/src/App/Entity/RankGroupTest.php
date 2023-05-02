<?php

namespace test\src\App\Entity;

use App\Entity\RankGroup;
use Codeception\Specify;

class RankGroupTest extends \Codeception\TestCase\Test
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

    public function xtestSetOrd()
    {
        $rankGroup = new RankGroup();

        $this->specify("setOrd can take valid integer", function($rankGroup) {
            $expected = 1;
            $rankGroup->setOrd($expected);
            $actual = $rankGroup->getetOrd($expected);
            $this->assertEquals($rankGroup, $actual);
        });

        /*$this->specify("setOrd throw on invalid integer", function($rankGroup) {
            $rankGroup->username = null;
            $this->assertFalse($rankGroup->setOrd(1));
        });*/
    }

}