<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phát sinh mảng và tính toán</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 15px;
            background-color: #888; 
        }
        table { 
            background-color: #FFFBFF; 
            border-collapse: collapse; 
            margin: 20px auto; 
            width: 550px; 
        }
        th { 
            background-color: #A70F74; 
            color: white; 
            padding: 10px; 
            font-size: 26px; 
            font-family: "Time New Roman", cursive, serif; 
            font-weight: normal;
        }
        td { 
            padding: 8px 10px; 
        }
        .input-normal {
            width: 250px; 
            padding: 4px;
            border: 1px solid #a9a9a9;
        }
        .input-readonly { 
            background-color: #fca4a4; 
            border: 1px solid #a9a9a9;
            padding: 4px;
            color: black;
        }
        .mang-width {
            width: 95%; 
        }
        .short-width {
            width: 100px; 
        }
        .btn { 
            background-color: #ffffcc; 
            padding: 4px 20px; 
            cursor: pointer; 
            border: 1px solid #888; 
            color: black;
        }
        .ghi-chu {
            text-align: center; 
            font-size: 14px;
            padding: 10px 0;
        }
        .ghi-chu b {
            color: red; 
        }
    </style>
</head>
<body>

<?php
$n = "";
$mang_kq = "";
$max = "";
$min = "";
$tong = "";

function tao_mang($n) {
    $mang = array();
    for ($i = 0; $i < $n; $i++) {
        $mang[] = rand(0, 20); 
    }
    return $mang;
}

function xuat_mang($mang) {
    $chuoi = "";
    for ($i = 0; $i < count($mang); $i++) {
        $chuoi .= $mang[$i] . " ";
    }
    return trim($chuoi);
}

function tinh_tong($mang) {
    $t = 0;
    for ($i = 0; $i < count($mang); $i++) {
        $t += $mang[$i];
    }
    return $t;
}

function tim_max($mang) {
    $max = $mang[0];
    for ($i = 1; $i < count($mang); $i++) {
        if ($mang[$i] > $max) {
            $max = $mang[$i];
        }
    }
    return $max;
}

function tim_min($mang) {
    $min = $mang[0];
    for ($i = 1; $i < count($mang); $i++) {
        if ($mang[$i] < $min) {
            $min = $mang[$i];
        }
    }
    return $min;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['so_phan_tu']) && is_numeric($_POST['so_phan_tu']) && $_POST['so_phan_tu'] > 0) {
        $n = (int)$_POST['so_phan_tu'];
        
        $mang = tao_mang($n);
        $mang_kq = xuat_mang($mang);
        $tong = tinh_tong($mang);
        $max = tim_max($mang);
        $min = tim_min($mang);

    } else {
        echo "<script>alert('Vui lòng nhập số phần tử là số nguyên dương!');</script>";
    }
}
?>

<form name="form_mang" action="mang_phat_sinh_tinh_toan.php" method="POST">
    <table>
        <tr>
            <th colspan="2">PHÁT SINH MẢNG VÀ TÍNH TOÁN</th>
        </tr>
        <tr style="background-color: #FBDFFA;">
            <td width="35%">Nhập số phần tử:</td>
            <td width="65%">
                <input type="text" name="so_phan_tu" value="<?php echo $n; ?>" class="input-normal" required>
            </td>
        </tr>
        
        <tr style="background-color: #FBDFFA;">
            <td></td>
            <td>
                <input type="submit" name="submit" value="Phát sinh và tính toán" class="btn">
            </td>
        </tr>
        
        <tr>
            <td>Mảng:</td>
            <td>
                <input type="text" name="mang_kq" class="input-readonly mang-width" value="<?php echo $mang_kq; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>GTLN (MAX) trong mảng:</td>
            <td>
                <input type="text" name="max_kq" class="input-readonly short-width" value="<?php echo $max; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>TTNN (MIN) trong mảng:</td>
            <td>
                <input type="text" name="min_kq" class="input-readonly short-width" value="<?php echo $min; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Tổng mảng:</td>
            <td>
                <input type="text" name="tong_kq" class="input-readonly short-width" value="<?php echo $tong; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="ghi-chu">
                (<b>Ghi chú:</b> Các phần tử trong mảng sẽ có giá trị từ 0 đến 20)
            </td>
        </tr>
    </table>
</form>

</body>
</html>