<?php
$dientich = "";
$thongbao = ""; 

if (isset($_POST["tinh"])) {
    $chieudai = $_POST["chieudai"];
    $chieurong = $_POST["chieurong"];

    if (is_numeric($chieudai) && is_numeric($chieurong)) {
        
        if ($chieurong > $chieudai) {
            $thongbao = "Chiều rộng không được lớn hơn chiều dài!";
        } else {
            
            $dientich = $chieudai * $chieurong;
        }
    } else {
        $thongbao = "Vui lòng nhập vào số hợp lệ!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Diện tích hình chữ nhật</title>
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
            font-size: 20px;
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
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>


<form method="POST" action="Form_Bt1.php" name="form_dientich">
    <table align="center" border="0">
        <tr>
            <th colspan="2">DIỆN TÍCH HÌNH CHỮ NHẬT</th>
        </tr>
        
    
        <?php if (!empty($thongbao)) { ?>
        <tr>
            <td colspan="2" class="error"><?php echo $thongbao; ?></td>
        </tr>
        <?php } ?>

        <tr>
            <td>Chiều dài:</td>
            <td>
                <input type="text" name="chieudai" value="<?php echo isset($_POST['chieudai']) ? $_POST['chieudai'] : ''; ?>">
            </td>
        </tr>
        <tr>
            <td>Chiều rộng:</td>
            <td>
                <input type="text" name="chieurong" value="<?php echo isset($_POST['chieurong']) ? $_POST['chieurong'] : ''; ?>">
            </td>
        </tr>
        <tr>
            <td>Diện tích:</td>
            <td>
                <input type="text" name="dientich" class="bg-readonly" value="<?php echo $dientich; ?>" readonly>
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