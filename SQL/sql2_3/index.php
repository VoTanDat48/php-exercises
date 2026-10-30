<?php
//1. Ket noi CSDL kieu thu tuc
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua"; // Thay đổi tên CSDL nếu máy bạn đặt khác nhé
$conn = mysqli_connect($severname, $username, $password, $dbname);

//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Chuan bi cau lenh truy van (Đọc bảng khach_hang)
$query = "SELECT Ma_khach_hang, Ten_khach_hang, Phai, Dia_chi, Dien_thoai FROM khach_hang";

// 3. Thuc hien cau truy van
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông tin khách hàng</title>
    <style>
        table {
            width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        th {
            background-color: white;
            color: #9c0006; 
            text-align: center;
            padding: 8px;
            border: 1px solid #999;
        }
        td {
            padding: 8px;
            border: 1px solid #999;
        }
        tr:nth-child(even) {
            background-color: #FEE0C1;
        }
        tr:nth-child(odd) {
            background-color: white; 
            color: #BC1C72;
        }
        h2 {
            text-align: center;
            color: black;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

    <h2>THÔNG TIN KHÁCH HÀNG</h2>

    <?php
    if (mysqli_num_rows($result) != 0) {
        echo "<table>";
        echo "<tr>
                <th>Mã KH</th>
                <th>Tên khách hàng</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
              </tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['Ma_khach_hang'] . "</td>";
            echo "<td>" . $row['Ten_khach_hang'] . "</td>";
            
            // Sửa đường dẫn trỏ trực tiếp vào thư mục hinh nằm cùng cấp với index.php
            if ($row['Phai'] == 0) {
                $img_gt = "<img src='hinh/nam.png' width='25' height='25'>";
            } else {
                $img_gt = "<img src='hinh/nu.png' width='25' height='25'>";
            }
            echo "<td align='center'>" . $img_gt . "</td>";
            
            echo "<td>" . $row['Dia_chi'] . "</td>";
            echo "<td>" . $row['Dien_thoai'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

</body>
</html>