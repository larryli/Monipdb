<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\Monipdb;

/**
 * Class MonipdbDatXTest
 * @package larryli\monipdb\tests
 */
class MonipdbDatXTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new Monipdb(__DIR__ . '/17monipdb.datx');
    }

    /**
     * @expectedException \Exception
     */
    public function testConstructException()
    {
        new Monipdb('/some filename');
    }
}
