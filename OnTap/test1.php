<?php
$chuoi = "";
$chon = "1";
$kytu ="";
$ketqua = "";

if(isset($_POST["btn"])){
    $chuoi = $_POST["txtChuoi"];
    $chon = $_POST["opt"];

    if(empty(trim($chuoi))){
        $ketqua = "Lỗi : Vui Lòng Nhập Chuỗi";
    }else {
        if($chon == "1"){
            $kytu = $_POST["txtkytu"];
            if(empty(trim($kytu))){
                $ketqua = "Lỗi :Vui Lòng Nhập Ký Tự";
            }else{
                $mang = explode($kytu,$chuoi);

                $ketqua ="";
                foreach($mang as $item){
                    $ketqua .= trim($item). "\n";
                }
            }
        }elseif($chon == "2"){
            $ketqua =preg_replace('/[^\p{L}\p{N}\s]/u', '',$chuoi);
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body style="display: flex; justify-content: center; align-items: flex-start">
    <div>
        <form method="post">
            
                    <h3>Công cụ tách văn bản</h3> 
                    <textarea name="txtChuoi" placeholder="Nhập chuỗi" rows="4" cols="50"><?php echo $chuoi ?></textarea><br>         
                    <input type="radio" name="opt" value="1" <?php if($chon == "1") echo 'checked' ?>> Tách chuỗi theo ký tự ngăn cách<br><br>
                    <div  style="display: flex; align-items: center; gap: 10px; ">
                        <br> <lable> Nhập ký tự ngăn cách </lable> 
                        <textarea name="txtkytu" rows="1"><?php echo $kytu ?></textarea><br>
                      
                    </div>
                    <label style="color: gray; font-style: italic; margin-left: 160px;">Ví dụ: ....</label>
                    <br><input type="radio" name="opt" value="2" <?php if($chon == "2") echo 'checked' ?>> Loại bỏ các ký tự vô nghĩa<br>

                    <br><input type="submit" name="btn" value="Xử lý"><br>

                    <br><textarea name="txtketqua" rows="8" cols="50" readonly ><?php echo $ketqua ?></textarea>
                    
        </form>


    </div>
    
</body>
</html>