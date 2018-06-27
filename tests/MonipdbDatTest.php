<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\Monipdb;

/**
 * Class MonipdbDatTest
 * @package larryli\monipdb\tests
 */
class MonipdbDatTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new Monipdb(dirname(__DIR__) . '/17monipdb.dat', false);
    }
}
