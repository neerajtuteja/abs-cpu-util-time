/*
Copyright (C) 2014 by Neeraj Tuteja

Permission is hereby granted, free of charge, to any person obtaining a copyof this software and associated documentation files (the "Software"), to dealin the Software without restriction, including without limitation the rightsto use, copy, modify, merge, publish, distribute, sublicense, and/or sellcopies of the Software, and to permit persons to whom the Software isfurnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included inall copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS ORIMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THEAUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHERLIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS INTHE SOFTWARE.
*/

<?php
$process_id = '1941';  # Process id is figured out using `ps -aux | grep <process-name>`

$fh = fopen('/proc/stat', "r");
$line  = fgets($fh,4096);
$arr = explode(" ", $line);
$time_total_before=0;
for($i=1;$i<sizeof($arr);++$i){
  $time_total_before+= (int)$arr[$i];
}
$fh = fopen('/proc/'.$process_id.'/stat', "r");
$line  = fgets($fh,4096);
$arr = explode(" ", $line);
$utime_before=(int)$arr[13];
$stime_before=(int)$arr[14];

sleep(1);

$fh = fopen('/proc/stat', "r");
$line  = fgets($fh,4096);
$arr = explode(" ", $line);
$time_total_after=0;
for($i=1;$i<sizeof($arr);++$i){
  $time_total_after+= (int)$arr[$i];
}
$fh = fopen('/proc/'.$process_id.'/stat', "r");
$line  = fgets($fh,4096);
$arr = explode(" ", $line);
$utime_after=(int)$arr[13];
$stime_after=(int)$arr[14];


$user_util = 100 * ($utime_after - $utime_before) / ($time_total_after - $time_total_before);
$sys_util = 100 * ($stime_after - $stime_before) / ($time_total_after - $time_total_before);



echo "\nBefore: User Utilization Time =  $utime_before, System Utilization Time = $stime_before, Total Utilization Time = $time_total_before\n";
echo "\nAfter: User Utilization Time =  $utime_after, System Utilization Time = $stime_after, Total Utilization Time = $time_total_after\n";
echo "\nUser Utilization Time = ".$user_util."\n";
echo "\nSystem Utilization Time = ".$sys_util."\n";


?>
