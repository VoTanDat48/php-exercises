<?php
$ten = "";
$cu = "";
$moi = "";
$dongia = "20000";
$thanhtien = "";
$thongbao = "";

if (isset($_POST['tinh'])) {
    $ten = $_POST['ten'];
    $cu = $_POST['cu'];
    $moi = $_POST['moi'];
    $dongia = $_POST['dongia'];

    if ($cu === "" || $moi === "" || $dongia === "") {
        $thongbao = "Vui lòng nhập đầy đủ dữ liệu!";
    } elseif (!is_numeric($cu) || !is_numeric($moi) || !is_numeric($dongia)) {
        $thongbao = "Chỉ số và đơn giá phải là số!";
    } elseif ($cu < 0 || $moi < 0 || $dongia < 0) {
        $thongbao = "Không được nhập số âm, vui lòng nhập lại!";
    } elseif ($moi < $cu) {
        $thongbao = "Chỉ số mới phải lớn hơn hoặc bằng chỉ số cũ!";
    } else {
        $thanhtien = ($moi - $cu) * $dongia;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanh toan tien dien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eee;
        }
        table {
            background-color: #fef1cf;
            border: 1px solid #d4c4a8;
            border-collapse: collapse;
            margin: 50px auto;
            width: 420px;
        }
        th {
            background-color: #f7ca62;
            color: red;
            padding: 10px;
            font-size: 18px;
        }
        td {
            padding: 8px 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 4px;
            border: 1px solid #7f7f7f;
            box-sizing: border-box;
        }
        .readonly {
            background-color: #f9d9e2;
        }
        .nut-bam {
            padding: 4px 15px;
            background-color: #e1e1e1;
            border: 1px solid #7f7f7f;
            cursor: pointer;
        }
        .loi {
            color: red;
            text-align: center;
            font-weight: bold;
            padding-bottom: 0;
        }
    </style>
</head>
<body>

    <form method="POST" action="">
        <table border="0">
            <tr>
                <th colspan="3">THANH TOÁN TIỀN ĐIỆN</th>
            </tr>
            
            <?php if ($thongbao != "") { ?>
            <tr>
                <td colspan="3" class="loi"><?php echo $thongbao; ?></td>
            </tr>
            <?php } ?>

            <tr>
                <td width="140">Tên chủ hộ:</td>
                <td><input type="text" name="ten" value="<?php echo $ten; ?>"></td>
                <td width="45"></td>
            </tr>
            <tr>
                <td>Chỉ số cũ:</td>
                <td><input type="text" name="cu" value="<?php echo $cu; ?>"></td>
                <td>(Kw)</td>
            </tr>
            <tr>
                <td>Chỉ số mới:</td>
                <td><input type="text" name="moi" value="<?php echo $moi; ?>"></td>
                <td>(Kw)</td>
            </tr>
            <tr>
                <td>Đơn giá:</td>
                <td><input type="text" name="dongia" value="<?php echo $dongia; ?>"></td>
                <td>(VNĐ)</td>
            </tr>
            <tr>
                <td>Số tiền thanh toán:</td>
                <td><input type="text" name="thanhtien" class="readonly" readonly value="<?php echo is_numeric($thanhtien) ? number_format($thanhtien, 0, ',', '.') : $thanhtien; ?>"></td>
                <td>(VNĐ)</td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="padding-bottom: 15px;">
                    <input type="submit" name="tinh" value="Tính" class="nut-bam">
                </td>
            </tr>
        </table>
    </form>

</body>
</html>