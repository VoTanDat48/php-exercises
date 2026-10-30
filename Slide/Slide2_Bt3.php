<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xử lý số ngẫu nhiên N</title>
</head>
<body>
    <?php
    $n = rand(-100, 100);
    echo "<h3>Số N ngẫu nhiên được chọn là: $n</h3>";

    if ($n > 0) {
        echo "<p><b>Kết quả:</b> $n là số dương.</p>";
        echo "<b>Các ước số của $n là:</b> ";
        for ($i = 1; $i <= $n; $i++) {
            if ($n % $i == 0) {
                echo "$i ";
            }
        }
        echo "<br>";

        function laSoNguyenTo($num) {
            if ($num < 2) return false;
            for ($i = 2; $i <= sqrt($num); $i++) {
                if ($num % $i == 0) return false;
            }
            return true;
        }
        if (laSoNguyenTo($n)) {
            echo "<b>Kiểm tra số nguyên tố:</b> $n là số nguyên tố.<br>";
        } else {
            echo "<b>Kiểm tra số nguyên tố:</b> $n không phải là số nguyên tố.<br>";
        }
        $tong_nt = 0;
        for ($i = 2; $i < $n; $i++) {
            if (laSoNguyenTo($i)) {
                $tong_nt += $i;
            }
        }
        echo "<b>Tổng các số nguyên tố nhỏ hơn $n là:</b> $tong_nt<br>";
        $can_bac_hai = sqrt($n);
        if ($can_bac_hai == floor($can_bac_hai)) {
            echo "<b>Kiểm tra số chính phương:</b> $n là số chính phương.<br>";
        } else {
            echo "<b>Kiểm tra số chính phương:</b> $n không phải là số chính phương.<br>";
        }

    } else {
        echo "<p><b>Kết quả:</b> $n không phải là số dương (N <= 0), nên không thực hiện các yêu cầu tiếp theo.</p>";
    }
    ?>
</body>
</html>