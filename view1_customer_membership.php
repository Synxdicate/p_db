<?php
require_once 'connect.php';

$sql = "SELECT * FROM customer_membership_view ORDER BY cust_ID";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ข้อมูลลูกค้าและสมาชิก</title>
</head>
<body>
    <h1>ข้อมูลลูกค้าและสมาชิก</h1>
    <a href="index.php">← กลับหน้าหลัก</a>
    
    <table border="1">
        <thead>
            <tr>
                <th>รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>เบอร์โทร</th>
                <th>ที่อยู่</th>
                <th>ระดับสมาชิก</th>
                <th>คะแนนสะสม</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['cust_ID']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['cust_tel']; ?></td>
                <td><?php echo $row['cust_address']; ?></td>
                <td><?php echo $row['membership_name'] ?? '-'; ?></td>
                <td><?php echo $row['membership_point'] ?? '0'; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
