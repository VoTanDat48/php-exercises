<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";

$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

mysqli_set_charset($conn, "utf8");

$query = "SELECT Ten_khach_hang, Phai, Dia_chi, Dien_thoai
          FROM khach_hang
          ORDER BY Phai ASC";

$result = mysqli_query($conn, $query);
if (!$result) die('<br><b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Tên khách hàng</th>
            <th>Phái</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
          </tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Ten_khach_hang'] . "</td>";

        
        if ($row['Phai'] == 0) {
            echo "<td>Nam</td>";
        } else {
            echo "<td>Nữ</td>";
        }

        echo "<td>" . $row['Dia_chi'] . "</td>";
        echo "<td>" . $row['Dien_thoai'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

mysqli_free_result($result);
mysqli_close($conn);
?>
```
