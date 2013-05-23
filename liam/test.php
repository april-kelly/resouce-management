<?php
set_time_limit(0);
$i = 1212000000;
while (true) {

    $time_start = microtime();

    if (crc32(base64_encode($i)) == 323322056) {
        print "\r\nFound it! ".base64_encode($i)." ";
        $time_end = microtime();
        $time = $time_end-$time_start;
        print "in ".$time." microseconds ";
        exit;
    }

    print $i."\r";
    $i++;
}