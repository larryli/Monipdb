<?php

require(dirname(__DIR__) . '/src/Monipdb.php');

$objects = array(
    'Monipdb' => '\larryli\monipdb\Monipdb',
);
$files = array(
    'DatX' => array(dirname(__DIR__) . '/17monipdb.datx', true),
    'Dat' => array(dirname(__DIR__) . '/17monipdb.dat', false)
);

foreach ($objects as $object => $class) {
    foreach ($files as $name => $params) {
        echo "---- {$object} {$name} ----\n\n";

        echo "[MEMORY] Start: " . memory_get_usage() . "\n";

        try {
            $monipdb = new $class($params[0], $params[1]);
            echo "[MEMORY] Load: " . memory_get_usage() . "\n";

            echo "[COUNT] Count: " . count($monipdb) . "\n";

            foreach ($monipdb as $ip => $name) {
                echo "[FOREACH] {$ip}: $name\n";
                break;
            }

            echo "[GET] 202.103.24.68: {$monipdb['202.103.24.68']}\n";

            $ip = ip2long('202.96.134.133');
            echo "[GET] 3395323525: {$monipdb[3395323525]}\n";

            unset($monipdb);
        } catch (Exception $e) {
            die($e);
        }

        gc_collect_cycles();
        echo "[MEMORY] Clean: " . memory_get_usage() . "\n\n";
    }
}
