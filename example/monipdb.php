<?php

require(dirname(__DIR__) . '/src/Monipdb.php');

echo "[MEMORY] Start: " . memory_get_usage() . "\n";

try {
    $monipdb = new \larryli\monipdb\Monipdb(dirname(__DIR__) . '/17monipdb.datx');
} catch (Exception $e) {
    die($e);
}

echo "[MEMORY] DatX: " . memory_get_usage() . "\n";

echo "Count: " . count($monipdb) . "\n";

foreach ($monipdb as $ip => $name) {
    $ip = long2ip($ip);
    echo "{$ip}: $name\n";
    break;
}

echo "202.103.24.68: {$monipdb['202.103.24.68']}\n";

echo "3395323525: {$monipdb[3395323525]}\n";

unset($monipdb);
gc_collect_cycles();
echo "[MEMORY] Clean: " . memory_get_usage() . "\n";

try {
    $monipdb = new \larryli\monipdb\Monipdb(dirname(__DIR__) . '/17monipdb.dat', false);
} catch (Exception $e) {
    die($e);
}

echo "[MEMORY] Dat: " . memory_get_usage() . "\n";

echo "Count: " . count($monipdb) . "\n";

foreach ($monipdb as $ip => $name) {
    $ip = long2ip($ip);
    echo "{$ip}: $name\n";
    break;
}

echo "202.103.24.68: {$monipdb['202.103.24.68']}\n";

echo "3395323525: {$monipdb[3395323525]}\n";

unset($monipdb);
gc_collect_cycles();
echo "[MEMORY] Clean: " . memory_get_usage() . "\n";
