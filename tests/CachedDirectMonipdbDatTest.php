<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\CachedDirectMonipdb;

/**
 * Class CachedMonipdbDatTest
 * @package larryli\monipdb\tests
 */
class CachedDirectMonipdbDatTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new CachedDirectMonipdb(__DIR__ . '/17monipdb.dat', false);
    }
}
