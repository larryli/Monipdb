<?php

namespace larryli\monipdb;

/**
 * Class CachedDirectMonipdb
 * @package larryli\monipdb
 */
class CachedDirectMonipdb extends DirectMonipdb
{
    /**
     * @var array
     */
    protected $cached = [];

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if (!isset($this->cached[$offset])) {
            $this->cached[$offset] = parent::offsetGet($offset);
        }
        return $this->cached[$offset];
    }
}
