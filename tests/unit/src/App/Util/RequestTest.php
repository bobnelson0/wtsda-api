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

    public function testGetRequestCriteriaUsingGoodValues() {
        $params = array();
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit()
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array();
        $headers = new \Slim\Http\Headers();
        $headers->set('Range', '5-15');
        $expected = array(
            'offset' => 5,
            'limit' => 10
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'offset' => 5,
            'limit' => 10
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => 5,
            'limit' => 10
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'sorts' => 'id'
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit(),
            'sorts' => array(
                array('sort' => 'id', 'dir' => 'asc')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'sorts' => 'id|-name'
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit(),
            'sorts' => array(
                array('sort' => 'id', 'dir' => 'asc'),
                array('sort' => 'name', 'dir' => 'desc')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'sorts' => null
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit()
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'filters' => 'id::1'
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit(),
            'filters' => array(
                array('filter' => 'id', 'val' => '1', 'op' => '=')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'filters' => 'id::1|name:<>:Bob'
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit(),
            'filters' => array(
                array('filter' => 'id', 'val' => '1', 'op' => '='),
                array('filter' => 'name', 'val' => 'Bob', 'op' => '<>')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'filters' => null
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit()
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        // Putting it all together
        $params = array(
            'sorts' => 'id|-name',
            'filters' => 'id::1|name:<>:Bob'
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => Request::getDefaultOffset(),
            'limit' => Request::getDefaultLimit(),
            'sorts' => array(
                array('sort' => 'id', 'dir' => 'asc'),
                array('sort' => 'name', 'dir' => 'desc')
            ),
            'filters' => array(
                array('filter' => 'id', 'val' => '1', 'op' => '='),
                array('filter' => 'name', 'val' => 'Bob', 'op' => '<>')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'offset' => 5,
            'limit' => 10,
            'sorts' => 'id|-name',
            'filters' => 'id::1|name:<>:Bob'
        );
        $headers = new \Slim\Http\Headers();
        $expected = array(
            'offset' => 5,
            'limit' => 10,
            'sorts' => array(
                array('sort' => 'id', 'dir' => 'asc'),
                array('sort' => 'name', 'dir' => 'desc')
            ),
            'filters' => array(
                array('filter' => 'id', 'val' => '1', 'op' => '='),
                array('filter' => 'name', 'val' => 'Bob', 'op' => '<>')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);

        $params = array(
            'sorts' => 'id|-name',
            'filters' => 'id::1|name:<>:Bob'
        );
        $headers = new \Slim\Http\Headers();
        $headers->set('Range', '5-15');
        $expected = array(
            'offset' => 5,
            'limit' => 10,
            'sorts' => array(
                array('sort' => 'id', 'dir' => 'asc'),
                array('sort' => 'name', 'dir' => 'desc')
            ),
            'filters' => array(
                array('filter' => 'id', 'val' => '1', 'op' => '='),
                array('filter' => 'name', 'val' => 'Bob', 'op' => '<>')
            )
        );
        $actual = Request::getRequestCriteria($params, $headers);
        $this->assertEquals($expected, $actual);
    }

    public function testGetRequestCriteriaUsingBadValues() {
        try {
            $params = array(
                'offset' => 'A',
                'limit' => 'B'
            );
            $headers = new \Slim\Http\Headers();
            Request::getRequestCriteria($params, $headers);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            $params = array();
            $headers = new \Slim\Http\Headers();
            $headers->set('Range', 'A-B');
            Request::getRequestCriteria($params, $headers);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            $params = array(
                'sorts' => '+bob'
            );
            $headers = new \Slim\Http\Headers();
            Request::getRequestCriteria($params, $headers);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            $params = array(
                'filters' => 'id::'
            );
            $headers = new \Slim\Http\Headers();
            Request::getRequestCriteria($params, $headers);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            $params = array(
                'offset' => 'A',
                'limit' => 'B',
                'sorts' => '+bob',
                'filters' => 'id::'
            );
            $headers = new \Slim\Http\Headers();
            Request::getRequestCriteria($params, $headers);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }

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
        $actual = Request::getRange(null, null, '0-5');
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 0, 'limit' => 25);
        $actual = Request::getRange(null, null, '0-25');
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 25, 'limit' => 25);
        $actual = Request::getRange(null, null, '25-50');
        $this->assertEquals($expected, $actual);

        $expected = array('offset' => 30, 'limit' => 5);
        $actual = Request::getRange(null, null, '30-35');
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

    public function testGetSortsUsingGoodValues() {
        $expected = array('sorts' => array(
            array('sort' => 'id', 'dir' => 'asc')
        ));
        $actual = Request::getSorts('id');
        $this->assertEquals($expected, $actual);

        $expected = array('sorts' => array(
            array('sort' => 'id', 'dir' => 'desc')
        ));
        $actual = Request::getSorts('-id');
        $this->assertEquals($expected, $actual);

        $expected = array('sorts' => array(
            array('sort' => 'id', 'dir' => 'asc'),
            array('sort' => 'name', 'dir' => 'asc')
        ));
        $actual = Request::getSorts('id|name');
        $this->assertEquals($expected, $actual);

        $expected = array('sorts' => array(
            array('sort' => 'id', 'dir' => 'desc'),
            array('sort' => 'name', 'dir' => 'desc')
        ));
        $actual = Request::getSorts('-id|-name');
        $this->assertEquals($expected, $actual);

        $expected = array('sorts' => array(
            array('sort' => 'id', 'dir' => 'desc'),
            array('sort' => 'name', 'dir' => 'desc'),
            array('sort' => 'ord', 'dir' => 'asc')
        ));
        $actual = Request::getSorts('-id|-name|ord');
        $this->assertEquals($expected, $actual);
    }

    public function testGetSortsUsingBadValues() {
        try {
            Request::getSorts('+id');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts('id|+name');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts('first_name');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts('-first_name|');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts('');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts(null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts(array());
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts(new \stdClass());
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts('id|');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts(' id ');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getSorts('id |name ');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }

    public function testGetFiltersUsingGoodValues() {
        $expected = array('filters' => array(
            array('filter' => 'id', 'val' => '1', 'op' => '=')
        ));
        $actual = Request::getFilters('id::1');
        $this->assertEquals($expected, $actual);

        $expected = array('filters' => array(
            array('filter' => 'id', 'val' => '1', 'op' => '='),
            array('filter' => 'name', 'val' => 'Bob', 'op' => '='),
            array('filter' => 'ord', 'val' => '5', 'op' => '=')
        ));
        $actual = Request::getFilters('id::1|name::Bob|ord::5');
        $this->assertEquals($expected, $actual);

        $expected = array('filters' => array(
            array('filter' => 'id', 'val' => '1', 'op' => '>=')
        ));
        $actual = Request::getFilters('id:>-:1');
        $this->assertEquals($expected, $actual);

        $expected = array('filters' => array(
            array('filter' => 'id', 'val' => '1', 'op' => '='),
            array('filter' => 'name', 'val' => 'Bob', 'op' => '<>'),
            array('filter' => 'ord', 'val' => '5', 'op' => '<=')
        ));
        $actual = Request::getFilters('id::1|name:<>:Bob|ord:<-:5');
        $this->assertEquals($expected, $actual);
    }

    public function testGetFiltersUsingBadValues()
    {
        try {
            Request::getFilters('id');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters('id|name');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters('id:*:');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters('id::');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters('::1');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters('');
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters(null);
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters(array());
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }

        try {
            Request::getFilters(new \stdClass());
            $this->fail("Did not throw an InvalidArgumentException");
        } catch (\InvalidArgumentException $e) {
            //Passed
        } catch (\Exception $e) {
            $class = get_class($e);
            $this->fail($this->fail("Did not throw an InvalidArgumentException, instead $class"));
        }
    }
}