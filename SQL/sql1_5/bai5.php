<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT h.So_hoa_don, h.Ngay_HD, SUM(ct.So_luong) AS Tong_so_luong, SUM(ct.So_luong * ct.Don_gia) AS Tong_thanh_tien 
          FROM hoa_don h 
          JOIN ct_hoadon ct ON h.So_hoa_don = ct.So_hoa_don 
          GROUP BY h.So_hoa_don, h.Ngay_HD";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Số hóa đơn</th><th>Ngày hóa đơn</th><th>Tổng số lượng</th><th>Tổng thành tiền</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_free_result($result); mysqli_close($conn);
?>