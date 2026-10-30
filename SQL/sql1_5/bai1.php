<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT hs.Ten_hang_sua, COUNT(s.Ma_sua) AS Tong_so_san_pham 
          FROM hang_sua hs 
          JOIN sua s ON hs.Ma_hang_sua = s.Ma_hang_sua 
          GROUP BY hs.Ma_hang_sua, hs.Ten_hang_sua 
          ORDER BY Tong_so_san_pham ASC";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Tên hãng sữa</th><th>Tổng số sản phẩm</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_free_result($result); mysqli_close($conn);
?>