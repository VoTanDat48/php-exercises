<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>In số chẵn từ 1 đến N</title>
</head>
<body>
    <h3>Các số chẵn từ 1 đến N:</h3>
    <?php
    $n = rand(1, 100);
    echo "Số N ngẫu nhiên là: <b>$n</b><br>";
    echo "Các số chẵn trong khoảng từ 1 đến $n là: ";

    for ($i = 1; $i <= $n; $i++) {
        if ($i % 2 == 0) {
            echo "$i ";
        }
    }
    ?>
</body>
</html>