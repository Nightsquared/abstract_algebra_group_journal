<?php
session_start();
$filename = 'grouptable.csv';

$group = $_SESSION['table'];
$csv = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');//5 MB

foreach($group as $array){
    fputcsv($csv, $array);
}

rewind($csv);
$outstr = stream_get_contents($csv);

header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Type: text/csv');
header('Content-Length: ' . strlen($outstr));
header('Connection: close');

echo $outstr;
?>