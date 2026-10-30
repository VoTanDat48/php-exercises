<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Nhập và tính trên dãy số</title>
<style>
    body { font-family: Arial, sans-serif; background-color: #e6edd8; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .container { width: 450px; background: #cce0cb; border: 1px solid #7f9db9; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
    .header { background: #2D9494; color: white; text-align: center; font-weight: bold; padding: 10px; font-size: 16px; text-transform: uppercase; }
    .form-content { padding: 15px 20px; }
    .row { margin: 10px 0; display: flex; align-items: center; }
    .row label { width: 110px; font-weight: normal; }
    .row input[type="text"] { width: 260px; padding: 3px; border: 1px solid #7f9db9; }
    .btn-container { margin: 15px 0; padding-left: 110px; }
    .btn-container input[type="submit"] { background: #ffff99; padding: 4px 15px; border: 1px solid #7f9db9; cursor: pointer; font-weight: bold; }
    .note { color: red; font-size: 13px; text-align: center; margin-top: 10px; }
    .result-input { background-color: #C5FB93; }
</style>
</head>
<body>

<?php
$chuoi_so = isset($_POST['chuoi_so']) ? $_POST['chuoi_so'] : '';
$tong = '';

if (isset($_POST['tinh_tong'])) {
    $mang = explode(",", $chuoi_so);
    $so_phan_tu = count($mang);
    $tong = 0;
    for ($i = 0; $i < $so_phan_tu; $i++) {
        $tong += trim($mang[$i]);
    }
}
?>

<div class="container">
    <div class="header">Nhập và tính trên dãy số</div>
    <div class="form-content">
        <form action="tong_day_so.php" method="POST">
            <div class="row">
                <label>Nhập dãy số:</label>
                <input type="text" name="chuoi_so" value="<?php echo htmlspecialchars($chuoi_so); ?>">
                <span style="color: red; margin-left: 5px;">(*)</span>
            </div>
            
            <div class="btn-container">
                <input type="submit" name="tinh_tong" value="Tổng dãy số">
            </div>
            
            <div class="row">
                <label>Tổng dãy số:</label>
                <input type="text" class="result-input" style="color: red" value="<?php echo htmlspecialchars($tong); ?>" readonly>
            </div>
            
            <div class="note">
                (*) Các số được nhập cách nhau bằng dấu ","
            </div>
        </form>
    </div>
</div>

</body>
</html>