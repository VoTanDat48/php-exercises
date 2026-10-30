<?php
$so1 = "";
$so2 = "";
$phep_tinh = "";
$ket_qua = "";

if (isset($_POST['tinh'])) {
    $so1 = $_POST['so1'];
    $so2 = $_POST['so2'];
    $phep_tinh = $_POST['phep_tinh'];

    if (is_numeric($so1) && is_numeric($so2)) {
        switch ($phep_tinh) {
            case 'Cộng':
                $ket_qua = $so1 + $so2;
                break;
            case 'Trừ':
                $ket_qua = $so1 - $so2;
                break;
            case 'Nhân':
                $ket_qua = $so1 * $so2;
                break;
            case 'Chia':
                if ($so2 == 0) {
                    $ket_qua = "Không thể chia cho 0";
                } else {
                    $ket_qua = $so1 / $so2;
                }
                break;
        }
    } else {
        $ket_qua = "Bạn phải nhập số";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Phép tính trên hai số</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .khung-chua {
            width: 450px;
            margin: 50px auto; 
        }
        h2 {
            color: #3C6D9D;
            text-align: center;
        }
        table {
            width: 100%;
        }
        td {
            padding: 8px 0;
        }
        .chu-do {
            color: #a52a2a;
            font-weight: bold;
        }
        .chu-xanh {
            color: blue;
            font-weight: bold;
        }
        input[type="text"] {
            width: 250px;
            padding: 4px;
            border: 1px solid #7f7f7f;
            color: blue;
        }
        .nut-bam {
            padding: 3px 15px;
            background: #e1e1e1;
            border: 1px solid #7f7f7f;
            cursor: pointer;
        }
        .link-quay-lai {
            color: purple;
            font-style: italic;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="khung-chua">
    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
    <?php if (!isset($_POST['tinh'])) { ?>
        
        <form method="POST" action="">
            <table border="0">
                <tr>
                    <td class="chu-do" width="130">Chọn phép tính :</td>
                    <td class="chu-do" style="font-weight: normal;">
                        <label><input type="radio" name="phep_tinh" value="Cộng" checked> Cộng</label> &nbsp;
                        <label><input type="radio" name="phep_tinh" value="Trừ"> Trừ</label> &nbsp;
                        <label><input type="radio" name="phep_tinh" value="Nhân"> Nhân</label> &nbsp;
                        <label><input type="radio" name="phep_tinh" value="Chia"> Chia</label>
                    </td>
                </tr>
                <tr>
                    <td class="chu-xanh">Số thứ nhất :</td>
                    <td><input type="text" name="so1" required></td>
                </tr>
                <tr>
                    <td class="chu-xanh">Số thứ nhì :</td>
                    <td><input type="text" name="so2" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="tinh" value="Tính" class="nut-bam"></td>
                </tr>
            </table>
        </form>
    <?php } else { ?>

        <table border="0">
            <tr>
                <td class="chu-do" width="130">Chọn phép tính :</td>
                <td class="chu-do"><?php echo $phep_tinh; ?></td>
            </tr>
            <tr>
                <td class="chu-xanh">Số 1 :</td>
                <td><input type="text" value="<?php echo $so1; ?>" readonly></td>
            </tr>
            <tr>
                <td class="chu-xanh">Số 2 :</td>
                <td><input type="text" value="<?php echo $so2; ?>" readonly></td>
            </tr>
            <tr>
                <td class="chu-xanh">Kết quả :</td>
                <td>
                    <input type="text" value="<?php echo $ket_qua; ?>" readonly 
                           style="color: <?php echo is_numeric($ket_qua) ? 'blue' : 'red'; ?>;">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><a href="javascript:window.history.back();" class="link-quay-lai">Quay lại trang trước</a></td>
            </tr>
        </table>

    <?php } ?>
</div>

</body>
</html>