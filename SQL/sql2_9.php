<?php
//1. Kết nối CSDL kiểu thủ tục
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua"; 
$conn = mysqli_connect($severname, $username, $password, $dbname);

//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// 2. Nhận từ khóa tìm kiếm từ form gửi lên
$search_ten = "";
if (isset($_GET['ten_sua'])) {
    $search_ten = trim($_GET['ten_sua']);
}

// 3. Xây dựng câu truy vấn tìm kiếm theo tên sữa (tương đối sử dụng LIKE)
$query = "SELECT s.*, h.Ten_hang_sua, l.Ten_loai 
          FROM sua s 
          JOIN hang_sua h ON s.Ma_hang_sua = h.Ma_hang_sua 
          JOIN loai_sua l ON s.Ma_loai_sua = l.Ma_loai_sua 
          WHERE s.Ten_sua LIKE '%$search_ten%'";

$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tìm kiếm thông tin sữa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FDFEF0; /* Màu nền kem nhạt giống mẫu */
            margin: 0;
            padding: 0;
        }
        .search-container {
            width: 800px;
            margin: 0 auto;
            background-color: #ffcccc; /* Màu nền hồng nhạt phần tiêu đề tìm kiếm */
            border-top: 1px solid #ff9999;
            border-bottom: 1px solid #ff9999;
            padding: 12px 0;
            text-align: center;
        }
        .search-title {
            color: #FE2F5B; /* Chữ hồng đậm tiêu đề */
            font-size: 24px;
            font-style: italic;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .search-box {
            font-size: 14px;
            font-weight: bold;
            color: #8E2710;
        }
        .search-box input[type="text"] {
            width: 250px;
            padding: 3px;
            border: 1px solid #999;
        }
        .search-box input[type="submit"] {
            padding: 3px 10px;
            background-color: #e6e6e6;
            border: 1px solid #999;
            cursor: pointer;
        }
        .result-count {
            text-align: center;
            font-weight: bold;
            margin: 15px 0;
            color: #333;
            font-size: 14px;
        }
        .detail-table {
            width: 750px;
            margin: 15px auto;
            border-collapse: collapse;
            border: 1px solid #e08b52; /* Viền cam đất */
            background-color: #fff;
        }
        .detail-header {
            background-color: #fef0e6;
            color: #c05020; /* Màu chữ tiêu đề sữa cam nâu in nghiêng */
            text-align: center;
            padding: 8px;
            font-size: 18px;
            font-style: italic;
            font-weight: bold;
            border-bottom: 1px solid #e08b52;
        }
        .detail-content td {
            padding: 10px;
            vertical-align: top;
            border: 1px solid #e08b52;
        }
        .img-box {
            text-align: center;
            width: 28%;
        }
        .img-box img {
            width: 140px;
            height: auto;
            object-fit: contain;
        }
        .info-box {
            width: 72%;
            font-size: 13px;
            line-height: 1.4;
            color: #333;
        }
        .section-title {
            color: black;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 2px;
        }
        .price-weight {
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
            font-size: 13px;
        }
        .price-weight .highlight-num {
            color: #9B3957; /* Màu sắc số giá tiền theo yêu cầu */
        }
        .not-found {
            text-align: center;
            color: #cc0066;
            font-weight: bold;
            margin-top: 20px;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <!-- Form tìm kiếm chuẩn giao diện mẫu -->
    <div class="search-container">
        <div class="search-title">TÌM KIẾM THÔNG TIN SỮA</div>
        <hr style="border: none; height: 4px; background-color: #FDFEF0;">
        <form action="" method="GET" class="search-box">
            <label>Tên sữa:</label>
            <input type="text" name="ten_sua" value="<?php echo htmlspecialchars($search_ten); ?>">
            <input type="submit" style="background-color: #FFCCCC;" value="Tìm kiếm">
        </form>
    </div>

    <?php
    // Hiển thị số sản phẩm tìm thấy
    if (isset($_GET['ten_sua'])) {
        if ($num_rows > 0) {
            echo "<div class='result-count'>Có $num_rows sản phẩm được tìm thấy</div>";
        } else {
            echo "<div class='not-found'>Không tìm thấy sản phẩm này</div>";
        }
    }

    // Hiển thị danh sách kết quả dạng list chi tiết
    if ($num_rows != 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<table class='detail-table'>";
            
            // Tiêu đề: Tên sữa - Tên hãng sữa
            echo "<tr>";
            echo "<th colspan='2' class='detail-header'>" . $row['Ten_sua'] . " - " . $row['Ten_hang_sua'] . "</th>";
            echo "</tr>";
            
            echo "<tr class='detail-content'>";
            
            // Cột hình ảnh sản phẩm
            echo "<td class='img-box'>";
            echo "<img src='../Hinh_sua/" . trim($row['Hinh']) . "' alt='" . $row['Ten_sua'] . "'>";
            echo "</td>";
            
            // Cột thông tin chi tiết
            echo "<td class='info-box'>";
            echo "<div class='section-title'>Thành phần dinh dưỡng:</div>";
            echo "<div>" . $row['TP_Dinh_Duong'] . "</div>";
            
            echo "<div class='section-title' style='margin-top: 8px;'>Lợi ích:</div>";
            echo "<div>" . $row['Loi_ich'] . "</div>";
            
            echo "<div class='price-weight'>";
            echo "Trọng lượng: <span class='highlight-num'>" . $row['Trong_luong'] . " gr</span> &nbsp;-&nbsp; Đơn giá: <span class='highlight-num'>" . number_format($row['Don_gia'], 0, ',', '.') . " VNĐ</span>";
            echo "</div>";
            
            echo "</td>";
            
            echo "</tr>";
            echo "</table>";
        }
    }

    // Xóa kết quả và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

</body>
</html>