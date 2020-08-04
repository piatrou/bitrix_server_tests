<?php   
function getmicrotime()
{
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
}


                $res = array();
                $file_name = "/tmp/perfmon#i#.php";
                $content = "<?\$s='".str_repeat("x", 1024)."';?><?/*".str_repeat("y", 1024)."*/?><?\$r='".str_repeat("z", 1024)."';?>";

                for ($j = 0; $j < 4; $j++)
                {
                        $s1 = getmicrotime();
                        for ($i = 0; $i < 100; $i++)
                        {
                                $fn = str_replace("#i#", $i, $file_name);
                        }
                        $e1 = getmicrotime();
                        $N1 = $e1 - $s1;

                        $s2 = getmicrotime();
                        for ($i = 0; $i < 100; $i++)
                        {
                                $fn = str_replace("#i#", $i, $file_name);
                                $fh = fopen($fn, "wb");
                                fwrite($fh, $content);
                                fclose($fh);
                                include($fn);
                                unlink($fn);
                        }
                        $e2 = getmicrotime();
                        $N2 = $e2 - $s2;

                        if ($N2 > $N1)
                                $res[] = 100 / ($N2 - $N1);
                }

                echo array_sum($res)."\n";
                echo doubleval(count($res))."\n";
                echo array_sum($res) / doubleval(count($res))."\n";