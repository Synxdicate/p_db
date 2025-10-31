<?php
require_once 'connect.php';

$branch_filter = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';

if ($branch_filter != '' && $branch_filter != 'all') {
    $sql = "SELECT * FROM payment_receipt_view WHERE branch_ID = $branch_filter ORDER BY payment_date";
} else {
    $sql = "SELECT * FROM payment_receipt_view ORDER BY payment_date";
}

$result = mysqli_query($link, $sql);

$branch_sql = "SELECT * FROM branch ORDER BY branch_name";
$branch_result = mysqli_query($link, $branch_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>การชำระเงินและใบเสร็จ</title>
</head>
<body>
    <h1>การชำระเงินและใบเสร็จ</h1>
    <a href="index.php">หน้าหลัก</a>
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
                <th>รหัสการชำระ</th>
                <th>ชื่อลูกค้า</th>
                <th>จำนวนเงิน (บาท)</th>
                <th>วันที่ชำระ</th>
                <th>วิธีชำระ</th>
                <th>เลขใบเสร็จ</th>
                <th>หมายเหตุ</th>
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
                <td colspan="8" style="text-align:center;">ไม่พบข้อมูล</td>
            </tr>
            <?php else: ?>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    $total += $row['payment_amount'];
                ?>
                <tr>
                    <td><?php echo $row['payment_ID']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($row['payment_amount'], 2); ?></td>
                    <td><?php echo $row['payment_date']; ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo $row['receipt_number'] ?? '-'; ?></td>
                    <td><?php echo $row['receipt_description'] ?? '-'; ?></td>
                    <td><strong><?php echo $row['branch_name']; ?></strong></td>
                </tr>
                <?php endwhile; ?>
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td colspan="2" style="text-align: right;">รวมทั้งหมด:</td>
                    <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                    <td colspan="5"></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p>พบ <strong><?php echo $count; ?></strong> รายการ | ยอดรวม <strong><?php echo number_format($total, 2); ?></strong> บาท</p>
</body>
</html>
