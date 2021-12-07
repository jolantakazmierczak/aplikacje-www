<?php
//$dbhost = 'localhost';
//$dbuser = 'root';
//$dbpass = '';
//$baza = 'moja_strona';
//
//$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $baza, 3306);
//if (!$mysqli) echo '<b>przerwane połączenie</b>';
//if (!mysqli_select_db($mysqli, $baza)) echo 'nie wybrano bazy';

$login = 'login';
$pass = 'pass';

function getMysqli(): mysqli
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';

    $mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $baza, 3306);
    if (!$mysqli) echo '<b>przerwane połączenie</b>';
    if (!mysqli_select_db($mysqli, $baza)) echo 'nie wybrano bazy';

    return $mysqli;
}

//function getMysqli(): mysqli
//{
//    $dbhost = 'localhost';
//    $dbuser = 'root';
//    $dbpass = '';
//    $baza = 'moja_strona';
//
//    $mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $baza, 3306);
//    if (!$mysqli) echo '<b>przerwane połączenie</b>';
//    if (!mysqli_select_db($mysqli, $baza)) echo 'nie wybrano bazy';
//
//    return $mysqli;
//}

//
//$sql = "SELECT * FROM page_list";
//
//if ($result = $mysqli->query($sql)) {
//    while ($row = $result->fetch_row()) {
//        //printf("%s (%s) (%s)\n", $row[0], $row[1], $row[2]);
//    }
//    $result->free_result();
//}


?>