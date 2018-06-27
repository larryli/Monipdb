<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\DirectMonipdb;

/**
 * Class DirectMonipdbDatXTest
 * @package larryli\monipdb\tests
 */
class DirectMonipdbDatXTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new DirectMonipdb(dirname(__DIR__) . '/17monipdb.datx');
    }

    /**
     *
     */
    public function testDestruct()
    {
        $this->monipdb = null;
        gc_collect_cycles();
        $this->assertNull($this->monipdb);
    }
}
