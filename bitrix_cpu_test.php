<?php
require_once 'getmicrotime.php';

$res = array();
for ($j = 0; $j < 4; $j++) {
    $s1 = getmicrotime();
    for ($i = 0; $i < 1000000; $i++) {
    }
    $e1 = getmicrotime();
    $N1 = $e1 - $s1;


    $k = 0;
    $s2 = getmicrotime();
    for ($i = 0; $i < 1000000; $i++) {
        //This is one op
        $k++;
        $k--;
        $k++;
        $k--;
    }
    $e2 = getmicrotime();
    $N2 = $e2 - $s2;

    if ($N2 > $N1) {
        $res[] = 1 / ($N2 - $N1);
    }

}

$result_mark = round(array_sum($res) / doubleval(count($res)), 1);

echo "\e[35m++++++++++++++++++++++++++  CPU TEST ++++++++++++++++++++++++++\e[0m\n";
echo "Result mark: ";
if ($result_mark > 9) {
    echo "\e[32m$result_mark\e[0m\n";
} else {
    echo "\e[31m$result_mark\e[0m, recommended more than 9.0\n";
}
echo "\e[35m+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\e[0m\n";