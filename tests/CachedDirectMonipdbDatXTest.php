<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\CachedDirectMonipdb;

/**
 * Class CachedMonipdbDatXTest
 * @package larryli\monipdb\tests
 */
class CachedDirectMonipdbDatXTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new CachedDirectMonipdb(__DIR__ . '/17monipdb.datx');
    }
}
