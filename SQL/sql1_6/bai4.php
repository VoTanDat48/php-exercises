<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT * FROM hang_sua 
          WHERE Ma_hang_sua NOT IN (
              SELECT DISTINCT Ma_hang_sua FROM sua
          )";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Mã hãng sữa</th><th>Tên hãng sữa</th><th>Địa chỉ</th><th>Điện thoại</th><th>Email</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Không có hãng nào chưa có sản phẩm sữa.</p>";
}
mysqli_free_result($result); mysqli_close($conn);
?>