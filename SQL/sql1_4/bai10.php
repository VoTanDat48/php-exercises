<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT So_hoa_don, Ngay_HD, 
          CONCAT(
              CASE DAYOFWEEK(Ngay_HD)
                  WHEN 2 THEN 'Thứ Hai'
                  WHEN 3 THEN 'Thứ Ba'
                  WHEN 4 THEN 'Thứ Tư'
                  WHEN 5 THEN 'Thứ Năm'
                  WHEN 6 THEN 'Thứ Sáu'
                  WHEN 7 THEN 'Thứ Bảy'
                  ELSE 'Chủ Nhật'
              END,
              ' ngày ', DAY(Ngay_HD), ' tháng ', MONTH(Ngay_HD), ' năm ', YEAR(Ngay_HD)
          ) AS Ngay_VN 
          FROM hoa_don ORDER BY Ngay_HD ASC";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Số hóa đơn</th><th>Ngày gốc</th><th>Ngày định dạng tiếng Việt</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_free_result($result); mysqli_close($conn);
?>