<?php
$bankinh = "";
$dientich = "";
$chuvi = "";
$thongbao = "";


if (isset($_POST["tinh"])) {
    $bankinh = $_POST["bankinh"];
    
    if (is_numeric($bankinh)) {
        $pi = 3.14; 
        $dientich = $pi * $bankinh * $bankinh;
        $chuvi = 2 * $pi * $bankinh;
    } else {
        $thongbao = "Vui lòng nhập số!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hình tròn</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif, sans-serif;
        }
        table { 
            background-color: #fff8d6; 
            border: 1px solid #dcdcdc;
            border-collapse: collapse;
        }
        th { 
            background-color: #ffd966; 
            color: #8b0000; 
            font-family: 'Georgia', serif;
            font-size: 18px;
            padding: 8px; 
        }
        td { 
            padding: 5px; 
        }
        .bg-readonly { 
            background-color: #ffd1d1; 
        }
        .error { 
            color: red; 
            font-weight: bold; 
            text-align: center; 
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <table align="center" border="0">
        <tr>
            <th colspan="2">DIỆN TÍCH VÀ CHU VI HÌNH TRÒN</th>
        </tr>

        <?php if (!empty($thongbao)) { ?>
        <tr>
            <td colspan="2" class="error"><?php echo $thongbao; ?></td>
        </tr>
        <?php } ?>

        <tr>
            <td>Bán kính:</td>
            <td>
                
                <input type="text" name="bankinh" value="<?php echo isset($_POST['bankinh']) ? $_POST['bankinh'] : ''; ?>">
            </td>
        </tr>
        <tr>
            <td>Diện tích:</td>
            <td>
                <input type="text" class="bg-readonly" value="<?php echo $dientich; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Chu vi:</td>
            <td>
                <input type="text" class="bg-readonly" value="<?php echo $chuvi; ?>" readonly>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="tinh" value="Tính">
            </td>
        </tr>
    </table>
</form>

</body>
</html>