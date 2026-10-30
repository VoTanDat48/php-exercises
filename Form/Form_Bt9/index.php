<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Trang chủ</title>
<style>
    body { font-family: Arial; margin: 0; padding: 20px; display: flex; justify-content: center; }
    .wrapper { width: 600px; border: 1px solid #ccc; padding: 20px; }
    .menu { background: #f1f1f1; padding: 10px; margin-bottom: 20px; text-align: center; }
    .menu a { margin: 0 10px; text-decoration: none; color: blue; font-weight: bold; }
    .menu a:hover { text-decoration: underline; }
    .content { padding: 15px; border: 1px dashed #ccc; min-height: 80px; }
</style>
</head>
<body>
<div class="wrapper">
    <h2>WEBSITE CỦA TÔI</h2>
    <div class="menu">
        <a href="index.php?page=trangchu">Trang chủ</a> |
        <a href="index.php?page=gioithieu">Giới thiệu</a> |
        <a href="index.php?page=tintuc">Tin tức</a> |
        <a href="index.php?page=lienhe">Liên hệ</a> |
        <a href="index.php?page=diendan">Diễn đàn</a>
    </div>
    <div class="content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'trangchu';
        
        switch ($page) {
            case 'trangchu':
                include('trangchu.php');
                break;
            case 'gioithieu':
                include('gioithieu.php');
                break;
            case 'tintuc':
                include('tintuc.php');
                break;
            case 'lienhe':
                include('lienhe.php');
                break;
            case 'diendan':
                include('diendan.php');
                break;
            default:
                include('trangchu.php');
                break;
        }
        ?>
    </div>
</div>

</body>
</html>