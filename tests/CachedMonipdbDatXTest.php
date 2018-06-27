<?php

namespace larryli\monipdb\tests;

use larryli\monipdb\CachedMonipdb;

/**
 * Class CachedMonipdbDatXTest
 * @package larryli\monipdb\tests
 */
class CachedMonipdbDatXTest extends BaseMonipdbTest
{
    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->monipdb = new CachedMonipdb(dirname(__DIR__) . '/17monipdb.datx');
    }
}
