<?php

$login = 'admin';
$password = 'admin';

$databaseHost = '127.0.0.1';
$databaseName = '';
$databaseUsername = 'root';
$databasePassword = '';
$port = 3306;

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, '', 8091);
mysqli_select_db($mysqli, 'moja_strona');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

?>
