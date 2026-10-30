<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bảng cửu chương từ 1 đến 10</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        td { border: 1px solid #ccc; padding: 10px; vertical-align: top; }
    </style>
</head>
<body>
    <h2 align="center">BẢNG CỬU CHƯƠNG TỪ 1 ĐẾN 10</h2>
    <table>
        <tr>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "<td>";
            echo "<b>Bảng $i</b><br>";
            for ($j = 1; $j <= 10; $j++) {
                $tich = $i * $j;
                echo "$i x $j = $tich<br>";
            }
            
            echo "</td>";
        }
        ?>
        </tr>
    </table>
</body>
</html>