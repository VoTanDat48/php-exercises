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
if($conn){
    echo "<br> <b>Kết nối CSDL thành công</b> <br>";
}
//2. Chuan bi cau lenh truy van
$query ='SELECT * FROM khach_hang'; //Where Phai=0
//3. Thuc hien cau truy van
$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');
//4. Xy ly du lieu tra ve
if(mysqli_num_rows($result)!=0){
    while ($row = mysqli_fetch_array($result))
    {
        // echo $row.": ";
        for ($i=0; $i < mysqli_num_fields($result); $i++){
            echo $row[$i] . " ";
        }
        echo "<br>";
    }
}
// 5. Xoa ket qua khoi vung nho va Dong ket noi
mysqli_free_result($result);
mysqli_close($conn);
//?>

