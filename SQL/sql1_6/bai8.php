<?php
$severname = "localhost"; $username = "root"; $password = ""; $dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, "utf8");

// Lấy danh sách có trọng lượng lớn nhất theo từng hãng (hoặc bạn có thể thay MAX thành MIN)
$query = "SELECT hs.Ten_hang_sua, s.Ten_sua, s.Trong_luong 
          FROM sua s 
          JOIN hang_sua hs ON s.Ma_hang_sua = hs.Ma_hang_sua 
          WHERE s.Trong_luong IN (
              SELECT MAX(Trong_luong) FROM sua WHERE Ma_hang_sua = s.Ma_hang_sua
          )";
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

if (mysqli_num_rows($result) != 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Tên hãng sữa</th><th>Tên sữa</th><th>Trọng lượng lớn nhất</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < mysqli_num_fields($result); $i++) { echo "<td>" . $row[$i] . "</td>"; }
        echo "</tr>";
    }
    echo "</table>";
}
mysqli_free_result($result); mysqli_close($conn);
?>