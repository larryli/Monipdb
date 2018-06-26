# Monipdb

使用 PHP 数组式访问 ipip.net 数据库。

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

## 免费下载数据库

需要[注册账号](https://user.ipip.net/register.html)[登录](https://user.ipip.net/login.html)后下载。

下载地址: https://www.ipip.net/free_download/
