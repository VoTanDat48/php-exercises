<?php
$phep_tinh = isset($_POST['phep_tinh']) ? $_POST['phep_tinh'] : "+";
$so1 = isset($_POST['so1']) ? trim($_POST['so1']) : "";
$so2 = isset($_POST['so2']) ? trim($_POST['so2']) : "";

$ten_phep_tinh = "";
switch ($phep_tinh) {
    case '+': $ten_phep_tinh = "Cộng"; break;
    case '-': $ten_phep_tinh = "Trừ"; break;
    case '*': $ten_phep_tinh = "Nhân"; break;
    case '/': $ten_phep_tinh = "Chia"; break;
}

function kiem_tra_du_lieu($a, $b, $pt) {
    if (!is_numeric($a) || !is_numeric($b)) {
        return false;
    }
    if ($pt == '/' && (float)$b == 0) {
        return false;
    }
    return true;
}

if (!kiem_tra_du_lieu($so1, $so2, $phep_tinh)) {
    echo "<script>
            alert('Dữ liệu không hợp lệ hoặc không thể chia cho 0!');
            window.history.back();
          </script>";
    exit();
}

$num1 = (float)$so1;
$num2 = (float)$so2;
$ket_qua = "";

function tinh_cong($a, $b) { return $a + $b; }
function tinh_tru($a, $b) { return $a - $b; }
function tinh_nhan($a, $b) { return $a * $b; }
function tinh_chia($a, $b) { return $a / $b; }

switch ($phep_tinh) {
    case '+': $ket_qua = tinh_cong($num1, $num2); break;
    case '-': $ket_qua = tinh_tru($num1, $num2); break;
    case '*': $ket_qua = tinh_nhan($num1, $num2); break;
    case '/': $ket_qua = tinh_chia($num1, $num2); break;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Kết quả phép tính</title>
<style>
body { font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
.container { width: 450px; text-align: center; }
h2 { color: #000080; font-weight: bold; }
.form-group { margin: 10px 0; text-align: left; display: flex; align-items: center; }
.form-group label { width: 130px; font-weight: bold; color: blue; }
.form-group .label-phep-tinh { width: 130px; font-weight: bold; color: #a52a2a; }
.form-group input[type="text"] { flex: 1; padding: 3px; border: 1px solid #7f7f7f; color: blue; }
.back-link { margin-top: 15px; display: block; color: purple; font-style: italic; text-decoration: underline; cursor: pointer; }
</style>
</head>
<body>
<div class="container">
    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
    <div class="form-group">
        <span class="label-phep-tinh">Chọn phép tính :</span>
        <span style="color: #a52a2a; font-weight: bold;"><?php echo $ten_phep_tinh; ?></span>
    </div>
    <div class="form-group">
        <label>Số 1 :</label>
        <input type="text" value="<?php echo $so1; ?>" readonly>
    </div>
    <div class="form-group">
        <label>Số 2 :</label>
        <input type="text" value="<?php echo $so2; ?>" readonly>
    </div>
    <div class="form-group">
        <label>Kết quả :</label>
        <input type="text" value="<?php echo $ket_qua; ?>" readonly>
    </div>
    <a class="back-link" onclick="window.history.back();">Quay lại trang trước</a>
</div>
</body>
</html>