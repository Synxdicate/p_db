<?php
require_once 'connect.php';

$sql = "SELECT * FROM service_type_pricing_view ORDER BY Type_serviceID, vtype_ID";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ตารางราคาบริการ</title>
</head>
<body>
    <h1>ตารางราคาบริการ</h1>
    <a href="index.php">← กลับหน้าหลัก</a>
    
    <table border="1">
        <thead>
            <tr>
                <th>ประเภทบริการ</th>
                <th>ราคาพื้นฐาน</th>
                <th>ประเภทรถ</th>
                <th>ตัวคูณ</th>
                <th>ราคาจริง</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['Type_serviceName']; ?></td>
                <td><?php echo number_format($row['Type_serviceBasePrice'], 2); ?></td>
                <td><?php echo $row['vtype_name']; ?></td>
                <td><?php echo $row['vtype_multiplier']; ?></td>
                <td><strong><?php echo number_format($row['calculated_price'], 2); ?></strong></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
