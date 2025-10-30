<?php
require_once 'connect.php';

$branch_filter = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';

if ($branch_filter != '' && $branch_filter != 'all') {
    $sql = "SELECT * FROM active_services_view WHERE branch_ID = $branch_filter ORDER BY service_startdate DESC";
} else {
    $sql = "SELECT * FROM active_services_view ORDER BY service_startdate DESC";
}

$result = mysqli_query($link, $sql);

$branch_sql = "SELECT * FROM branch ORDER BY branch_name";
$branch_result = mysqli_query($link, $branch_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>บริการที่กำลังดำเนินการ</title>
</head>
<body>
    <h1>บริการที่กำลังดำเนินการ</h1>
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
                <th>รหัสบริการ</th>
                <th>ชื่อลูกค้า</th>
                <th>เบอร์โทร</th>
                <th>ทะเบียนรถ</th>
                <th>สีรถ</th>
                <th>ประเภทรถ</th>
                <th>สถานะ</th>
                <th>เริ่มเมื่อ</th>
                <th>สาขา</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = mysqli_num_rows($result);
            if($count == 0): 
            ?>
            <tr>
                <td colspan="9" style="text-align:center; padding: 20px;">
                    ไม่มีบริการที่กำลังดำเนินการ
                </td>
            </tr>
            <?php else: ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['service_ID']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['cust_tel']; ?></td>
                    <td><?php echo $row['vehicle_plate']; ?></td>
                    <td><?php echo $row['vehicle_color']; ?></td>
                    <td><?php echo $row['vtype_name']; ?></td>
                    <td><strong><?php echo $row['service_status']; ?></strong></td>
                    <td><?php echo $row['service_startdate']; ?></td>
                    <td><strong><?php echo $row['branch_name']; ?></strong></td>
                </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p>พบ <strong><?php echo $count; ?></strong> รายการที่กำลังดำเนินการ</p>
</body>
</html>