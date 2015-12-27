<?php

include_once '../config.php';

function connection()
{
    global $database_host, $database_name,
        $database_username, $database_user_password;
    try{
        $dbh = new PDO("mysql:host={$database_host};dbname={$database_name}", $database_username, $database_user_password);
    }//to handle connection error
    catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
    }
    return $dbh;
}
/*
    Executes a query on the database.

    @params
        $sql             - The sql query, where each value is described using :val_name.
        $values          - A map for the values to be inserted as such (':val_name' => 'value')
        $column_names    - The columns that should be included in the resulting map.
    @return
        a list with a map for each row.
            each map contains the values specified in $column names.

    @example
        $sql = 'SELECT testEntry, additional FROM TestTable WHERE testEntry != :value1';
        $values = array(':value1' => 'n');
        $result = singleQuery($sql, $values, array('testEntry', 'additional'));
*/
function singleQuery($sql, $values, $column_names){

    $dbh = connection();
    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute($values);
    $result = array();
    $i = 0;
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $col = array();
        foreach($column_names as $col_name){
            $col[$col_name] = $row[$col_name];
        }
        $result[$i] = $col;
        $i += 1;
    }
    return $result;
}

/*
    Executes a query on the database.
    
    @params
        $select_columns      - An array containing the columns that should be included in the resulting map.
        $from_sql            - The from concition
        $where_sql           - The where condition
        $tail_sql            - Any additional sql that should papear last in the query 
        $condition_values    - A map for the values to be inserted as such (':val_name' => 'value'),
                                This map is shared through the shole statement.
    @return
        a list with a map for each row.
            each map contains the values specified in $column names.

    @example
        $select_columns = array('testEntry', 'additional');
        $from_sql = 'TestTable';
        $where_sql = 'testEntry != :value1';
        $condition_values = array(':value1' => 'n');
        $result = SFWQuery($select_columns, $from_sql, $where_sql, $condition_values);
*/
function SFWQuery($select_columns, $from_sql, $where_sql='', $condition_values=array(), $tail_sql=''){
    $select_sql = 'SELECT '.join(', ', $select_columns);
    $sql = "".join(" ", array($select_sql, "FROM", $from_sql, 'WHERE', $where_sql, $tail_sql));
    return singleQuery($sql, $condition_values, $select_columns);
}

?>
