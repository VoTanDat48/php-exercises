<?php
$k = "";
$n = "";
$kq = "";

function giaithua($num){
    $gt = 1;
    for($i=1 ; $i<= $num ; $i++){
        $gt *= $i;
    }
    return $gt;
}

if(isset($_POST["btn"])){
    $k = $_POST["txtK"];
    $n = $_POST["txtN"];

    if($k == "" || $n == ""){
        $kq = "Vui lòng đừng để K hoặc N trống!!";
    }elseif(!is_numeric($k) ||!is_numeric($n) ){
        $kq = "K Và N phải là sô nguyên";
    }else{
        $k = (int)$k;
        $n = (int)$n;
        if($k==0 || $n==0){
            $kq="K Và N Phải khác 0";
        }elseif($k > $n){
            $kq = "K không được lớn hơn N";
        }else{
            $tohop = giaithua($n) / giaithua($k) * giaithua($n-$k);

            $kq .= "Tổ hợp chập ".$k." của ".$n." phần tử là ".$tohop.". <br>
            Có ".$tohop." cách chọn ra ".$k." phần tử từ một tập hợp có ".$n." phần tử.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST2</title>
</head>
<body style="display: flex;justify-content: center; align-items: center;">
    <form method="post">
    <table >
        <tr>
            <td><h3>Tính Tổ Hợp Chập K của N phần tử</h3></td>
        </tr>
        <tr>
           <td> K: <input type="text" name="txtK" value="<?php echo $k ?>"></td>
        </tr>
        <tr>
           <td> N: <input type="text" name="txtN" value="<?php echo $n ?>"></td>
        </tr>
        <tr >
            <td><input type="submit" name="btn" value="Kết quả" style="background-color: blue; color: white;"></td>
        </tr>
        <tr>
            <td><?php echo $kq ?></td>
        </tr>

    </table>
    </form>
</body>
</html>