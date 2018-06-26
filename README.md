# Monipdb

使用 PHP 数组式访问 Monipdb 数据库。

## 使用方法

```shell
composer require larryli/monipdb
```

```php
$monipdb = new \larryli\monipdb\Monipdb('17monipdb.datx');

// find
echo "202.103.24.68: {$monipdb['202.103.24.68']}\n";

// dump
for foreach ($monipdb as $ip => $name) {
    echo "{$ip}: $name\n";
}
```
