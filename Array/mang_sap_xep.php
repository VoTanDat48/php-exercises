<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 6</title>
    <style>
        .form-container {
            width: 500px;
            margin: 30px auto;
            border: 1px solid #008080;
            background-color: #d1e0d7;
            font-family: Arial, sans-serif;
        }

        .title {
            text-align: center;
            background-color: #20b2aa;
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
            width: 130px;
            font-size: 14px;
            background-color: #CCE6E7;
        }

        .label2 {
            width: 130px;
            font-size: 14px;
            
        }

        .section-label {
            color: red;
            font-weight: bold;
            background-color: #CCE6E7;
        }

        .input-text {
            width: 280px;
            padding: 3px;
            border: 1px solid #7f9db9;
        }

        .input-readonly {
            width: 280px;
            padding: 3px;
            border: 1px solid #7f9db9;
            background-color: #c0f9c0;
            color: black;
            font-weight: bold;
            background-color: #C4F6F5;
        }

        .btn-tinh {
            background-color: #ffffff;
            border: 1px solid #7f9db9;
            padding: 3px 15px;
            cursor: pointer;
        }

        .footer-note {
            text-align: center;
            font-size: 13px;
            padding-bottom: 12px;
            color: red;
            font-weight: bold;
        }

        .note-red {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
function hoan_vi(&$a, &$b) {
    $temp = $a;
    $a = $b;
    $b = $temp;
}

function sap_tang($mang) {
    $n = count($mang);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ((float)trim($mang[$i]) > (float)trim($mang[$j])) {
                hoan_vi($mang[$i], $mang[$j]);
            }
        }
    }
    return $mang;
}

function sap_giam($mang) {
    $n = count($mang);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ((float)trim($mang[$i]) < (float)trim($mang[$j])) {
                hoan_vi($mang[$i], $mang[$j]);
            }
        }
    }
    return $mang;
}

$day_so = "";
$mang_tang_str = "";
$mang_giam_str = "";

if (isset($_POST["sap_xep"])) {
    $day_so = $_POST["day_so"] ?? "";

    if (trim($day_so) != "") {
        $mang = explode(",", $day_so);

        $mang_tang = sap_tang($mang);
        $mang_giam = sap_giam($mang);

        $mang_tang_str = implode(", ", $mang_tang);
        $mang_giam_str = implode(", ", $mang_giam);
    }
}
?>

    <div class="form-container">
        <div class="title">SẮP XẾP MẢNG</div>

        <form action="mang_sap_xep.php" method="POST">
            <table class="calc-table">
                <tr>
                    <td class="label2">Nhập mảng:</td>
                    <td>
                        <input type="text" name="day_so" class="input-text" value="<?php echo $day_so; ?>" required>
                        <span class="note-red">(*)</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="sap_xep" class="btn-tinh">Sắp xếp tăng/giảm</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="section-label">Sau khi sắp xếp:</td>
                </tr>
                <tr class="label">
                    <td >Tăng dần:</td>
                    <td>
                        <input type="text" class="input-readonly" value="<?php echo $mang_tang_str; ?>" readonly>
                    </td>
                </tr>
                <tr class="label">
                    <td >Giảm dần:</td>
                    <td >
                        <input type="text" class="input-readonly" value="<?php echo $mang_giam_str; ?>" readonly>
                    </td>
                </tr>
            </table>

            <div class="footer-note">
                <span class="note-red">(*)</span> Các số được nhập cách nhau bằng dấu ","
            </div>
        </form>
    </div>
</body>
</html>