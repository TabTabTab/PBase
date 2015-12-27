<?php
    include_once '../src/errors.php';
    include_once '../src/database.php';

    $sql = 'SELECT testEntry, additional FROM TestTable WHERE testEntry != :value1';
    $values = array(':value1' => 'n');
    $result = singleQuery($sql, $values, array('testEntry', 'additional'));
    foreach($result as $r){
        foreach($r as $rv){
            echo $rv;
        }
    }
    $select_columns = array('testEntry', 'additional');
    $from_sql = 'TestTable';
    $where_sql = 'testEntry != :value1';
    $condition_values = array(':value1' => 'n');
    $result = SFWQuery($select_columns, $from_sql, $where_sql, $condition_values);
    foreach($result as $r){
        foreach($r as $rv){
            echo $rv;
        }
    }
    echo "<p>done</p>";
?>
