<?php
require_once 'connect.php';

$branch_filter = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';

if ($branch_filter != '' && $branch_filter != 'all') {
    $sql = "SELECT * FROM booking_summary_view WHERE branch_name = (SELECT branch_name FROM branch WHERE branch_ID = $branch_filter) ORDER BY booking_date DESC";
} else {
    $sql = "SELECT * FROM booking_summary_view ORDER BY booking_date DESC";
}

$result = mysqli_query($link, $sql);

$branch_sql = "SELECT * FROM branch ORDER BY branch_name";
$branch_result = mysqli_query($link, $branch_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>สรุปการจอง</title>
</head>
<body>
    <h1>สรุปการจอง</h1>
    <a href="index.php">← กลับหน้าหลัก</a>
    
    <form method="GET" style="margin: 20px 0;">
        <label>กรองตามสาขา: </label>
        <select name="branch_id" onchange="this.form.submit()">
            <option value="all" <?php echo ($branch_filter == 'all' || $branch_filter == '') ? 'selected' : ''; ?>>
                ทุกสาขา
            </option>
            <?php while($branch = mysqli_fetch_assoc($branch_result)): ?>
                <option value="<?php echo $branch['branch_ID']; ?>" 
                        <?php echo ($branch_filter == $branch['branch_ID']) ? 'selected' : ''; ?>>
                    <?php echo $branch['branch_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>
    
    <table border="1">
        <thead>
            <tr>
                <th>รหัสจอง</th>
                <th>วันที่จอง</th>
                <th>สถานะ</th>
                <th>ชื่อลูกค้า</th>
                <th>เบอร์โทร</th>
                <th>สาขา</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = mysqli_num_rows($result);
            if($count == 0): 
            ?>
            <tr>
                <td colspan="6" style="text-align:center;">ไม่พบข้อมูล</td>
            </tr>
            <?php else: ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['booking_ID']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['booking_status']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['cust_tel']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p>พบ <?php echo $count; ?> รายการ</p>
</body>
</html>