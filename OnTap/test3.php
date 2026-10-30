<?php
$dayso = "";
$chon = "1";
$kq ="";

function ktSNT($num){
    if($num < 2){
        return false;
    }else{
        for($i = 2; $i*$i <= $num ; $i++){
            if($num % $i == 0){
                return false;
            }
        }
    }
    return true;
}

if(isset($_POST["btn"])){
    $dayso =$_POST["txtDaySo"];
    $chon = $_POST["opt"];

    if(empty(trim($dayso))){
        $kq= "Vui lòng nhập dãy số vào";
    }else{
        $mang = explode(",", $dayso);

        $mang_moi= [];
        $loi = false;
        foreach($mang as $so){
            if($so === "") {
                continue; 
            }
            if(!is_numeric($so)){
                $kq = "Phải nhập số vào dãy";
                $loi = true;
                break;
            }else{
                $so = (int)trim($so);
                $mang_moi[] = $so;
            }
        }
        if($loi === false){
        if($chon == "1"){
            $dem=0;
            foreach($mang_moi as $so){
                if(ktSNT($so)){
                    $dem++;
                }
            }
            $kq= "Tổng số nguyên tố có trong dãy là: ".$dem;
        }elseif($chon == "2"){
            $dem_3=0;
            foreach($mang_moi as $so){
                if($so % 3 ==0){
                    $dem_3++;
                }
            }
            $kq= "Tổng số chia hết cho 3 có trong dãy là: ".$dem_3;
        }
        }
    }
}


?>

<form method="post">
    <table >
        <tr style="display: flex; align-items: center;">
            <td>Nhập các Dãy số: </td>
            <td><textarea name="txtDaySo" rows="1" cols="25"><?php echo $dayso ?></textarea></td>
        </tr>
        <tr>
            <td><input type="radio" name="opt" value="1" <?php if($chon == "1") echo "checked"?>>Đếm các số nguyên tố</td>
        </tr>
        <tr>
            <td><input type="radio" name="opt" value="2" <?php if($chon == "2") echo "checked"?>>Tính tổng các số chia hết cho 3</td>
        </tr>
        <tr>
            <td><input type="submit" name="btn" value="Thực hiện"></td>
        </tr>
        <tr>
            <td><textarea name="ketqua" rows="4" cols="40" readonly><?php echo $kq ?></textarea></td>
        </tr>

    </table>

</form>