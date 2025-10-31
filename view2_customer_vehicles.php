<?php
require_once 'connect.php';

$sql = "SELECT * FROM customer_vehicles_view ORDER BY cust_ID, vehicle_ID";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>รถของลูกค้า</title>
</head>
<body>
    <h1>รถของลูกค้า</h1>
    <a href="index.php">← กลับหน้าหลัก</a>
    
    <table border="1">
        <thead>
            <tr>
                <th>รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>รหัสรถ</th>
                <th>ทะเบียนรถ</th>
                <th>สีรถ</th>
                <th>ประเภทรถ</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['cust_ID']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['vehicle_ID']; ?></td>
                <td><?php echo $row['vehicle_plate']; ?></td>
                <td><?php echo $row['vehicle_color']; ?></td>
                <td><?php echo $row['vehicletype_name']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
