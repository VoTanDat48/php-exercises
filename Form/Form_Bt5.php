<?php
$gio_bd = "";
$gio_kt = "";
$tien = "";

if (isset($_POST['tinh'])) {
    $gio_bd = $_POST['gio_bd'];
    $gio_kt = $_POST['gio_kt'];

    if (is_numeric($gio_bd) && is_numeric($gio_kt)) {
        if ($gio_kt > $gio_bd) {
            $so_gio = $gio_kt - $gio_bd;
            
            if ($gio_kt <= 17) {
                $tien = $so_gio * 20000;
            } elseif ($gio_bd >= 17) {
                $tien = $so_gio * 45000;
            } else {
                $gio_truoc = 17 - $gio_bd;
                $gio_sau = $gio_kt - 17;
                $tien = ($gio_truoc * 20000) + ($gio_sau * 45000);
            }
        } else {
            $tien = "Giờ kết thúc phải > Giờ bắt đầu";
        }
    } else {
        $tien = "Vui lòng nhập số!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tính Tiền Karaoke</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eee;
        }
        table {
            background-color: #03B0B6;
            
            border-collapse: collapse;
            margin: 50px auto;
            width: 400px;
        }
        th {
            background-color: #008B8E;
            color: white;
            font-style: italic;
            font-size: 18px;
            padding: 10px;
            
        }
        td {
            padding: 8px 10px;
            color: black;
        }
        input[type="text"] {
            width: 100%;
            padding: 3px;
            border: 1px solid #7f7f7f;
            box-sizing: border-box;
        }
        .readonly {
            background-color: #fffacd;
        }
        .nut-bam {
            padding: 4px 15px;
            background-color: #FAFFDE;
            border: 1px solid #7f7f7f;
            cursor: pointer;
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<body>

    <form method="POST" action="">
        <table border="0">
            <tr>
                <th colspan="3">TÍNH TIỀN KARAOKE</th>
            </tr>
            <tr>
                <td width="120">Giờ bắt đầu:</td>
                <td><input type="text" name="gio_bd" value="<?php echo $gio_bd; ?>"></td>
                <td width="40">(h)</td>
            </tr>
            <tr>
                <td>Giờ kết thúc:</td>
                <td><input type="text" name="gio_kt" value="<?php echo $gio_kt; ?>"></td>
                <td>(h)</td>
            </tr>
            <tr>
                <td>Tiền thanh toán:</td>
                <td><input type="text" name="tien" class="readonly" readonly value="<?php echo is_numeric($tien) ? number_format($tien, 0, ',', '.') : $tien; ?>"></td>
                <td>(VNĐ)</td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="padding-bottom: 15px;">
                    <input type="submit" name="tinh" value="Tính tiền" class="nut-bam">
                </td>
            </tr>
        </table>
    </form>

</body>
</html>