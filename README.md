# Monipdb

使用 PHP 数组式访问 ipip.net 数据库。

[![Latest Stable Version](https://poser.pugx.org/larryli/monipdb/v/stable)](https://packagist.org/packages/larryli/monipdb)
[![Total Downloads](https://poser.pugx.org/larryli/monipdb/downloads)](https://packagist.org/packages/larryli/monipdb)
[![Latest Unstable Version](https://poser.pugx.org/larryli/monipdb/v/unstable)](https://packagist.org/packages/larryli/monipdb)
[![License](https://poser.pugx.org/larryli/monipdb/license)](https://packagist.org/packages/larryli/monipdb)

## 使用方法

需要 PHP 5.4 以上版本，无其他依赖。

```shell
composer require larryli/monipdb
```

```php
$monipdb = new \larryli\monipdb\Monipdb('17monipdb.datx');
// or $monipdb = new \larryli\monipdb\Monipdb('17monipdb.dat', false);

// find
echo "202.103.24.68: {$monipdb['202.103.24.68']}\n";

// dump
echo count($monipdb) . "\n";

for foreach ($monipdb as $ip => $name) {
    echo "{$ip}: $name\n";
}
```

默认的 `\larryli\monipdb\Monipdb` 将会把数据文件一次性读入内存，
`\larryli\monipdb\CachedMonipdb` 在上述基础上使用内存缓存部分数据，以利于一次请求中多次重复查询；
`\larryli\monipdb\DirectMonipdb` 则不缓存内存数据，每个查询都会直接从数据文件中读取数据。 

具体请参考 [example](example/monipdb.php) 文件。

## 免费下载数据库

需要[注册账号](https://user.ipip.net/register.html)[登录](https://user.ipip.net/login.html)后下载。

下载地址: https://www.ipip.net/free_download/
