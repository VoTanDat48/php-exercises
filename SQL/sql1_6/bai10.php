<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

$query = "SELECT hs.Ten_hang_sua, s.Ten_sua, s.Trong_luong 
          FROM sua s 
          JOIN hang_sua hs ON s.Ma_hang_sua = hs.Ma_hang_sua 
          WHERE hs.Ten_hang_sua LIKE '%Dutch Lady%' 
            AND s.Trong_luong = (
                SELECT MAX(Trong_luong) FROM sua s2 
                JOIN hang_sua hs2 ON s2.Ma_hang_sua = hs2.Ma_hang_sua 
                WHERE hs2.Ten_hang_sua LIKE '%Dutch Lady%'
            )";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Tên hãng sữa</th><th>Tên sữa</th><th>Trọng lượng cao nhất</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Không tìm thấy dữ liệu phù hợp.</p>";
}
mysqli_free_result($result); mysqli_close($conn);
?>