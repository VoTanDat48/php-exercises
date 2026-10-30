<?php
$severname="localhost";
$username="root";
$password="";
$dbname="quanly_ban_sua";

$conn = mysqli_connect($severname, $username, $password, $dbname);

if(!$conn){
    die("Loi Ket Noi" . mysqli_connect_error());
}
mysqli_set_charset($conn, 'UTF8');

$rowPerPage = 3;
if(!isset($_GET['page'])){
    $_GET['page'] = 1;
}
$offset = ($_GET['page']-1) * $rowPerPage;

$query = "SELECT Ma_khach_hang, Ten_khach_hang, Dia_chi
            From khach_hang
            LIMIT $offset,$rowPerPage;
        ";
$result = mysqli_query($conn,$query);
$result_all = mysqli_query($conn,"SELECT * from khach_hang");

$numrows = mysqli_num_rows($result_all);
$numfields = mysqli_num_fields($result);
$maxPage = ceil($numrows / $rowPerPage);

?>

<form action="" method="POST">
    <table border="1" align="center">
        <tr>
            <th>MÃ KHÁCH HÀNG</th>
            <th>TÊN KHÁCH HÀNG</th>
            <th>ĐỊA CHỈ</th>
        </tr>
        <?php
        if(mysqli_num_rows($result) !=0 ){
            $stt =$offset + 1;
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                for($i = 0; $i < $numfields ; $i++){
                    echo "<td>".$row[$i]."</td>";
                }
                
                echo "</tr>";
                $stt++;
            }
        }
        ?>

    </table>
    <?php
    echo "<p align= 'center' >";
    if($_GET['page']>1){
        echo "<a href= " . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] - 1) . ">Back </a>";
    }
    for($i= 1 ; $i <= $maxPage ;$i++){
        if($i == $_GET['page']){
            echo "<b>".$i."</b>";
        }else{
            echo "<a href = " . $_SERVER['PHP_SELF'] . "?page=" . $i . "> $i";
        }
    }
    if($_GET['page']<$maxPage){
        echo "<a href= " . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] +1 ) . ">Next </a>";
    }

    echo "</p>";

    mysqli_free_result($result);
    mysqli_free_result($result_all);
    mysqli_close($conn);
    ?>


</form>