<?php

//require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/src/MonipdbTrait.php');
require(dirname(__DIR__) . '/src/Monipdb.php');
require(dirname(__DIR__) . '/src/CachedMonipdb.php');
require(dirname(__DIR__) . '/src/DirectMonipdb.php');
require(dirname(__DIR__) . '/src/CachedDirectMonipdb.php');

function info($title, $start = false)
{
    static $keep;

    echo "[MEMORY] {$title}: " . memory_get_usage() . "\n";
    if ($start) {
        $keep = microtime(true);
    } else {
        echo "[TIME] {$title}: " . round(microtime(true) - $keep, 3) . "\n";
    }
}

$objects = array(
    'Monipdb' => '\larryli\monipdb\Monipdb',
    'CachedMonipdb' => '\larryli\monipdb\CachedMonipdb',
    'DirectMonipdb' => '\larryli\monipdb\DirectMonipdb',
    'CachedDirectMonipdb' => '\larryli\monipdb\CachedDirectMonipdb',
);
$files = array(
    'DatX' => array(dirname(__DIR__) . '/17monipdb.datx', true),
    'Dat' => array(dirname(__DIR__) . '/17monipdb.dat', false)
);

foreach ($objects as $object => $class) {
    foreach ($files as $name => $params) {
        echo "\n---- {$object} {$name} ----\n\n";

        info('Start', true);

        try {
            $monipdb = new $class($params[0], $params[1]);
            info('Load');

            echo "[GET] 202.103.24.68: {$monipdb['202.103.24.68']}\n";

            $ip = ip2long('202.96.134.133');
            echo "[GET] 3395323525: {$monipdb[3395323525]}\n";

            $benchmark = array();
            for ($n = 0; $n < 1000; $n++) {
                $benchmark[] = $monipdb['202.103.24.68'];
            }
            echo "[BENCHMARK] 202.103.24.68: {$benchmark[0]}\n";
            unset($benchmark);
            info('Benchmark');

            echo "[COUNT] Count: " . count($monipdb) . "\n";

            $n = 0;
            foreach ($monipdb as $ip => $name) {
                if ($n % 100000 == 0) {
                    $ip = long2ip($ip);
                    echo "[FOREACH] {$ip}: $name\n";
                }
                $n++;
            }

            info('End');
            unset($monipdb);
        } catch (Exception $e) {
            die($e);
        }

        gc_collect_cycles();
        info('Clean');
    }
}
