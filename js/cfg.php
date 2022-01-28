<?php

$login = 'admin';
$password = 'admin';

$databaseHost = '127.0.0.1';
$databaseName = '';
$databaseUsername = 'root';
$databasePassword = '';
$port = 33006;

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, '', $port);
mysqli_select_db($mysqli, 'moja_strona');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

?>
