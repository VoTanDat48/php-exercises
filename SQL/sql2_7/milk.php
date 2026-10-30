<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua"; 
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

if (isset($_GET['ma_sua'])) {
    $ma_sua = $_GET['ma_sua'];
} else {
    $ma_sua = 'AB0001'; 
}

$query = "SELECT s.*, h.Ten_hang_sua, l.Ten_loai 
          FROM sua s 
          JOIN hang_sua h ON s.Ma_hang_sua = h.Ma_hang_sua 
          JOIN loai_sua l ON s.Ma_loai_sua = l.Ma_loai_sua 
          WHERE s.Ma_sua = '$ma_sua'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chi tiết sản phẩm sữa</title>
    <style>
        .detail-table {
            width: 750px;
            margin: 30px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            border: 2px solid #e08b52; 
        }
        .detail-header {
            background-color: #fef0e6;
            color: #b25900; 
            text-align: center;
            padding: 12px;
            font-size: 22px;
            font-style: italic;
            font-weight: bold;
            border-bottom: 2px solid #e08b52;
        }
        .detail-content td {
            padding: 15px;
            vertical-align: top;
            border: 1px solid #e08b52;
        }
        .img-box {
            text-align: center;
            width: 35%;
        }
        .img-box img {
            width: 170px;
            height: auto;
            object-fit: contain;
        }
        .info-box {
            width: 65%;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .section-title {
            color: #b25900;
            font-weight: bold;
            font-style: italic;
            font-size: 15px;
            margin-bottom: 3px;
        }
        .price-weight {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
            font-size: 15px;
        }
        .back-link {
            text-align: center;
            padding: 10px;
            background-color: #fef0e6;
            border-top: 2px solid #e08b52;
        }
        .back-link a {
            color: #b25900;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php if ($row) { ?>
        <table class="detail-table">
            <tr>
                <th colspan="2" class="detail-header">
                    <?php echo $row['Ten_sua'] . " - " . $row['Ten_hang_sua']; ?>
                </th>
            </tr>
            
            <tr class="detail-content">
                <!-- Lùi 2 cấp thư mục (../../) để lấy ảnh từ Hinh_sua[cite: 27, 28] -->
                <td class="img-box">
                    <img src="../../Hinh_sua/<?php echo trim($row['Hinh']); ?>" alt="<?php echo $row['Ten_sua']; ?>">
                </td>
                
                <td class="info-box">
                    <div class="section-title">Thành phần dinh dưỡng:</div>
                    <div><?php echo $row['TP_Dinh_Duong']; ?></div>
                    
                    <div class="section-title" style="margin-top: 12px;">Lợi ích:</div>
                    <div><?php echo $row['Loi_ich']; ?></div>
                    
                    <div class="price-weight">
                        Trọng lượng: <?php echo $row['Trong_luong']; ?> gr &nbsp;-&nbsp; 
                        Đơn giá: <?php echo number_format($row['Don_gia'], 0, ',', '.'); ?> VNĐ
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="back-link">
                    <a href="list.php">Quay về</a>
                </td>
            </tr>
        </table>
    <?php } else {
        echo "<p style='text-align:center;'>Không tìm thấy thông tin sản phẩm!</p>";
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

</body>
</html>