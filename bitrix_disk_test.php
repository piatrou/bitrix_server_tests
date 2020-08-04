<?php
ini_set('short_open_tag', 'On');              
$file_name = __DIR__."test#i#.php";
$content = "<?\$s='".str_repeat("x", 1024)."';?><?/*".str_repeat("y", 1024)."*/?><?\$r='".str_repeat("z", 1024)."';?>";

$s1 = microtime(true);
$open1 = 0;
$open2 = 0;
$write1 = 0;
$write2 = 0;
$close1 = 0;
$close2 = 0;
$include1 = 0;
$include2 = 0;
$unlink1 = 0;
$unlink2 = 0;

            for ($i = 0; $i < 1000; $i++) {
                $fn = str_replace("#i#", $i, $file_name);
                $open1t = microtime(true);
                $fh = fopen($fn, "wb");
                $open2t = microtime(true);
                $write1t = microtime(true);
                fwrite($fh, $content);
                $write2t = microtime(true);
                $close1t = microtime(true);
                fclose($fh);
                $close2t = microtime(true);
                $include1t = microtime(true);
                include($fn);
                $include2t = microtime(true);
                $unlink1t = microtime(true);
                unlink($fn);
                $unlink2t = microtime(true);
                $open1 += $open1t;
                $open2 += $open2t;
                $write1 += $write1t;
                $write2 += $write2t;
                $close1 += $close1t;
                $close2 += $close2t;
                $include1 += $include1t;
                $include2 += $include2t;
                $unlink1 += $unlink1t;
                $unlink2 += $unlink2t;
            }
$e1 = microtime(true);
echo 'all: '.($e1 - $s1)." <br>\n";
echo 'open: '.($open2 - $open1)." <br>\n";
echo 'write: '.($write2 - $write1)." <br>\n";
echo 'close: '.($close2 - $close1)." <br>\n";
echo 'include: '.($include2 - $include1)." <br>\n";
echo 'unlink: '.($unlink2 - $unlink1)." <br>\n";

