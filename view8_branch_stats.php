<?php
require_once 'connect.php';

$sql = "SELECT * FROM branch_booking_count_view ORDER BY total_bookings DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>สถิติการจองแต่ละสาขา</title>
</head>
<body>
    <h1>สถิติการจองแต่ละสาขา</h1>
    <a href="index.php">← กลับหน้าหลัก</a>
    
    <table border="1">
        <thead>
            <tr>
                <th>รหัสสาขา</th>
                <th>ชื่อสาขา</th>
                <th>ที่อยู่</th>
                <th>จองทั้งหมด</th>
                <th>เสร็จสิ้น</th>
                <th>รอดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['branch_ID']; ?></td>
                <td><?php echo $row['branch_name']; ?></td>
                <td><?php echo $row['branch_address']; ?></td>
                <td><?php echo $row['total_bookings']; ?></td>
                <td><?php echo $row['completed_bookings']; ?></td>
                <td><?php echo $row['pending_bookings']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
