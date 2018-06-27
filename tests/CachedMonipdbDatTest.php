<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\CachedMonipdb;

/**
 * Class CachedMonipdbDatTest
 * @package larryli\monipdb\tests
 */
class CachedMonipdbDatTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new CachedMonipdb(dirname(__DIR__) . '/17monipdb.dat', false);
    }
}
