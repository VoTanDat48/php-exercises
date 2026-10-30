<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Xử lý mảng ngẫu nhiên</title>
<style>
    body { font-family: Arial; margin: 30px; line-height: 1.6; }
    .form-group { margin: 10px 0; }
    input[type="text"] { padding: 4px; width: 200px; }
    input[type="submit"] { padding: 4px 15px; cursor: pointer; }
    .error { color: red; font-weight: bold; }
    .result { margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; }
</style>
</head>
<body>

<form method="POST" action="">
    <div class="form-group">
        <label>Nhập n: </label>
        <input type="text" name="n" value="<?php echo isset($_POST['n']) ? htmlspecialchars($_POST['n']) : ''; ?>" required>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Thực hiện">
    </div>
</form>

<?php
if (isset($_POST['submit'])) {
    $n = $_POST['n'];

    if (!filter_var($n, FILTER_VALIDATE_INT) || intval($n) <= 0) {
        echo '<div class="result error">Dữ liệu không hợp lệ! Yêu cầu n phải là số nguyên dương.</div>';
    } else {
        $n = intval($n);
        $mang = array();
        
        for ($i = 0; $i < $n; $i++) {
            $mang[] = rand(-50, 150);
        }
        $mang_goc = $mang;

        $so_chan = 0;
        $nho_hon_100 = 0;
        $tong_am = 0;
        $vi_tri_0 = array();

        foreach ($mang as $key => $val) {
            if ($val % 2 == 0) {
                $so_chan++;
            }
            if ($val < 100) {
                $nho_hon_100++;
            }
            if ($val < 0) {
                $tong_am += $val;
            }
            if ($val == 0) {
                $vi_tri_0[] = $key;
            }
        }

        sort($mang);
        ?>

        <div class="result">
            <h3>KẾT QUẢ XỬ LÝ (n = <?php echo $n; ?>)</h3>
            <p><b>Mảng phát sinh ngẫu nhiên:</b> <?php echo implode(", ", $mang_goc); ?></p>
            <p><b>Số lượng phần tử chẵn:</b> <?php echo $so_chan; ?></p>
            <p><b>Số lượng phần tử nhỏ hơn 100:</b> <?php echo $nho_hon_100; ?></p>
            <p><b>Tổng các phần tử mang giá trị âm:</b> <?php echo $tong_am; ?></p>
            <p><b>Vị trí các phần tử có giá trị bằng 0:</b> 
                <?php 
                if (empty($vi_tri_0)) {
                    echo "Không có phần tử nào bằng 0";
                } else {
                    echo implode(", ", $vi_tri_0);
                }
                ?>
            </p>
            <p><b>Mảng sau khi sắp xếp tăng dần:</b> <?php echo implode(", ", $mang); ?></p>
        </div>

        <?php
    }
}
?>

</body>
</html>