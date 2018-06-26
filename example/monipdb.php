<?php

require('../src/Monipdb.php');

echo "[MEMORY] Start: " . memory_get_usage() . "\n";

try {
    $dat = new \larryli\monipdb\Monipdb('17monipdb.datx');
} catch (Exception $e) {
    die($e);
}

echo "[MEMORY] DatX: " . memory_get_usage() . "\n";

echo "Count: " . count($dat) . "\n";

foreach ($dat as $ip => $name) {
    echo "{$ip}: $name\n";
    break;
}

echo "202.103.24.68: {$dat['202.103.24.68']}\n";

$ip = ip2long('202.96.134.133');
echo "3395323525: {$dat[3395323525]}\n";

unset($dat);

echo "[MEMORY] Clean: " . memory_get_usage() . "\n";

try {
    $dat = new \larryli\monipdb\Monipdb('17monipdb.dat', false);
} catch (Exception $e) {
    die($e);
}

echo "[MEMORY] Dat: " . memory_get_usage() . "\n";

echo "Count: " . count($dat) . "\n";

foreach ($dat as $ip => $name) {
    echo "{$ip}: $name\n";
    break;
}

echo "202.103.24.68: {$dat['202.103.24.68']}\n";

echo "3395323525: {$dat[3395323525]}\n";

unset($dat);
echo "[MEMORY] Clean: " . memory_get_usage() . "\n";
