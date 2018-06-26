<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\Monipdb;

/**
 * Class MonipdbTest
 * @package larryli\monipdb\tests
 */
class MonipdbTest extends \PHPUnit_Framework_TestCase
{
    protected $monipdb;

    protected function up()
    {
        $this->monipdb = new Monipdb(dirname(__DIR__) . '/17monipdb.datx');
    }

    protected function old()
    {
        $this->monipdb = new Monipdb(dirname(__DIR__) . '/17monipdb.dat', false);
    }

    /**
     * @expectedException \Exception
     */
    public function testConstructException()
    {
        new Monipdb('/some filename');
    }

    /**
     * @expectedException \Exception
     */
    public function testSetException()
    {
        $this->up();
        $this->monipdb[] = "Exception";
    }

    /**
     * @expectedException \Exception
     */
    public function testUnsetException()
    {
        $this->up();
        unset($this->monipdb[0]);
    }

    public function testCount()
    {
        $this->up();
        $this->assertNotEquals(0, count($this->monipdb));
    }

    public function testForeach()
    {
        $this->up();
        $tests = [];
        $count = 0;
        foreach ($this->monipdb as $ip => $string) {
            $count++;
            if ($count % 5000 == 0) {
                $tests[$ip] = $string;
            }
        }
        $this->assertEquals($count, count($this->monipdb));
        foreach ($tests as $ip => $string) {
            $this->assertEquals($string, $this->monipdb[$ip]);
        }
    }

    public function testExists()
    {
        $this->up();
        $this->assertEquals(true, isset($this->monipdb['10.0.0.1']));
        $this->assertEquals(false, isset($this->monipdb[-1]));
    }

    public function testFind()
    {
        $this->up();
        $this->assertEquals("中国\t湖北\t武汉\t", $this->monipdb['202.103.24.68']);
        $this->assertEquals("中国\t广东\t深圳\t", $this->monipdb[3395323525]);
        $this->assertEquals(false, $this->monipdb[-1]);
    }

    public function testCountOld()
    {
        $this->old();
        $this->assertNotEquals(0, count($this->monipdb));
    }

    public function testFindOld()
    {
        $this->old();
        $this->assertEquals("中国\t湖北\t武汉\t", $this->monipdb['202.103.24.68']);
        $this->assertEquals("中国\t广东\t深圳\t", $this->monipdb[3395323525]);
    }

    public function testForeachOld()
    {
        $this->old();
        $tests = [];
        $count = 0;
        foreach ($this->monipdb as $ip => $string) {
            $count++;
            if ($count % 5000 == 0) {
                $tests[$ip] = $string;
            }
        }
        $this->assertEquals($count, count($this->monipdb));
        foreach ($tests as $ip => $string) {
            $this->assertEquals($string, $this->monipdb[$ip]);
        }
    }
}
