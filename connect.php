<?php
$user = 'root';
$password = 'root';
$db = 'washflow'; 

// เปลี่ยนจาก 127.0.0.1 เป็น mysql (ชื่อ service ใน docker-compose)
$host = 'mysql';
$port = 3306; // ใน Docker network ใช้ port 3306

$link = mysqli_init();
if (!$link) {
    die('mysqli_init failed');
}

if (!mysqli_real_connect($link, $host, $user, $password, $db, $port)) {
    die('Connect Error (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}

//echo "Connected to database '$db' at $host:$port";
?>

