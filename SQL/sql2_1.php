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
if($conn){
    echo "<br> <b>Kết nối CSDL thành công</b> <br>";
}


echo "<h2 align='center' style='color: #2A7FAA; font-style: italic;'>THÔNG TIN HÃNG SỮA</h2>";

//2. Chuan bi cau lenh truy van (Bổ sung thêm Ma_hang_sua và Email)
$query = "SELECT Ma_hang_sua, Ten_hang_sua, Dia_chi, Dien_thoai, Email FROM hang_sua";

//3. Thuc hien cau truy van
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

//4. Xy ly du lieu tra ve
if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0' align='center'>";
    echo "<tr>
            <th>Mã HS</th>
            <th>Tên hãng sữa</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Email</th>
          </tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        // Vòng lặp duyệt qua các trường (fields) sẽ tự động in đủ 5 cột theo đúng thứ tự câu lệnh SELECT
        for ($i = 0; $i < mysqli_num_fields($result); $i++) {
            echo "<td>" . $row[$i] . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}

// 5. Xoa ket qua khoi vung nho va Dong ket noi
mysqli_free_result($result);
mysqli_close($conn);
?>