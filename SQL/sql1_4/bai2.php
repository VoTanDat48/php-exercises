
<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";

$conn = mysqli_connect($severname, $username, $password, $dbname);

if (!$conn) die("Connection failed: " . mysqli_connect_error());

mysqli_set_charset($conn, "utf8");

$query = "SELECT * FROM hoa_don
          WHERE MONTH(Ngay_HD) = 7
          AND YEAR(Ngay_HD) = 2007";

$result = mysqli_query($conn, $query);

if (!$result) die('<br><b>Query failed</b>');

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>
        <th>Số hóa đơn</th>
        <th>Ngày hóa đơn</th>
        <th>Mã khách hàng</th>
        <th>Trị giá</th>
      </tr>";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['So_HD'] . "</td>";
        echo "<td>" . $row['Ngay_HD'] . "</td>";
        echo "<td>" . $row['Ma_khach_hang'] . "</td>";
        echo "<td>" . $row['Tri_gia'] . "</td>";
        echo "</tr>";
    }
}

echo "</table>";

mysqli_free_result($result);
mysqli_close($conn);
?>

