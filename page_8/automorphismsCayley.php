<?php
session_start();
require_once('../constants.php');
$colorsarray = array();
foreach(COLORS as $key => $color){
    $colorsarray[] = $color;
}
if (empty($_SESSION['automorphismscayley']) || isset($_POST['resetautomorphisms'])) {
    //load table
    $automorphismscsvfp = '../autoCayleyTable.csv';
    $automorphismscsv = fopen($automorphismscsvfp, 'r');
    $automorphismscayley = array();

    while (($data = fgetcsv($automorphismscsv)) !== false) {
        $automorphismscayley[] = $data;
    }
    $_SESSION['automorphismscayley'] = $automorphismscayley;
} else {
    $automorphismscayley = $_SESSION['automorphismscayley'];
}
?>
<style>
th{
    width: 30px;
    height: 30px;
}
</style>

<?php
echo "<table><tr><th></th>";
for ($i = 0; $i < count($automorphismscayley); $i++) {
    if ($i < 9) {
        //echo "<th>" . strval($i + 1) . "</th>";
    } else {
        //echo "<th>" . strval($i + 1) . "</th>";
    }
}
echo '</tr>';
$i = 0;
foreach ($automorphismscayley as $row) {
    echo "<tr>";
    echo "<th>" . strval($i + 1) . "</th>";
    foreach ($row as $entry) {
        $entry = trim($entry);
        echo '<th style = "background-color:' . $colorsarray[$entry] . ';">' . strval($entry+1) . "</th>";
    }
    echo "</tr>";
    $i += 1;
}
echo "<table>"
?>