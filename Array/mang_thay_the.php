<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 5</title>
    <style>
        .form-container {
            width: 500px;
            margin: 30px auto;
            border: 1px solid #a00050;
            background-color: #fff0f5;
            font-family: Arial, sans-serif;
        }

        .title {
            text-align: center;
            background-color: #a00050;
            color: white;
            font-size: 20px;
            font-weight: bold;
            font-style: italic;
            padding: 8px 0;
            margin: 0;
        }

        .calc-table {
            width: 100%;
            padding: 15px;
            border-collapse: collapse;
        }

        .calc-table td {
            padding: 6px 5px;
            font-size: 14px;
        }

        .label {
            width: 170px;
            font-size: 14px;
            background-color: #FED6F1;
        }

        .label2 {
            width: 170px;
            font-size: 14px;
            background-color: #fff0f5;
        }

        .input-text {
            width: 280px;
            padding: 3px;
            border: 1px solid #7f9db9;
        }

        .input-short {
            width: 150px;
            padding: 3px;
            border: 1px solid #7f9db9;
        }

      
        .input-readonly {
            width: 280px;
            padding: 3px;
            border: 1px solid #7f9db9;
            background-color: #ffa0a0;
            color: black;
            font-weight: bold;
        }

        .btn-tinh {
            background-color: #ffffa0;
            border: 1px solid #7f9db9;
            padding: 3px 15px;
            cursor: pointer;
            font-weight: bold;
        }

        .footer-note {
            text-align: center;
            font-size: 13px;
            padding-bottom: 12px;
        }

        .note-red {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
function xuat_mang($mang) {
    return implode("  ", $mang);
}

function thay_the($mang, $gia_tri_cu, $gia_tri_moi) {
    $so_phan_tu = count($mang);
    for ($i = 0; $i < $so_phan_tu; $i++) {
        if (trim($mang[$i]) == trim($gia_tri_cu)) {
            $mang[$i] = $gia_tri_moi;
        }
    }
    return $mang;
}

$day_so = "";
$gia_tri_cu = "";
$gia_tri_moi = "";
$mang_cu_str = "";
$mang_moi_str = "";

if (isset($_POST["thay_the"])) {
    $day_so = $_POST["day_so"] ?? "";
    $gia_tri_cu = $_POST["gia_tri_cu"] ?? "";
    $gia_tri_moi = $_POST["gia_tri_moi"] ?? "";

    if (trim($day_so) != "") {
        $mang_goc = explode(",", $day_so);

        $mang_cu_str = xuat_mang($mang_goc);

        $mang_sau_thay_the = thay_the($mang_goc, $gia_tri_cu, $gia_tri_moi);

        $mang_moi_str = xuat_mang($mang_sau_thay_the);
    }
}
?>

    <div class="form-container">
        <div class="title">THAY THẾ</div>

        <form action="mang_thay_the.php" method="POST">
            <table class="calc-table">
                <tr>
                    <td class="label">Nhập các phần tử:</td>
                    <td class="label">
                        <input type="text" name="day_so" class="input-text" value="<?php echo htmlspecialchars($day_so); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">Giá trị cần thay thế:</td>
                    <td class="label">
                        <input type="text" name="gia_tri_cu" class="input-short" value="<?php echo htmlspecialchars($gia_tri_cu); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="label">Giá trị thay thế:</td>
                    <td class="label">
                        <input type="text" name="gia_tri_moi" class="input-short" value="<?php echo htmlspecialchars($gia_tri_moi); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="label"></td>
                    <td class="label">
                        <button type="submit" name="thay_the" class="btn-tinh">Thay thế</button>
                    </td>
                </tr>
                <tr>
                    <td class="label2">Mảng cũ:</td>
                    <td>
                        <input type="text" class="input-readonly" value="<?php echo htmlspecialchars($mang_cu_str); ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="label2">Mảng sau khi thay thế:</td>
                    <td>
                        <input type="text" class="input-readonly" value="<?php echo htmlspecialchars($mang_moi_str); ?>" readonly>
                    </td>
                </tr>
            </table>

            <div class="footer-note">
                (<span class="note-red">Ghi chú:</span> Các phần tử trong mảng sẽ cách nhau bằng dấu ",")
            </div>
        </form>
    </div>
</body>
</html>