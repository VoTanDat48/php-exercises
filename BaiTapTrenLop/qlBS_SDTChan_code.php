<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <?php
//1. Ket noi CSDL kieu thu tuc
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);
//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'UTF8');
// if($conn){
//     echo "<br> <b>Kết nối CSDL thành công</b> <br>";
// }
//2. Chuan bi cau lenh truy van
$query ='SELECT * FROM khach_hang';
    
//3. Thuc hien cau truy van
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');
$numfields = mysqli_num_fields($result);
$numrows = mysqli_num_rows($result);
//?>

<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Mã khách hàng</th>
        <th>Tên khách hàng</th>
        <th>Phái</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Email</th>
    </tr>
    <?php
        //4 Xu Ly du lieu tra ve
        if($numrows!=0){
            while ($row = mysqli_fetch_array($result))
            {
                if ($row[4] % 2 == 0) {
                    echo "<tr>";
                    $numfields = mysqli_num_fields($result);
                    for ($i=0; $i < $numfields; $i++){
                        if($i==2){
                            if($row[$i]==0) echo "<td>Nam</td>";
                            else echo "<td>Nữ</td>";
                        }
                        else echo "<td>".$row[$i]."</td>";
                    }
                    echo "</tr>";
                }
            }
        }
        // 5. Xoa ket qua khoi vung nho va Dong ket noi
        mysqli_free_result($result);
        mysqli_close($conn);
    ?>
</table>
</body>
</html>