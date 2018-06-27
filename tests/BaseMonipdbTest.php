<?php

namespace larryli\monipdb\tests;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseMonipdbTest
 * @package larryli\monipdb\tests
 */
abstract class BaseMonipdbTest extends TestCase
{
    /**
     * @var
     */
    protected $monipdb;

    /**
     *
     */
    protected function setDown()
    {
        unset($this->monipdb);
    }

    /**
     * @expectedException \Exception
     */
    public function testSetException()
    {
        $this->monipdb[] = "Exception";
    }

    /**
     * @expectedException \Exception
     */
    public function testUnsetException()
    {
        unset($this->monipdb[0]);
    }

    /**
     *
     */
    public function testCount()
    {
        $this->assertNotEquals(0, count($this->monipdb));
    }

    /**
     *
     */
    public function testForeach()
    {
        $tests = [];
        $count = 0;
        $max = floor(count($this->monipdb) / 10);
        foreach ($this->monipdb as $ip => $string) {
            $count++;
            if (rand(0, $max) == 0) {
                $tests[$ip] = $string;
            }
        }
        $this->assertEquals($count, count($this->monipdb));
        foreach ($tests as $ip => $string) {
            $this->assertEquals($string, $this->monipdb[$ip]);
        }
    }

    /**
     *
     */
    public function testExists()
    {
        $this->assertEquals(true, isset($this->monipdb['10.0.0.1']));
        $this->assertEquals(false, isset($this->monipdb[-1]));
    }

    /**
     *
     */
    public function testFind()
    {
        $this->assertEquals("中国\t湖北\t武汉\t", $this->monipdb['202.103.24.68']);
        $this->assertEquals("中国\t广东\t深圳\t", $this->monipdb[3395323525]);
        $this->assertEquals(false, $this->monipdb[-1]);
    }
}
