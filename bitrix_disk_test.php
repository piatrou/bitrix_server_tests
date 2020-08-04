<?php
function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float) $usec + (float) $sec);
}

define('ITERATIONS', 100);
define('ITERATIONS_COUNT', 4);

$res = array();
$file_name = "/tmp/perfmon#i#.php";
$content = "<?\$s='" . str_repeat("x", 1024) . "';?><?/*" . str_repeat("y", 1024) . "*/?><?\$r='" . str_repeat("z", 1024) . "';?>";

for ($j = 0; $j < ITERATIONS_COUNT; $j++) {

    $open_time = 0;
    $open_start = 0;
    $write_time = 0;
    $write_start = 0;
    $close_time = 0;
    $close_start = 0;
    $include_time = 0;
    $include_start = 0;
    $remove_time = 0;
    $remove_start = 0;

    $s1 = getmicrotime();
    for ($i = 0; $i < ITERATIONS; $i++) {
        $open_start = getmicrotime();
        $write_start = getmicrotime();
        $close_start = getmicrotime();
        $include_start = getmicrotime();
        $remove_start = getmicrotime();
        $fn = str_replace("#i#", $i, $file_name);
        $open_time = getmicrotime() - $open_start;
        $write_time = getmicrotime() - $write_start;
        $close_time = getmicrotime() - $close_start;
        $include_time = getmicrotime() - $include_start;
        $remove_time = getmicrotime() - $remove_start;
    }

    $e1 = getmicrotime();
    $N1 = $e1 - $s1;

    $s2 = getmicrotime();
    for ($i = 0; $i < ITERATIONS; $i++) {
        $fn = str_replace("#i#", $i, $file_name);

        $open_start = getmicrotime();
        $fh = fopen($fn, "wb");
        $open_time = getmicrotime() - $open_start;

        $write_start = getmicrotime();
        fwrite($fh, $content);
        $write_time = getmicrotime() - $write_start;

        $close_start = getmicrotime();
        fclose($fh);
        $close_time = getmicrotime() - $close_start;

        $include_start = getmicrotime();
        include $fn;
        $include_time = getmicrotime() - $include_start;

        $remove_start = getmicrotime();
        unlink($fn);
        $remove_time = getmicrotime() - $remove_start;
    }
    $e2 = getmicrotime();
    $N2 = $e2 - $s2;

    $open[] = $open_time / ITERATIONS;
    $write[] = $write_time / ITERATIONS;
    $close[] = $close_time / ITERATIONS;
    $include[] = $include_time / ITERATIONS;
    $remove[] = $remove_time / ITERATIONS;

    if ($N2 > $N1) {
        $res[] = ITERATIONS / ($N2 - $N1);
    }

}

echo "\e[35m++++++++++++++++++++++++++ DISK TEST ++++++++++++++++++++++++++\e[0m\n";
echo "Result mark: ";
$result_mark = round(array_sum($res) / doubleval(count($res)), 1);

if ($result_mark > 10000) {
    echo "\e[32m$result_mark\e[0m\n";
} else {
    echo "\e[31m$result_mark\e[0m, recommended more than 10000\n";
}
echo 'Open time: ' . round((array_sum($open) / doubleval(count($open))) * 1000000000, 3) . " µs \n";
echo 'Write time: ' . round((array_sum($write) / doubleval(count($write))) * 1000000000, 3) . " µs \n";
echo 'Close time: ' . round((array_sum($close) / doubleval(count($close))) * 1000000000, 3) . " µs \n";
echo 'Include time: ' . round((array_sum($include) / doubleval(count($include))) * 1000000000, 3) . " µs \n";
echo 'Remove time: ' . round((array_sum($remove) / doubleval(count($remove))) * 1000000000, 3) . " µs \n";
echo "\e[35m+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\e[0m\n";
