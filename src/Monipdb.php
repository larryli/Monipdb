<?php

namespace larryli\monipdb;

/**
 * Class Monipdb
 * @package larryli\monipdb
 */
class Monipdb implements \ArrayAccess, \Countable, \Iterator
{
    /**
     * @var bool
     */
    protected $isDatX;
    /**
     * @var string
     */
    protected $data;
    /**
     * @var int
     */
    protected $position = 0;
    /**
     * @var int
     */
    protected $step = 9;
    /**
     * @var int
     */
    protected $index = 262144;
    /**
     * @var int
     */
    protected $offset = 0;
    /**
     * @var int
     */
    protected $end = 0;
    /**
     * @var
     */
    protected $func;

    /**
     * @param string $path is file path
     * @param bool $isDatX
     * @throws \Exception
     */
    public function __construct($path, $isDatX = true)
    {
        $this->isDatX = $isDatX;
        if (!is_file($path)) {
            throw new \Exception("{$path} is not exits.");
        }
        $file = fopen($path, 'rb');
        if (!is_resource($file)) {
            throw new \Exception("{$path} fopen failed.");
        }
        if ($this->isDatX) {
            $this->func = function ($n) {
                return unpack('nlen', $this->data[$n + 7] . $this->data[$n + 8]);
            };
        } else {
            $this->step = 8;
            $this->index = 1024;
            $this->func = function ($n) {
                return unpack('Clen', $this->data[$n + 7]);
            };
        }
        $offset = unpack('Nlen', fread($file, 4));
        $this->offset = $offset['len'] - $this->index;
        if ($this->offset < 4) {
            throw new \Exception("{$path} is invalid.");
        }
        $this->end = $this->offset - 4;
        $this->data = fread($file, fstat($file)['size'] - 4);
        fclose($file);
        $this->rewind();
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->string($this->position);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->position += $this->step;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        $ip = unpack('Nlen', substr($this->data, $this->position, 4));
        return long2ip($ip['len']);
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->position < $this->end;
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = $this->index;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return intval(($this->end - $this->index) / $this->step);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        $ip = $this->ip($offset);
        return $ip != false;
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        $ip = $this->ip($offset);
        if ($ip == false) {
            return false;
        }

        $ip_start2 = intval(floor($ip / (256 * 256)));
        $ip_start = intval(floor($ip_start2 / 256));
        if ($ip_start < 0 || $ip_start > 255) {
            return false;
        }

        $nip = pack('N', $ip);
        $tmp_offset = ($this->isDatX ? $ip_start2 : $ip_start) * 4;
        $start = unpack('Vlen', substr($this->data, $tmp_offset, 4));

        for ($start = $start['len'] * $this->step + $this->index; $start < $this->end; $start += $this->step) {
            $tmp = $this->data[$start] . $this->data[$start + 1] . $this->data[$start + 2] . $this->data[$start + 3];
            if ($tmp >= $nip) {
                return $this->string($start);
            }
        }
        return false;
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('Readonly');
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws \Exception
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('Readonly');
    }

    /**
     * @param $ip int|string
     * @return int|bool
     */
    protected function ip($ip)
    {
        if (is_string($ip)) {
            return ip2long($ip);
        } else if (is_int($ip)) {
            if ($ip > 0 && $ip < 4294967295) {
                return $ip;
            }
        }
        return false;
    }

    /**
     * @param $start int
     * @return false|string
     */
    protected function string($start)
    {
        $off = unpack('Vlen', substr($this->data, $start + 4, 3) . "\x0");
        $len = call_user_func($this->func, $start);
        return substr($this->data, $this->offset + $off['len'] - 4, $len['len']);
    }
}