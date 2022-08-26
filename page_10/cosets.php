<?php
session_start();
require_once('../constants.php');
if (empty($_SESSION['table']) || isset($_POST['reset'])) {
    //load table
    $groupcsvfp = '../group.csv';
    $groupcsv = fopen($groupcsvfp, 'r');
    $group = array();

    while (($data = fgetcsv($groupcsv)) !== false) {
        $group[] = $data;
    }
    $_SESSION['table'] = $group;
    fclose($groupcsv);
} else {
    $group = $_SESSION['table'];
}
?>
<style>
th{
    width: 30px;
    height: 30px;
}
</style>
<p>The tables generated by this page will have elements ordered in the same way as the <a href="https://alexscully.com/archive/aa_group_journal/page_1/cayleytable.php">Cayley table page</a>.</p>

<?php
$subgroups = array(
    array('2'),
    array('2', '8'),
    array('2', '6'),
    array('2', 'a'),
    array('2', '1'),
    array('2', '8', '6', '1'),
    array('2', '5'),
    array('2', '8', 'a', '5'),
    array('2', '3'),
    array('2', '6', 'a', '3'),
    array('2', '1', '5', '3'),
    array('2', 'h'),
    array('2', 'a', '1', 'h'),
    array('2', '6', '5', 'h'),
    array('2', '8', '3', 'h'),
    array('2', '8', '6', 'a', '1', '5', '3', 'h'),
    array('2', 'a', 'd', '4'),
    array('2', 'a', 'g', 'c'),
    array('2', '8', 'a', '5', 'd', '4', 'g', 'c'),
    array('2', '5', 'i', 'b'),
    array('2', '5', 'f', '7'),
    array('2', '8', 'a', '5', 'i', 'b', 'f', '7'),
);
sort($subgroups);
if(empty($_POST)){
    echo '<p>Select a group to view cosets of:</p>';
    echo '<form method="post" action="cosets.php">';
    foreach($subgroups as $subgroup){
        $subgroupname = implode('',$subgroup);
        $subgroupcommas = implode(',',$subgroup);
        echo "<td><input type='radio' id='$subgroupname' name='radios' value='$subgroupcommas'></td>";
        echo "<table>";
        $i = 0;
        $issubgroup = true;
        foreach ($group as $row) {
            if(in_array($group[0][$i], $subgroup)){
                echo "<tr>";
                $j = 0;
                foreach ($row as $entry) {
                    $entry = trim($entry);
                    if(in_array($group[0][$j], $subgroup)){
                        echo '<th style = "background-color:' . COLORS[$entry] . ';">' . strval($entry) . "</th>";
                        if(!in_array($entry, $subgroup)){
                            $issubgroup = false;
                        }
                    }
                    $j += 1;
                }
                echo "</tr>";
            }
            $i += 1;
        }
        echo "</table><br>";
    }
    echo '<br><input type="submit" value="view cosets"><br>';
    echo '</form>';
} else {
    $groupdict = array();
    $groupcsv = fopen($groupcsvfp, 'r');

    $groupdict['2'] = fgetcsv($groupcsv);
    $count = 1;
    while (($data = fgetcsv($groupcsv)) !== false) {
        $data2 = [];
        foreach($data as $key=>$value){
            $data2[$groupdict['2'][$key]] = $value;
        }
        $groupdict[$groupdict['2'][$count]] = $data2;
        $count += 1;
    }
    $data2 = [];
    foreach($groupdict['2'] as $key=>$value){
        $data2[$groupdict['2'][$key]] = $value;
    }
    $groupdict['2'] = $data2;
    $selectedgroup = explode(',', $_POST['radios']);
    //left cosets
    $elements = $groupdict['2'];
    foreach($elements as $element){
        echo '<br>';
        echo "<p>Left coset of ".$_POST['radios']." under $element:</p>";
        $leftcoset = [];
        foreach($selectedgroup as $groupelement){
            $entry = $groupdict[$element][$groupelement];
            $leftcoset[] = '<th style = "background-color:' . COLORS[$entry] . ';">' . strval($entry) . "</th>";
        }
        sort($leftcoset);
        echo "<table><tr>";
        echo implode("", $leftcoset);
        echo "</table></tr>";
    }

    foreach($elements as $element){
        echo '<br>';
        echo "<p>Right coset of ".$_POST['radios']." under $element:</p>";
        $rightcoset = [];
        foreach($selectedgroup as $groupelement){
            $entry = $groupdict[$groupelement][$element];
            $rightcoset[] = '<th style = "background-color:' . COLORS[$entry] . ';">' . strval($entry) . "</th>";
        }
        sort($rightcoset);
        echo "<table><tr>";
        echo implode("", $rightcoset);
        echo "</table></tr>";
    }
}
?>