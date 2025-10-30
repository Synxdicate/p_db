<!-- connect.php -->
<?php
$user = 'root';
$password = 'root';
$db = 'washflow'; 
$host = 'localhost';
$port = 3306;

$link = mysqli_init();
if ($link === false) {
    die('mysqli_init failed');
}

$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);
if (!$success) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
// echo "Connected to database: " . $db;
?>
