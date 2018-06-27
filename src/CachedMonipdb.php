<?php

namespace larryli\monipdb;

/**
 * Class CachedMonipdb
 * @package larryli\monipdb
 */
class CachedMonipdb extends Monipdb
{
    /**
     * @var array
     */
    protected $cached = [];
    /**
     * @var array
     */
    protected $strings = [];

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

    /**
     * @param int $start
     * @return false|mixed|string
     */
    protected function string($start)
    {
        $off = unpack('Vlen', $this->read($start + 4, 3) . "\x0");
        if (!isset($this->strings[$off['len']])) {
            $len = call_user_func($this->func, $start);
            $this->strings[$off['len']] = $this->read($this->offset + $off['len'] - 4, $len['len']);
        }
        return $this->strings[$off['len']];
    }
}
