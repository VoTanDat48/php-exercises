
<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT hs.Ten_hang_sua, SUM(ct.So_luong) AS Tong_so_luong_ban
          FROM hang_sua hs
          JOIN sua s ON hs.Ma_hang_sua = s.Ma_hang_sua
          JOIN ct_hoadon ct ON s.Ma_sua = ct.Ma_sua
          JOIN hoa_don h ON ct.So_hoa_don = h.So_hoa_don
          WHERE hs.Ma_hang_sua = 'AB'
            AND ((MONTH(h.Ngay_HD) = 7 AND YEAR(h.Ngay_HD) = 2007)
                 OR (MONTH(h.Ngay_HD) = 8 AND YEAR(h.Ngay_HD) = 2007))
          GROUP BY hs.Ma_hang_sua, hs.Ten_hang_sua";

$result = mysqli_query($conn, $query);
if (!$result) die('<br><b>Query failed</b>');

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Tên hãng sữa</th><th>Tổng số lượng bán (Tháng 7 và 8/2007)</th></tr>";

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

