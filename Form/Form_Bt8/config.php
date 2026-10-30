<?php
$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$study = isset($_POST['study']) ? implode(", ", $_POST['study']) : '';
$note = isset($_POST['note']) ? $_POST['note'] : '';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Config</title>
<style>
    body { font-family: Arial; margin: 30px; }
    .content { line-height: 1.8; }
    .back { margin-top: 15px; display: inline-block; color: purple; font-style: italic; text-decoration: underline; cursor: pointer; }
</style>
</head>
<body>

<div class="content">
    <p>Bạn đã nhập thành công, dưới đây là những thông tin bạn đã nhập:</p>
    <p>Họ tên: <?php echo htmlspecialchars($fullname); ?></p>
    <p>Address: <?php echo htmlspecialchars($address); ?></p>
    <p>Phone: <?php echo htmlspecialchars($phone); ?></p>
    <p>Gender: <?php echo htmlspecialchars($gender); ?></p>
    <p>Country: <?php echo htmlspecialchars($country); ?></p>
    <p>Study: <?php echo htmlspecialchars($study); ?></p>
    <p>Note: <?php echo nl2br(htmlspecialchars($note)); ?></p>
    
    <a class="back" onclick="window.history.back();">Quay về</a>
</div>

</body>
</html>