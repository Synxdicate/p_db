<?php
require_once 'connect.php';

// Insert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    $table = $_POST['table'];
    switch ($table) {
        case 'branch':
            $stmt = $link->prepare("INSERT INTO branch (branch_name, branch_address) VALUES (?, ?)");
            $stmt->bind_param("ss", $_POST['branch_name'], $_POST['branch_address']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'customer':
            $stmt = $link->prepare("INSERT INTO customer (cust_fname, cust_lname, cust_tel, cust_address, cust_username, cust_password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $_POST['cust_fname'], $_POST['cust_lname'], $_POST['cust_tel'], $_POST['cust_address'], $_POST['cust_username'], $_POST['cust_password']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'vehicle_type':
            $stmt = $link->prepare("INSERT INTO vehicle_type (vtype_name, vtype_multiplier) VALUES (?, ?)");
            $stmt->bind_param("sd", $_POST['vtype_name'], $_POST['vtype_multiplier']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'service_type':
            $stmt = $link->prepare("INSERT INTO service_type (Type_serviceName, Type_serviceBasePrice) VALUES (?, ?)");
            $stmt->bind_param("sd", $_POST['Type_serviceName'], $_POST['Type_serviceBasePrice']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'role':
            $stmt = $link->prepare("INSERT INTO role (role_name, salary) VALUES (?, ?)");
            $stmt->bind_param("sd", $_POST['role_name'], $_POST['salary']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'employee':
            $stmt = $link->prepare("INSERT INTO employee (emp_fname, emp_lname, emp_address, emp_username, emp_password, branch_ID, role_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssii", $_POST['emp_fname'], $_POST['emp_lname'], $_POST['emp_address'], $_POST['emp_username'], $_POST['emp_password'], $_POST['branch_ID'], $_POST['role_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'membership':
            $stmt = $link->prepare("INSERT INTO membership (membership_name, membership_description, membership_point, customer_cust_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $_POST['membership_name'], $_POST['membership_description'], $_POST['membership_point'], $_POST['customer_cust_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'vehicle':
            $stmt = $link->prepare("INSERT INTO vehicle (vehicle_plate, vehicle_color, customer_cust_ID, vehicle_type_vtype_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $_POST['vehicle_plate'], $_POST['vehicle_color'], $_POST['customer_cust_ID'], $_POST['vehicle_type_vtype_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'booking':
            $stmt = $link->prepare("INSERT INTO booking (booking_date, booking_status, customer_cust_ID, branch_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $_POST['booking_date'], $_POST['booking_status'], $_POST['customer_cust_ID'], $_POST['branch_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'payment':
            $stmt = $link->prepare("INSERT INTO payment (payment_amount, payment_date, payment_method, booking_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("dssi", $_POST['payment_amount'], $_POST['payment_date'], $_POST['payment_method'], $_POST['booking_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'service':
            $stmt = $link->prepare("INSERT INTO service (service_status, service_startdate, service_finishdate, booking_ID, vehicle_ID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssii", $_POST['service_status'], $_POST['service_startdate'], $_POST['service_finishdate'], $_POST['booking_ID'], $_POST['vehicle_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'receipt':
            $stmt = $link->prepare("INSERT INTO receipt (receipt_number, receipt_date, receipt_description, payment_ID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $_POST['receipt_number'], $_POST['receipt_date'], $_POST['receipt_description'], $_POST['payment_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
        case 'service_detail':
            $stmt = $link->prepare("INSERT INTO service_detail (sdetail_quantity, sdetail_price, service_ID, service_type_ID, employee_ID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("idiii", $_POST['sdetail_quantity'], $_POST['sdetail_price'], $_POST['service_ID'], $_POST['service_type_ID'], $_POST['employee_ID']);
            $stmt->execute() ? print("เพิ่มสำเร็จ") : print("" . $stmt->error);
            break;
    }
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $table = $_POST['table'];
    $id = $_POST['id'];
    switch ($table) {
        case 'branch':
            $stmt = $link->prepare("UPDATE branch SET branch_name=?, branch_address=? WHERE branch_ID=?");
            $stmt->bind_param("ssi", $_POST['branch_name'], $_POST['branch_address'], $id);
            break;
        case 'customer':
            $stmt = $link->prepare("UPDATE customer SET cust_fname=?, cust_lname=?, cust_tel=?, cust_address=?, cust_username=?, cust_password=? WHERE cust_ID=?");
            $stmt->bind_param("ssssssi", $_POST['cust_fname'], $_POST['cust_lname'], $_POST['cust_tel'], $_POST['cust_address'], $_POST['cust_username'], $_POST['cust_password'], $id);
            break;
        case 'vehicle_type':
            $stmt = $link->prepare("UPDATE vehicle_type SET vtype_name=?, vtype_multiplier=? WHERE vtype_ID=?");
            $stmt->bind_param("sdi", $_POST['vtype_name'], $_POST['vtype_multiplier'], $id);
            break;
        case 'service_type':
            $stmt = $link->prepare("UPDATE service_type SET Type_serviceName=?, Type_serviceBasePrice=? WHERE Type_serviceID=?");
            $stmt->bind_param("sdi", $_POST['Type_serviceName'], $_POST['Type_serviceBasePrice'], $id);
            break;
        case 'role':
            $stmt = $link->prepare("UPDATE role SET role_name=?, salary=? WHERE role_ID=?");
            $stmt->bind_param("sdi", $_POST['role_name'], $_POST['salary'], $id);
            break;
        case 'employee':
            $stmt = $link->prepare("UPDATE employee SET emp_fname=?, emp_lname=?, emp_address=?, emp_username=?, emp_password=?, branch_ID=?, role_ID=? WHERE emp_ID=?");
            $stmt->bind_param("sssssiii", $_POST['emp_fname'], $_POST['emp_lname'], $_POST['emp_address'], $_POST['emp_username'], $_POST['emp_password'], $_POST['branch_ID'], $_POST['role_ID'], $id);
            break;
        case 'membership':
            $stmt = $link->prepare("UPDATE membership SET membership_name=?, membership_description=?, membership_point=?, customer_cust_ID=? WHERE ID_Membership=?");
            $stmt->bind_param("ssiii", $_POST['membership_name'], $_POST['membership_description'], $_POST['membership_point'], $_POST['customer_cust_ID'], $id);
            break;
        case 'vehicle':
            $stmt = $link->prepare("UPDATE vehicle SET vehicle_plate=?, vehicle_color=?, customer_cust_ID=?, vehicle_type_vtype_ID=? WHERE vehicle_ID=?");
            $stmt->bind_param("ssiii", $_POST['vehicle_plate'], $_POST['vehicle_color'], $_POST['customer_cust_ID'], $_POST['vehicle_type_vtype_ID'], $id);
            break;
        case 'booking':
            $stmt = $link->prepare("UPDATE booking SET booking_date=?, booking_status=?, customer_cust_ID=?, branch_ID=? WHERE booking_ID=?");
            $stmt->bind_param("ssiii", $_POST['booking_date'], $_POST['booking_status'], $_POST['customer_cust_ID'], $_POST['branch_ID'], $id);
            break;
        case 'payment':
            $stmt = $link->prepare("UPDATE payment SET payment_amount=?, payment_date=?, payment_method=?, booking_ID=? WHERE payment_ID=?");
            $stmt->bind_param("dssii", $_POST['payment_amount'], $_POST['payment_date'], $_POST['payment_method'], $_POST['booking_ID'], $id);
            break;
        case 'service':
            $stmt = $link->prepare("UPDATE service SET service_status=?, service_startdate=?, service_finishdate=?, booking_ID=?, vehicle_ID=? WHERE service_ID=?");
            $stmt->bind_param("sssiii", $_POST['service_status'], $_POST['service_startdate'], $_POST['service_finishdate'], $_POST['booking_ID'], $_POST['vehicle_ID'], $id);
            break;
        case 'receipt':
            $stmt = $link->prepare("UPDATE receipt SET receipt_number=?, receipt_date=?, receipt_description=?, payment_ID=? WHERE receipt_ID=?");
            $stmt->bind_param("sssii", $_POST['receipt_number'], $_POST['receipt_date'], $_POST['receipt_description'], $_POST['payment_ID'], $id);
            break;
        case 'service_detail':
            $stmt = $link->prepare("UPDATE service_detail SET sdetail_quantity=?, sdetail_price=?, service_ID=?, service_type_ID=?, employee_ID=? WHERE sdetail_ID=?");
            $stmt->bind_param("idiiii", $_POST['sdetail_quantity'], $_POST['sdetail_price'], $_POST['service_ID'], $_POST['service_type_ID'], $_POST['employee_ID'], $id);
            break;
    }
    $stmt->execute() ? print("อัพเดทสำเร็จ") : print("" . $stmt->error);
}

// Delete
if (isset($_GET['delete']) && isset($_GET['table'])) {
    $table = $_GET['table'];
    $id = $_GET['delete'];
    $id_field = match($table) {
        'branch' => 'branch_ID',
        'customer' => 'cust_ID',
        'vehicle_type' => 'vtype_ID',
        'service_type' => 'Type_serviceID',
        'role' => 'role_ID',
        'employee' => 'emp_ID',
        'membership' => 'ID_Membership',
        'vehicle' => 'vehicle_ID',
        'booking' => 'booking_ID',
        'payment' => 'payment_ID',
        'service' => 'service_ID',
        'receipt' => 'receipt_ID',
        'service_detail' => 'sdetail_ID',
    };
    $link->query("DELETE FROM $table WHERE $id_field=$id") ? print("ลบสำเร็จ") : print("ลบไม่สำเร็จ: " . $link->error . "");
}

$t = $_GET['table'] ?? '';
$edit_id = $_GET['edit'] ?? '';
$edit_data = null;
if ($edit_id && $t) {
    $id_field = match($t) {
        'branch' => 'branch_ID',
        'customer' => 'cust_ID',
        'vehicle_type' => 'vtype_ID',
        'service_type' => 'Type_serviceID',
        'role' => 'role_ID',
        'employee' => 'emp_ID',
        'membership' => 'ID_Membership',
        'vehicle' => 'vehicle_ID',
        'booking' => 'booking_ID',
        'payment' => 'payment_ID',
        'service' => 'service_ID',
        'receipt' => 'receipt_ID',
        'service_detail' => 'sdetail_ID',
    };
    $result = $link->query("SELECT * FROM $t WHERE $id_field=$edit_id");
    $edit_data = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>CRUD</title></head><body>
<h3><?= $edit_id ? 'แก้ไข' : 'เพิ่ม' ?>ข้อมูล</h3>
<form method="get">
    <select name="table" onchange="this.form.submit()">
        <option>เลือกตาราง</option>
        <option value="branch" <?=$t=='branch'?'selected':''?>>branch</option>
        <option value="customer" <?=$t=='customer'?'selected':''?>>customer</option>
        <option value="role" <?=$t=='role'?'selected':''?>>role</option>
        <option value="employee" <?=$t=='employee'?'selected':''?>>employee</option>
        <option value="vehicle_type" <?=$t=='vehicle_type'?'selected':''?>>vehicle_type</option>
        <option value="service_type" <?=$t=='service_type'?'selected':''?>>service_type</option>
        <option value="membership" <?=$t=='membership'?'selected':''?>>membership</option>
        <option value="vehicle" <?=$t=='vehicle'?'selected':''?>>vehicle</option>
        <option value="booking" <?=$t=='booking'?'selected':''?>>booking</option>
        <option value="payment" <?=$t=='payment'?'selected':''?>>payment</option>
        <option value="service" <?=$t=='service'?'selected':''?>>service</option>
        <option value="receipt" <?=$t=='receipt'?'selected':''?>>receipt</option>
        <option value="service_detail" <?=$t=='service_detail'?'selected':''?>>service_detail</option>
    </select>
</form>
<hr>
<?php if($t): ?>
<form method="post">
    <input type="hidden" name="table" value="<?=$t?>">
    <input type="hidden" name="action" value="<?=$edit_id?'update':'insert'?>">
    <?php if($edit_id): ?>
    <input type="hidden" name="id" value="<?=$edit_id?>">
    <?php endif; ?>
    <?php
    switch($t){
        case 'branch':
            echo 'ชื่อสาขา: <input name="branch_name" value="'.$edit_data['branch_name'].'" required>ที่อยู่: <input name="branch_address" value="'.$edit_data['branch_address'].'">';
            break;
        case 'customer':
            echo 'ชื่อ: <input name="cust_fname" value="'.$edit_data['cust_fname'].'" required>นามสกุล: <input name="cust_lname" value="'.$edit_data['cust_lname'].'" required>เบอร์: <input name="cust_tel" value="'.$edit_data['cust_tel'].'">ที่อยู่: <input name="cust_address" value="'.$edit_data['cust_address'].'">Username: <input name="cust_username" value="'.$edit_data['cust_username'].'" required>Password: <input name="cust_password" type="password" value="'.$edit_data['cust_password'].'" required>';
            break;
        case 'vehicle_type':
            echo 'ชื่อประเภท: <input name="vtype_name" value="'.$edit_data['vtype_name'].'" required>ตัวคูณ: <input name="vtype_multiplier" type="number" step="0.01" value="'.$edit_data['vtype_multiplier'].'" required>';
            break;
        case 'service_type':
            echo 'ชื่อบริการ: <input name="Type_serviceName" value="'.$edit_data['Type_serviceName'].'" required>ราคา: <input name="Type_serviceBasePrice" type="number" step="0.01" value="'.$edit_data['Type_serviceBasePrice'].'" required>';
            break;
        case 'role':
            echo 'ตำแหน่ง: <input name="role_name" value="'.$edit_data['role_name'].'" required>เงินเดือน: <input name="salary" type="number" step="0.01" value="'.$edit_data['salary'].'">';
            break;
        case 'employee':
            echo 'ชื่อ: <input name="emp_fname" value="'.$edit_data['emp_fname'].'" required>นามสกุล: <input name="emp_lname" value="'.$edit_data['emp_lname'].'" required>ที่อยู่: <input name="emp_address" value="'.$edit_data['emp_address'].'">Username: <input name="emp_username" value="'.$edit_data['emp_username'].'" required>Password: <input name="emp_password" type="password" value="'.$edit_data['emp_password'].'" required>';
            echo 'สาขา: <select name="branch_ID" required><option value="">-</option>';
            $r=$link->query("SELECT branch_ID,branch_name FROM branch");
            while($row=$r->fetch_assoc())echo"<option value='{$row['branch_ID']}' ".($edit_data['branch_ID']==$row['branch_ID']?'selected':'').">{$row['branch_name']}</option>";
            echo '</select>ตำแหน่ง: <select name="role_ID"><option value="">-</option>';
            $r=$link->query("SELECT role_ID,role_name FROM role");
            while($row=$r->fetch_assoc())echo"<option value='{$row['role_ID']}' ".($edit_data['role_ID']==$row['role_ID']?'selected':'').">{$row['role_name']}</option>";
            echo '</select>';
            break;
        case 'membership':
            echo 'ชื่อ: <input name="membership_name" value="'.$edit_data['membership_name'].'" required>รายละเอียด: <input name="membership_description" value="'.$edit_data['membership_description'].'">แต้ม: <input name="membership_point" type="number" value="'.$edit_data['membership_point'].'">';
            echo 'ลูกค้า: <select name="customer_cust_ID" required><option value="">-</option>';
            $r=$link->query("SELECT cust_ID,cust_fname,cust_lname FROM customer");
            while($row=$r->fetch_assoc())echo"<option value='{$row['cust_ID']}' ".($edit_data['customer_cust_ID']==$row['cust_ID']?'selected':'').">{$row['cust_fname']} {$row['cust_lname']}</option>";
            echo '</select>';
            break;
        case 'vehicle':
            echo 'ทะเบียน: <input name="vehicle_plate" value="'.$edit_data['vehicle_plate'].'" required>สี: <input name="vehicle_color" value="'.$edit_data['vehicle_color'].'">';
            echo 'ลูกค้า: <select name="customer_cust_ID" required><option value="">-</option>';
            $r=$link->query("SELECT cust_ID,cust_fname,cust_lname FROM customer");
            while($row=$r->fetch_assoc())echo"<option value='{$row['cust_ID']}' ".($edit_data['customer_cust_ID']==$row['cust_ID']?'selected':'').">{$row['cust_fname']} {$row['cust_lname']}</option>";
            echo '</select>ประเภทรถ: <select name="vehicle_type_vtype_ID" required><option value="">-</option>';
            $r=$link->query("SELECT vtype_ID,vtype_name FROM vehicle_type");
            while($row=$r->fetch_assoc())echo"<option value='{$row['vtype_ID']}' ".($edit_data['vehicle_type_vtype_ID']==$row['vtype_ID']?'selected':'').">{$row['vtype_name']}</option>";
            echo '</select>';
            break;
        case 'booking':
            echo 'วันที่: <input name="booking_date" type="datetime-local" value="'.$edit_data['booking_date'].'" required>สถานะ: <input name="booking_status" value="'.$edit_data['booking_status'].'">';
            echo 'ลูกค้า: <select name="customer_cust_ID" required><option value="">-</option>';
            $r=$link->query("SELECT cust_ID,cust_fname,cust_lname FROM customer");
            while($row=$r->fetch_assoc())echo"<option value='{$row['cust_ID']}' ".($edit_data['customer_cust_ID']==$row['cust_ID']?'selected':'').">{$row['cust_fname']} {$row['cust_lname']}</option>";
            echo '</select>สาขา: <select name="branch_ID" required><option value="">-</option>';
            $r=$link->query("SELECT branch_ID,branch_name FROM branch");
            while($row=$r->fetch_assoc())echo"<option value='{$row['branch_ID']}' ".($edit_data['branch_ID']==$row['branch_ID']?'selected':'').">{$row['branch_name']}</option>";
            echo '</select>';
            break;
        case 'payment':
            echo 'จำนวนเงิน: <input name="payment_amount" type="number" step="0.01" value="'.$edit_data['payment_amount'].'" required>วันที่: <input name="payment_date" type="datetime-local" value="'.$edit_data['payment_date'].'">วิธี: <input name="payment_method" value="'.$edit_data['payment_method'].'" required>';
            echo 'Booking: <select name="booking_ID" required><option value="">-</option>';
            $r=$link->query("SELECT booking_ID FROM booking");
            while($row=$r->fetch_assoc())echo"<option value='{$row['booking_ID']}' ".($edit_data['booking_ID']==$row['booking_ID']?'selected':'').">Booking #{$row['booking_ID']}</option>";
            echo '</select>';
            break;
        case 'service':
            echo 'สถานะ: <input name="service_status" value="'.$edit_data['service_status'].'">เริ่ม: <input name="service_startdate" type="datetime-local" value="'.$edit_data['service_startdate'].'">เสร็จ: <input name="service_finishdate" type="datetime-local" value="'.$edit_data['service_finishdate'].'">';
            echo 'Booking: <select name="booking_ID" required><option value="">-</option>';
            $r=$link->query("SELECT booking_ID FROM booking");
            while($row=$r->fetch_assoc())echo"<option value='{$row['booking_ID']}' ".($edit_data['booking_ID']==$row['booking_ID']?'selected':'').">Booking #{$row['booking_ID']}</option>";
            echo '</select>รถ: <select name="vehicle_ID" required><option value="">-</option>';
            $r=$link->query("SELECT vehicle_ID,vehicle_plate FROM vehicle");
            while($row=$r->fetch_assoc())echo"<option value='{$row['vehicle_ID']}' ".($edit_data['vehicle_ID']==$row['vehicle_ID']?'selected':'').">{$row['vehicle_plate']}</option>";
            echo '</select>';
            break;
        case 'receipt':
            echo 'เลขที่: <input name="receipt_number" value="'.$edit_data['receipt_number'].'" required>วันที่: <input name="receipt_date" type="datetime-local" value="'.$edit_data['receipt_date'].'">รายละเอียด: <input name="receipt_description" value="'.$edit_data['receipt_description'].'">';
            echo 'Payment: <select name="payment_ID" required><option value="">-</option>';
            $r=$link->query("SELECT payment_ID FROM payment");
            while($row=$r->fetch_assoc())echo"<option value='{$row['payment_ID']}' ".($edit_data['payment_ID']==$row['payment_ID']?'selected':'').">Payment #{$row['payment_ID']}</option>";
            echo '</select>';
            break;
        case 'service_detail':
            echo 'จำนวน: <input name="sdetail_quantity" type="number" value="'.$edit_data['sdetail_quantity'].'" required>ราคา: <input name="sdetail_price" type="number" step="0.01" value="'.$edit_data['sdetail_price'].'" required>';
            echo 'Service: <select name="service_ID" required><option value="">-</option>';
            $r=$link->query("SELECT service_ID FROM service");
            while($row=$r->fetch_assoc())echo"<option value='{$row['service_ID']}' ".($edit_data['service_ID']==$row['service_ID']?'selected':'').">Service #{$row['service_ID']}</option>";
            echo '</select>ประเภทบริการ: <select name="service_type_ID" required><option value="">-</option>';
            $r=$link->query("SELECT Type_serviceID,Type_serviceName FROM service_type");
            while($row=$r->fetch_assoc())echo"<option value='{$row['Type_serviceID']}' ".($edit_data['service_type_ID']==$row['Type_serviceID']?'selected':'').">{$row['Type_serviceName']}</option>";
            echo '</select>พนักงาน: <select name="employee_ID" required><option value="">-</option>';
            $r=$link->query("SELECT emp_ID,emp_fname,emp_lname FROM employee");
            while($row=$r->fetch_assoc())echo"<option value='{$row['emp_ID']}' ".($edit_data['employee_ID']==$row['emp_ID']?'selected':'').">{$row['emp_fname']} {$row['emp_lname']}</option>";
            echo '</select>';
            break;
    }
    ?>
    <button type="submit"><?=$edit_id?'อัพเดท':'บันทึก'?></button>
    <?php if($edit_id): ?><a href="?table=<?=$t?>"><button type="button">ยกเลิก</button></a><?php endif; ?>
</form>
<hr>
<h4>ข้อมูลในตาราง</h4>
<?php
$r=$link->query("SELECT * FROM $t");
if($r&&$r->num_rows>0){
    echo'<table border=1>';
    echo'<tr>';foreach($r->fetch_fields()as$f)echo"<th>$f->name</th>";echo'<th>จัดการ</th></tr>';
    while($row=$r->fetch_assoc()){
        echo'<tr>';
        $first_id = reset($row);
        foreach($row as$v)echo'<td>'.($v??'NULL').'</td>';
        echo'<td><a href="?table='.$t.'&edit='.$first_id.'">แก้ไข</a> | <a href="?table='.$t.'&delete='.$first_id.'" onclick="return confirm(\'ลบ?\')">ลบ</a></td>';
        echo'</tr>';
    }
    echo'</table>';
}else echo'ไม่มีข้อมูล';
?>
<?php endif;?>
<hr><a href="index.php">← กลับ</a>
</body></html>

