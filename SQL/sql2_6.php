<?php
//1. Ket noi CSDL kieu thu tuc
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

// 2. Truy vấn lấy tất cả sản phẩm sữa
$query = "SELECT Ten_sua, Trong_luong, Don_gia, Hinh FROM sua";

$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông tin các sản phẩm sữa - Dạng cột</title>
    <style>
        table.main-table {
            width: 900px;
            margin: 0 auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
        }
        th.main-header {
            background-color: #fcd5b4;
            color: #F96801; 
            text-align: center;
            padding: 10px;
            font-size: 24px;
            border: 1px solid #ccc;
        }
        td.cell-product {
            width: 20%; 
            text-align: center;
            padding: 15px 10px;
            border: 1px solid #ccc;
            vertical-align: top;
        }
        .ten-sua {
            color: black;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .info-text {
            color: #333;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .img-sua img {
            width: 70px;
            height: 90px;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <?php
    if (mysqli_num_rows($result) != 0) {
        echo "<table class='main-table'>";
        echo "<tr>
                <th colspan='5' class='main-header'>THÔNG TIN CÁC SẢN PHẨM</th>
              </tr>";

        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            
            if ($i % 5 == 0) {
                echo "<tr>";
            }

            echo "<td class='cell-product'>";
            
            
            echo "<div class='ten-sua'>" . $row['Ten_sua'] . "</div>";
            
           
            $don_gia = number_format($row['Don_gia'], 0, ',', '.') . " VNĐ";
            echo "<div class='info-text'>" . $row['Trong_luong'] . " gr - " . $don_gia . "</div>";
            
            // Hình ảnh sản phẩm (trỏ vào thư mục Hinh_sua của bạn)
            $ten_file_anh = trim($row['Hinh']);
            echo "<div class='img-sua'>";
            echo "<img src='../Hinh_sua/" . $ten_file_anh . "' alt='" . $row['Ten_sua'] . "'>";
            echo "</div>";

            echo "</td>";

            $i++;
            // Nếu đủ 5 cột thì đóng hàng lại
            if ($i % 5 == 0) {
                echo "</tr>";
            }
        }

        // Xử lý trường hợp số lượng sản phẩm không chia hết cho 5 để đóng thẻ <tr> cuối cùng nếu thiếu ô trống
        if ($i % 5 != 0) {
            $du = 5 - ($i % 5);
            for ($j = 0; $j < $du; $j++) {
                echo "<td></td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    }

    // Xóa kết quả và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

</body>
</html>