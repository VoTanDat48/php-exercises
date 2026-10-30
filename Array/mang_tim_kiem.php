<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Tập Tìm Kiếm Mảng</title>
    <style>
        .main-wrapper {
            width: 480px;
            margin: 40px auto;
            border: 1px solid #2b7a71;
            background-color: #d2dfd8;
            font-family: Arial, Helvetica, sans-serif;
        }

        .header-title {
            text-align: center;
            background-color: #389e95;
            color: #ffffff;
            font-size: 22px;
            font-weight: bold;
            font-style: italic;
            padding: 10px 0;
            margin: 0;
            text-transform: uppercase;
        }

        .form-layout {
            width: 100%;
            padding: 10px 15px;
            border-collapse: collapse;
        }

        .form-layout td {
            padding: 8px 5px;
            font-size: 15px;
        }

        .col-title {
            width: 130px;
        }

        .txt-long {
            width: 310px;
            padding: 4px;
            border: 1px solid #84a2c6;
        }

        .txt-short {
            width: 80px;
            padding: 4px;
            border: 1px solid #84a2c6;
        }

        .txt-result {
            width: 310px;
            padding: 4px;
            border: 1px solid #84a2c6;
            background-color: #dcf5f5;
            color: #ff0000;
            font-weight: bold;
        }

        .btn-submit {
            background-color: #9abbed;
            border: 1px solid #6c8ebf;
            padding: 5px 20px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-submit:hover {
            background-color: #84aae6;
        }

        .bottom-note {
            text-align: center;
            font-size: 14px;
            padding: 8px 0;
            background-color: #73D1D1;
            color: black;
        }
    </style>
</head>
<body>

<?php
    function tim_vi_tri($danh_sach, $gia_tri) {
        foreach ($danh_sach as $index => $phan_tu) {
            if (trim($phan_tu) === trim($gia_tri)) {
                return $index;
            }
        }
        return -1;
    }

    
    $chuoi_nhap = "";
    $gia_tri_tim = "";
    $chuoi_xuat = "";
    $thong_bao = "";

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $chuoi_nhap = isset($_POST["chuoi_nhap"]) ? $_POST["chuoi_nhap"] : "";
        $gia_tri_tim = isset($_POST["gia_tri_tim"]) ? $_POST["gia_tri_tim"] : "";

        if (trim($chuoi_nhap) !== "" && trim($gia_tri_tim) !== "") {
            $arr_so = explode(",", $chuoi_nhap);
            $chuoi_xuat = implode(", ", $arr_so);

            $vi_tri = tim_vi_tri($arr_so, $gia_tri_tim);

            if ($vi_tri !== -1) {
                $vi_tri_thuc_te = $vi_tri + 1; 
                $thong_bao = "Tìm thấy $gia_tri_tim tại vị trí thứ $vi_tri_thuc_te của mảng";
            } else {
                $thong_bao = "Không tìm thấy $gia_tri_tim trong mảng";
            }
        }
    }
?>

    <div class="main-wrapper">
        <h2 class="header-title">Tìm Kiếm</h2>

        <form action="" method="POST">
            <table class="form-layout">
                <tr>
                    <td class="col-title">Nhập mảng:</td>
                    <td>
                        <input type="text" name="chuoi_nhap" class="txt-long" value="<?php echo htmlspecialchars($chuoi_nhap); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="col-title">Nhập số cần tìm:</td>
                    <td>
                        <input type="text" name="gia_tri_tim" class="txt-short" value="<?php echo htmlspecialchars($gia_tri_tim); ?>" required>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Tìm kiếm" class="btn-submit">
                    </td>
                </tr>
                <tr>
                    <td class="col-title">Mảng:</td>
                    <td>
                        <input type="text" class="txt-long" value="<?php echo htmlspecialchars($chuoi_xuat); ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="col-title">Kết quả tìm kiếm:</td>
                    <td>
                        <input type="text" class="txt-result" value="<?php echo htmlspecialchars($thong_bao); ?>" readonly>
                    </td>
                </tr>
            </table>

            <div class="bottom-note">
                (Các phần tử trong mảng sẽ cách nhau bằng dấu ",")
            </div>
        </form>
    </div>

</body>
</html>