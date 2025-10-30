<?php
require_once 'connect.php';

$branch_filter = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';

if ($branch_filter != '' && $branch_filter != 'all') {
    $sql = "SELECT * FROM service_detail_summary_view WHERE branch_ID = $branch_filter ORDER BY service_ID, sdetail_ID";
} else {
    $sql = "SELECT * FROM service_detail_summary_view ORDER BY service_ID, sdetail_ID";
}

$result = mysqli_query($link, $sql);

$branch_sql = "SELECT * FROM branch ORDER BY branch_name";
$branch_result = mysqli_query($link, $branch_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>รายละเอียดบริการ</title>
</head>
<body>
    <h1>รายละเอียดบริการ</h1>
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
                <th>รหัส</th>
                <th>รหัสบริการ</th>
                <th>ชื่อลูกค้า</th>
                <th>ทะเบียนรถ</th>
                <th>ประเภทบริการ</th>
                <th>จำนวน</th>
                <th>ราคา (บาท)</th>
                <th>พนักงาน</th>
                <th>สาขา</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = mysqli_num_rows($result);
            $total = 0;
            if($count == 0): 
            ?>
            <tr>
                <td colspan="9" style="text-align:center;">ไม่พบข้อมูล</td>
            </tr>
            <?php else: ?>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    $total += $row['sdetail_price'];
                ?>
                <tr>
                    <td><?php echo $row['sdetail_ID']; ?></td>
                    <td><?php echo $row['service_ID']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td><?php echo $row['vehicle_plate']; ?></td>
                    <td><?php echo $row['Type_serviceName']; ?></td>
                    <td style="text-align: center;"><?php echo $row['sdetail_quantity']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($row['sdetail_price'], 2); ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><strong><?php echo $row['branch_name']; ?></strong></td>
                </tr>
                <?php endwhile; ?>
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td colspan="6" style="text-align: right;">รวมทั้งหมด:</td>
                    <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                    <td colspan="2"></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p>พบ <strong><?php echo $count; ?></strong> รายการ | ยอดรวม <strong><?php echo number_format($total, 2); ?></strong> บาท</p>
</body>
</html>