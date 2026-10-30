<?php
$severname ="localhost";
$username="root";
$password="";
$dbname="quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn , 'UTF8');

$rowperpage = 5;
if(!isset($_GET['page'])){
    $_GET['page'] = 1;
}
$offset = ($_GET['page'] - 1) * $rowperpage;

$query = "SELECT * FROM sua LIMIT $offset, $rowperpage";

$result = mysqli_query($conn, $query);
if (!$result) die ('<br> <b>Query failed</b>');

$result_all = mysqli_query($conn, "SELECT * FROM sua");
$numrows = mysqli_num_rows($result_all);
$maxpage = ceil($numrows / $rowperpage);
$numfields = mysqli_num_fields($result);
?>

<form action="" method="post">
    <table border="1">
        "<tr>
        
        <th >Mã Sữa</th>
        <th >Tên Sữa</th>
        <th >Hãng Sữa</th>
        <th >Loại Sữa</th>
        <th >Trọng Lượng</th>
        <th >Đơn Giá</th>
      </tr>"
    
    <?php
    if(mysqli_num_rows($result) != 0){

    $stt = $offset+1;
    
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            
            for($i=0 ; $i < $numfields; $i++){
                
                echo "<td>".$row[$i]."</td>";
            }
            echo "</tr>";
            $stt++ ;
        }
    }
        

    ?>
    </table>
   
    <?php
    echo "<p align = 'center' >";

    if($_GET['page'] > 1){
        echo "<a href = ". $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] - 1) . ">Back </a>&nbsp; ";
    }
    // Danh sách các số trang
    for ($i = 1; $i <= $maxpage; $i++) {
    if ($i == $_GET['page']) {
        echo "<b> $i</b>&nbsp; "; 
    } else {
        echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . $i . "> $i </a>&nbsp; ";
    }
}

// Nút Next (Chỉ hiển thị khi trang hiện tại < tổng số trang)
if ($_GET['page'] < $maxpage) {
    echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] + 1) . "> Next </a>";
}

echo "</p>";

// 7. Giải phóng bộ nhớ và đóng kết nối
mysqli_free_result($result);
mysqli_free_result($result_all);
mysqli_close($conn);
    ?>

</form>