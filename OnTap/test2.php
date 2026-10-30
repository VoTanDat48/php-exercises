<?php
$dayso = "";
$chon = "1";
$kq = "";
$tong = 0;
if(isset($_POST["btn"])){
    $dayso = $_POST["txtDayso"];
    $chon = $_POST["opt"];

    if(empty(trim($dayso))){
        $kq = "Vui lòng nhập dãy số";
    }else{
        $mang = explode(",",$dayso);

        $mang_moi = [];
        foreach($mang as $item){
            $item = trim($item);
            if(!is_numeric($item)){
                $kq = "Vui lòng nhập dãy số nguyên";
            }else{
                
                $mang_moi[] = (int)$item;
            }
        }

    if($chon == "1"){
        foreach($mang_moi as $item){
            
            if($item % 2 ==0){
                $tong += $item;
            }
        }
        $kq = "Tổng của các số chẵn trong dãy là: ". $tong;
    }elseif($chon == "2"){
        $max = max($mang_moi);
        $min = min($mang_moi);

        $kq = "Max = ".$max.". \nMin = ".$min;
    }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test1</title>
</head>
<body>

    <div>
        <form method="post">
            <table>
            <tr>
                <td><h3>Công cụ tính toán trên dãy số online</h3></td>
            </tr>
            <tr style="display: flex; align-items: center; gap: 10px;">
                <td>Nhập dãy số:</td>
                <td><textarea name="txtDayso" rows="1" placeholder="VD: 1,2,3,.."><?php echo $dayso ?></textarea></td>
            </tr>
            <tr>
                <td>Chọn chức năng:</td>
            </tr>
            <tr>
                <td><input type="radio" name="opt" value="1" <?php if($chon == "1") echo "checked"?>> Tính tổng các số chẵn</td>
            </tr>
            <tr>
                <td><input type="radio" name="opt" value="2" <?php if($chon == "2") echo "checked"?>> Tìm số lớn nhất và nhỏ nhất</td>
            </tr>
            <tr>
                <td><input type="submit" name="btn" value="Tính Toán"></td>
            </tr>
            <tr>
                <td><textarea name="ketqua" cols="40" rows="4" readonly><?php echo $kq ?></textarea></td>
            </tr>
            </table>
        </form>
    </div>
    
</body>
</html>