<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 7</title>
    <style>
        .form-container {
            width: 450px;
            margin: 30px auto;
            border: 1px solid #B9EEFF;
            background-color: #B9EEFF;
            font-family: Arial, sans-serif;
        }

        .title {
            text-align: center;
            background-color: #0C62CC;
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 8px 0;
            margin: 0;
        }

        .calc-table {
            width: 100%;
            padding: 15px;
            border-collapse: collapse;
        }

        .calc-table td {
            padding: 5px;
            text-align: center;
        }

        .label {
            color: black;
            font-size: 14px;
        }

        .input-text {
            width: 140px;
            padding: 3px;
            border: 1px solid #7f9db9;    
        }

        
        .input-readonly {
            width: 140px;
            padding: 3px;
            border: 1px solid #7f9db9;
            background-color: #FCFFD7;
            color: #d84315;
            font-weight: bold;
        }

        .btn-tinh {
            background-color: #ffff99;
            border: 1px solid #7f9db9;
            padding: 2px 10px;
            cursor: pointer;
            font-weight: bold;
            color: #d84315;
        }

        .image-container {
            text-align: center;
            padding-bottom: 15px;
        }

        .image-container img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
<?php
$nam_duong = "";
$nam_am = "";
$hinh_anh = "";

$mang_can = array("Quý", "Giáp", "Ất", "Bính", "Đinh", "Mậu", "Kỷ", "Canh", "Tân", "Nhâm");
$mang_chi = array("Hợi", "Tý", "Sửu", "Dần", "Mão", "Thìn", "Tỵ", "Ngọ", "Mùi", "Thân", "Dậu", "Tuất");
$mang_hinh = array("Hoi.png", "Ty.png", "Suu.png", "Dan.png", "Mao.png", "Thin.png", "Tỵ.png", "Ngo.png", "Mùi.png", "Than.png", "Dau.png", "Tuat.png");

if (isset($_POST["tinh"])) {
    $nam_duong = $_POST["nam_duong"] ?? "";

    if (is_numeric($nam_duong) && (int)$nam_duong > 0) {
        $nam = (int)$nam_duong;

        $nam_tinh = $nam - 3;
        $can = $nam_tinh % 10;
        $chi = $nam_tinh % 12;

        $nam_am = $mang_can[$can] . " " . $mang_chi[$chi];

        $hinh = $mang_hinh[$chi];
        $hinh_anh = "<img src='Img/$hinh' alt='$nam_am'>";
    }
}
?>

    <div class="form-container">
        <div class="title">TÍNH NĂM ÂM LỊCH</div>

        <form action="mang_nam_am_lich.php" method="POST">
            <table class="calc-table">
                <tr>
                    <td class="label">Năm dương lịch</td>
                    <td></td>
                    <td class="label">Năm âm lịch</td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="nam_duong" class="input-text" value="<?php echo $nam_duong; ?>" required>
                    </td>
                    <td>
                        <button type="submit" name="tinh" class="btn-tinh">=&gt;</button>
                    </td>
                    <td>
                        <input type="text" class="input-readonly" value="<?php echo $nam_am; ?>" readonly>
                    </td>
                </tr>
            </table>

            <div class="image-container">
                <?php echo $hinh_anh; ?>
            </div>
        </form>
    </div>
</body>
</html>