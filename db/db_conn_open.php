<?php
/* Переменные для соединения с базой данных */
$hostname = "localhost";
$username = "root";
$password = "mypass";
$dbName = "auction_new";
/* создать соединение */

$conn = mysqli_connect( $hostname, $username, $password, $dbName) or die( "Не могу создать соединение ");

mysqli_set_charset($conn, 'utf8');

