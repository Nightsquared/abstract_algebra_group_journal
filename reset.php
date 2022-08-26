<?php
session_start();
unset($_SESSION['table']);
$groupcsvfp = 'group.csv';
$groupcsv = fopen($groupcsvfp, 'r');
$group = array();

while (($data = fgetcsv($groupcsv)) !== false){
    $group[] = $data;
}

$_SESSION['table'] = $group;
echo 'The table has been reset.';
?>