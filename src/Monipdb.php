<?php

namespace larryli\monipdb;

/**
 * Class Monipdb
 * @package larryli\monipdb
 */
class Monipdb implements \ArrayAccess, \Countable, \Iterator
{
    use MonipdbTrait;

    /**
     * @var string
     */
    protected $data;

    /**
     * @param string $path is file path
     * @param bool $isDatX
     * @throws \Exception
     */
    public function __construct($path, $isDatX = true)
    {
        $file = $this->load($path, $isDatX);
        $this->data = fread($file, fstat($file)['size'] - 4);
        fclose($file);
    }

    /**
     * @param int $offset
     * @param int $len
     * @return string
     */
    protected function read($offset, $len)
    {
        return substr($this->data, $offset, $len);
    }
}
