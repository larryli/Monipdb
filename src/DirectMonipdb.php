<?php

namespace larryli\monipdb;

/**
 * Class DirectMonipdb
 * @package larryli\monipdb
 */
class DirectMonipdb implements \ArrayAccess, \Countable, \Iterator
{
    use MonipdbTrait;

    /**
     * @var resource
     */
    protected $file;

    /**
     * @param string $path is file path
     * @param bool $isDatX
     * @throws \Exception
     */
    public function __construct($path, $isDatX = true)
    {
        $this->file = $this->load($path, $isDatX);
    }

    /**
     *
     */
    public function __destruct()
    {
        fclose($this->file);
    }

    /**
     * @param int $offset
     * @param int $len
     * @return string
     */
    protected function read($offset, $len)
    {
        fseek($this->file, $offset + 4);
        return fread($this->file, $len);
    }
}
