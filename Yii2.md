# Yii2 自定义组件

可以直接使用 `\larryli\monipdb\MonipdbTrait` 实现 yii2 组件，代码如下：

```php
<?php

namespace app\components;

use larryli\monipdb\MonipdbTrait;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Monipdb Component
 *
 * `Yii::$app->monipdb['202.103.24.68']`
 */
class Monipdb extends Component implements \ArrayAccess, \Countable, \Iterator
{
    use MonipdbTrait {offsetGet as protected traitOffsetGet;}

    /**
     * @var string
     */
    public $filename;
    /**
     * @var bool
     */
    public $datx = true;
    /**
     * @var string
     */
    protected $data;
    /**
     * @var array
     */
    protected $cached = [];

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->filename)) {
            throw new InvalidConfigException('Monipdb::filename must be set.');
        }
        $this->filename = Yii::getAlias($this->filename);
        try {
            $file = $this->load($this->filename, $this->datx);
            $this->data = fread($file, fstat($file)['size'] - 4);
            fclose($file);
        } catch (\Exception $e) {
            throw new InvalidConfigException("Invalid {$this->filename} file!");
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if (!isset($this->cached[$offset])) {
            $this->cached[$offset] = static::traitOffsetGet($offset);
        }
        return $this->cached[$offset];
    }

    /**
     * @param $ip
     * @return string
     * @deprecated
     */
    public function find($ip)
    {
        return $this->offsetGet($ip);
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
```
