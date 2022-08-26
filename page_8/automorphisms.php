<?php
session_start();
require_once('../constants.php');
if (empty($_SESSION['automorphisms']) || isset($_POST['resetautomorphisms'])) {
    //load table
    $automorphismscsvfp = '../automorphisms.csv';
    $automorphismscsv = fopen($automorphismscsvfp, 'r');
    $automorphisms = array();

    while (($data = fgetcsv($automorphismscsv)) !== false) {
        $automorphisms[] = $data;
    }
    $_SESSION['automorphisms'] = $automorphisms;
} else {
    $automorphisms = $_SESSION['automorphisms'];
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
for ($i = 0; $i < count($automorphisms); $i++) {
    if ($i < 9) {
        //echo "<th>" . strval($i + 1) . "</th>";
    } else {
        //echo "<th>" . strval($i + 1) . "</th>";
    }
}
echo '</tr>';
$i = 0;
foreach ($automorphisms as $row) {
    echo "<tr>";
    echo "<th>" . strval($i + 1) . "</th>";
    foreach ($row as $entry) {
        $entry = trim($entry);
        echo '<th style = "background-color:' . COLORS[$entry] . ';">' . strval($entry) . "</th>";
    }
    echo "</tr>";
    $i += 1;
}
echo "<table>"
?>