<?php
session_start();
require_once('../constants.php');
if(isset($_POST['orderedreset'])){
    $groupcsvfp = '../orderedgroup.csv';
    $groupcsv = fopen($groupcsvfp, 'r');
    $group = array();

    while (($data = fgetcsv($groupcsv)) !== false) {
        $group[] = $data;
    }
    $_SESSION['table'] = $group;
} else if (empty($_SESSION['table']) || isset($_POST['reset'])) {
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

if (!empty($_POST['swap1']) && !empty($_POST['swap2'])) {
    $swap1 = intval($_POST['swap1']) - 1;
    $swap2 = intval($_POST['swap2']) - 1;
    if ($swap1 < 16 && $swap2 < 16 && $swap1 >= 0 && $swap2 >= 0) {
        $hold = $group[$swap1];
        $group[$swap1] = $group[$swap2];
        $group[$swap2] = $hold;
        for ($i = 0; $i < count($group); $i++) {
            $hold = $group[$i][$swap1];
            $group[$i][$swap1] = $group[$i][$swap2];
            $group[$i][$swap2] = $hold;
        }
        $_SESSION['table'] = $group;
    }
}

?>
<style>
th{
    width: 30px;
    height: 30px;
}
</style>
<p>Select two column numbers to swap columns and rows.</p>
<form action='cayleytable.php' method='POST'>
    <label for="swap1">First element to swap:</label>
    <select id="swap1" name="swap1"><br>
    <?php
    for ($i = 1; $i <= count($group); $i++) {
        if ($i-1 == $swap1) {
            echo "<option selected value='$i'>$i</option>";
        } else {
            echo "<option value='$i'>$i</option>";
        }
    }
    ?>
    </select><br>
    <label for="lname">Second element to swap:</label>
    <select id="swap2" name="swap2">
    <?php
    for ($i = 1; $i <= count($group); $i++) {
        if ($i-1 == $swap2) {
            echo "<option selected value='$i'>$i</option>";
        } else {
            echo "<option value='$i'>$i</option>";
        }
    }
    ?>
    </select><br><br>
    <input type="submit" value="Swap"><br>
</form>
<?php
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
foreach ($group as $row) {
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
<br>
<form action='cayleytable.php' method='post'>
    <input type="hidden" id="reset" name="reset" value='true'>
    <input type="submit" value="Reset table">
</form>
<br>
<br>
<form action='cayleytable.php' method='post'>
    <input type="hidden" id="orderedreset" name="orderedreset" value='true'>
    <input type="submit" value="Sort table">
</form>
<br>
<br>
<form action='exporttable.php'>
    <input type="submit" value="Export table as CSV">
</form>
<br>
<br>
<!--
<form action="cayleytable.php" method='post' enctype="multipart/form-data">
  <label for="importfile">Import table as csv:</label><br>
  <input type="file" id="importfile" name="importfile" accept='.csv, text/csv'><br>
  <input type="submit">
</form>
-->