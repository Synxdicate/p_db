<?php
$user = 'root';
$password = 'root';
$db = 'washflow'; 

$host = 'mysql';
$port = 3306;

$link = mysqli_init();
if (!$link) {
    die('mysqli_init failed');
}

if (!mysqli_real_connect($link, $host, $user, $password, $db, $port)) {
    die('Connect Error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}

// ใช้เช็ค connector
//echo "Connected to database '$db' at $host:$port";
?>

