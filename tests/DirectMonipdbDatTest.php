<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\DirectMonipdb;

/**
 * Class DirectMonipdbDatTest
 * @package larryli\monipdb\tests
 */
class DirectMonipdbDatTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new DirectMonipdb(dirname(__DIR__) . '/17monipdb.dat', false);
    }
}
