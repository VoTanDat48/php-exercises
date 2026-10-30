<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");


$query = "SELECT * FROM khach_hang WHERE Phai = 0 AND Ten_khach_hang LIKE 'N%'";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Mã KH</th><th>Tên khách hàng</th><th>Phái</th><th>Địa chỉ</th><th>Điện thoại</th><th>Email</th></tr>";
    
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) {
           
            if ($i == 2) {
                $phai_text = ($row[$i] == 0) ? "Nam" : "Nữ";
                echo "<td>" . $phai_text . "</td>";
            } else {
                echo "<td>" . $row[$i] . "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_free_result($result); mysqli_close($conn);
?>