<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT DISTINCT s.Ten_sua, CONCAT(s.Trong_luong, ' gr') AS Trong_luong, CONCAT(FORMAT(ct.Don_gia, 0), ' VNĐ') AS Don_gia
          FROM sua s
          JOIN ct_hoadon ct ON s.Ma_sua = ct.Ma_sua
          JOIN hoa_don h ON ct.So_hoa_don = h.So_hoa_don
          WHERE MONTH(h.Ngay_HD) = 8 AND YEAR(h.Ngay_HD) = 2007";

$result = mysqli_query($conn, $query);
if (!$result) die('<br><b>Query failed</b>');

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Tên sữa</th><th>Trọng lượng</th><th>Đơn giá</th></tr>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    for ($i = 0; $i < mysqli_num_fields($result); $i++) {
        echo "<td>" . $row[$i] . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

mysqli_free_result($result);
mysqli_close($conn);
?>

