<?php
require_once 'connect.php';

// รับค่า branch_id จาก GET parameter
$branch_filter = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';

// สร้าง SQL query
if ($branch_filter != '' && $branch_filter != 'all') {
    $sql = "SELECT * FROM employee_branch_role_view WHERE branch_ID = $branch_filter ORDER BY role_name";
} else {
    $sql = "SELECT * FROM employee_branch_role_view ORDER BY branch_name, role_name";
}

$result = mysqli_query($link, $sql);

// ดึงข้อมูลสาขาทั้งหมดสำหรับ dropdown
$branch_sql = "SELECT * FROM branch ORDER BY branch_name";
$branch_result = mysqli_query($link, $branch_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ข้อมูลพนักงาน</title>
</head>
<body>
    <h1>ข้อมูลพนักงาน</h1>
    <a href="index.php">← กลับหน้าหลัก</a>
    
    <!-- Filter Form -->
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
                <th>รหัสพนักงาน</th>
                <th>ชื่อพนักงาน</th>
                <th>ตำแหน่ง</th>
                <th>เงินเดือน (บาท)</th>
                <th>สาขา</th>
                <th>ที่อยู่สาขา</th>
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
                    <td><?php echo $row['emp_ID']; ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><?php echo $row['role_name'] ?? '-'; ?></td>
                    <td style="text-align: right;"><?php echo number_format($row['salary'] ?? 0, 2); ?></td>
                    <td><strong><?php echo $row['branch_name']; ?></strong></td>
                    <td><?php echo $row['branch_address']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p>พบ <strong><?php echo $count; ?></strong> รายการ</p>
</body>
</html>
