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

$query = "SELECT s.Ten_sua, h.Ten_hang_sua, l.Ten_loai, s.Trong_luong, s.Don_gia, s.Hinh 
          FROM sua s 
          JOIN hang_sua h ON s.Ma_hang_sua = h.Ma_hang_sua 
          JOIN loai_sua l ON s.Ma_loai_sua = l.Ma_loai_sua";

// 3. Thuc hien cau truy van
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông tin các sản phẩm sữa</title>
    <style>
        table {
            width: 700px;
            margin: 0 auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #fcd5b4;
            color: #F96801; 
            text-align: center;
            padding: 10px;
            font-size: 24px;
            border: 1px solid #ccc;
        }
        td {
            padding: 10px;
            border: 1px solid #ccc;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: white;
        }
        tr:nth-child(odd) {
            background-color: white; 
        }
        .ten-sua {
            color: black;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .info-text {
            color: #333;
            line-height: 1.5;
        }
        .img-sua {
            text-align: center;
        }
        .img-sua img {
            width: 80px;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <?php
    if (mysqli_num_rows($result) != 0) {
        echo "<table>";
        echo "<tr>
                <th colspan='2'>THÔNG TIN CÁC SẢN PHẨM</th>
              </tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            
            // Cột 1: Trỏ ra ngoài một cấp (..) rồi vào đúng thư mục Hinh_sua của bạn
            $ten_file_anh = trim($row['Hinh']);
            echo "<td class='img-sua' width='25%'>";
            echo "<img src='../Hinh_sua/" . $ten_file_anh . "' alt='" . $row['Ten_sua'] . "'>";
            echo "</td>";
            
            // Cột 2: Nội dung chi tiết sản phẩm
            echo "<td class='info-text' width='75%'>";
            echo "<div class='ten-sua'>" . $row['Ten_sua'] . "</div>";
            echo "<div>Nhà sản xuất: " . $row['Ten_hang_sua'] . "</div>";
            
            // Định dạng đơn giá kiểu tiền tệ
            $don_gia = number_format($row['Don_gia'], 0, ',', '.') . " VNĐ";
            echo "<div>" . $row['Ten_loai'] . " - " . $row['Trong_luong'] . " gr - " . $don_gia . "</div>";
            
            echo "</td>";
            
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