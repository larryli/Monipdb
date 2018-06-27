<?php

namespace larryli\monipdb;

/**
 * Class BaseMonipdb
 * @package larryli\monipdb
 * @deprecated
 */
abstract class BaseMonipdb implements \ArrayAccess, \Countable, \Iterator
{
    use MonipdbTrait;
}
