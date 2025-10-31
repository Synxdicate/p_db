<?php
$user = 'root';
$password = '1998';
$db = 'washflow'; 

$host = '127.0.0.1';
$port = 3307;

$link = mysqli_init();
if (!$link) {
    die('mysqli_init failed');
}

if (!mysqli_real_connect($link, $host, $user, $password, $db, $port)) {
    die('Connect Error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}

//echo "✅ Connected to database '$db' at $host:$port";
?>

