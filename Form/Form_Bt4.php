<?php
$toan = "";
$ly = "";
$hoa = "";
$diemchuan = "20";
$tongdiem = "";
$ketqua = "";
$thongbao = "";

if (isset($_POST['xem'])) {
    $toan = $_POST['toan'];
    $ly = $_POST['ly'];
    $hoa = $_POST['hoa'];
    $diemchuan = $_POST['diemchuan'];

    if ($toan === "" || $ly === "" || $hoa === "" || $diemchuan === "") {
        $thongbao = "Vui lòng nhập đầy đủ thông tin!";
    } elseif (!is_numeric($toan) || !is_numeric($ly) || !is_numeric($hoa) || !is_numeric($diemchuan)) {
        $thongbao = "Điểm phải là số, vui lòng nhập lại!";
    } elseif ($toan < 0 || $ly < 0 || $hoa < 0 || $diemchuan < 0) {
        $thongbao = "Không được nhập số âm, vui lòng nhập lại!";
    } elseif ($toan > 10 || $ly > 10 || $hoa > 10) {
        $thongbao = "Điểm mỗi môn không được vượt quá 10!";
    } else {
        $tongdiem = $toan + $ly + $hoa;
        
        if ($toan > 0 && $ly > 0 && $hoa > 0 && $tongdiem >= $diemchuan) {
            $ketqua = "Đậu";
        } else {
            $ketqua = "Rớt";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kết quả thi đại học</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eee;
        }
        table {
            background-color: #fce4ec;
            border: 1px solid #f8bbd0;
            border-collapse: collapse;
            margin: 50px auto;
            width: 380px;
        }
        th {
            background-color: #ec407a;
            color: white;
            font-style: italic;
            font-size: 18px;
            padding: 10px;
        }
        td {
            padding: 8px 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 3px;
            border: 1px solid #7f7f7f;
            box-sizing: border-box;
        }
        .readonly {
            background-color: #fffde7;
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
                <th colspan="2">KẾT QUẢ THI ĐẠI HỌC</th>
            </tr>
            
            <?php if ($thongbao != "") { ?>
            <tr>
                <td colspan="2" class="loi"><?php echo $thongbao; ?></td>
            </tr>
            <?php } ?>

            <tr>
                <td width="120">Toán:</td>
                <td><input type="text" name="toan" value="<?php echo $toan; ?>"></td>
            </tr>
            <tr>
                <td>Lý:</td>
                <td><input type="text" name="ly" value="<?php echo $ly; ?>"></td>
            </tr>
            <tr>
                <td>Hoá:</td>
                <td><input type="text" name="hoa" value="<?php echo $hoa; ?>"></td>
            </tr>
            <tr>
                <td>Điểm chuẩn:</td>
                <td><input type="text" name="diemchuan" style="color: red;" value="<?php echo $diemchuan; ?>"></td>
            </tr>
            <tr>
                <td>Tổng điểm:</td>
                <td><input type="text" name="tongdiem" class="readonly" readonly value="<?php echo $tongdiem; ?>"></td>
            </tr>
            <tr>
                <td>Kết quả thi:</td>
                <td><input type="text" name="ketqua" class="readonly" readonly value="<?php echo $ketqua; ?>"></td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="padding-bottom: 15px;">
                    <input type="submit" name="xem" value="Xem kết quả" class="nut-bam">
                </td>
            </tr>
        </table>
    </form>

</body>
</html>