<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT Ten_sua, Don_gia, Trong_luong FROM sua WHERE Don_gia > 100000 ORDER BY Ten_sua DESC";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Tên sữa</th><th>Đơn giá</th><th>Trọng lượng</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_free_result($result); mysqli_close($conn);
?>