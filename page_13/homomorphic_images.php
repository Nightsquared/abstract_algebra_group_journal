<?php
session_start();
require_once('../constants.php');
if (empty($_SESSION['table'])) {
    //load table
    $groupcsvfp = '../group.csv';
    $groupcsv = fopen($groupcsvfp, 'r');
    $group = array();

    while (($data = fgetcsv($groupcsv)) !== false) {
        $group[] = $data;
    }
    $_SESSION['table'] = $group;
} else {
    $group = $_SESSION['table'];
}
$factorgroups = array(
    '2'=>[['2'], ['8'], ['5'], ['a'], ['6'], ['1'], ['h'], ['3'], ['g'], ['d'], ['4'], ['c'], ['i'], ['f'], ['b'], ['7']],
    '28'=>[['2', '8'], ['5', 'a'], ['6', '1'], ['h', '3'], ['d', 'g'], ['4', 'c'], ['i', 'f'], ['7', 'b']],
    '25'=>[['2', '5'], ['a', '8'], ['h', '6'], ['1', '3'], ['4', 'g'], ['c', 'd'], ['b', 'i'], ['7', 'f']],
    '2a'=>[['2', 'a'], ['5', '8'], ['6', '3'], ['h', '1'], ['c', 'g'], ['4', 'd'], ['7', 'i'], ['b', 'f']],
    '285a'=>[['2', '5', 'a', '8'], ['h', '6', '1', '3'], ['d', '4', 'g', 'c'], ['7', 'b', 'i', 'f']],
    '2861'=>[['2', '6', '1', '8'], ['h', '5', 'a', '3'], ['d', 'i', 'g', 'f'], ['7', 'b', '4', 'c']],
    '28h3'=>[['2', 'h', '3', '8'], ['1', '6', '5', 'a'], ['7', 'd', 'b', 'g'], ['f', 'i', '4', 'c']],
    '285a61h3'=>[['a', '1', '8', 'h', '6', '3', '2', '5'], ['d', '7', 'i', 'f', 'b', '4', 'g', 'c']],
    '285agcd4'=>[['a', 'd', '8', 'c', 'g', '4', '2', '5'], ['7', 'i', '1', 'f', 'h', 'b', '6', '3']],
    '285aibf7'=>[['a', '7', 'i', '8', 'f', 'b', '2', '5'], ['d', '1', 'h', '6', 'c', '3', 'g', '4']],
    '285a61h3gcd4ibf7'=>[['a', 'd', '7', 'i', '1', '8', 'f', 'h', 'b', '6', 'g', '3', '2', 'c', '4', '5']],
);
?>
<style>
th{
    width: 30px;
    height: 30px;
}
</style>
<?php
$tablelookup = array_flip($group[0]);
foreach($factorgroups as $normalgroup=>$factorgroup){
    $lookup = array();
    $remadegroup = array();
    foreach($factorgroup as $val => $set){
        foreach($set as $element){
            $lookup[$element] = $val;
            $remadegroup[] = $element;
        }
    }
    $remadegroup2 = array();
    foreach($remadegroup as $element){
        foreach($remadegroup as $element2){
            $remadegroup2[$element][$element2] = $group[$tablelookup[$element]][$tablelookup[$element2]];
        }
    }
    $normalgroup = implode(', ', str_split($normalgroup));
    echo "Homomorphic image of $normalgroup";
    echo "<table><tr><th></th>";
    for ($i = 0; $i < count($group); $i++) {
        if ($i < 9) {
            echo "<th>" . strval($i + 1) . "</th>";
        } else {
            echo "<th>" . strval($i + 1) . "</th>";
        }
    }
    echo '</tr>';
    $i = 0;
    foreach ($remadegroup2 as $row) {
        echo "<tr>";
        echo "<th>" . strval($i + 1) . "</th>";
        foreach ($row as $entry) {
            $entry = trim($entry);
            echo '<th style = "background-color:' . ALTCOLORS[$lookup[$entry]] . ';">' . strval($entry) . "</th>";
        }
        echo "</tr>";
        $i += 1;
    }
    echo "<table><br>";
}
?>