<?php
// Nạp tự động thông qua Composer autoload
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Cấu hình Server
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Bật chế độ debug
    $mail->isSMTP();                      // Sử dụng SMTP
    $mail->Host       = 'zosk jwtf wryn gxat';  // Máy chủ SMTP của Gmail
    $mail->SMTPAuth   = true;              // Bật xác thực SMTP
    $mail->Username   = '2.votandat4825@gmail.com'; // Tài khoản Gmail của bạn
    $mail->Password   = ''; // Mật khẩu ứng dụng của bạn
    
    // Cấu hình mã hóa và cổng
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;

    // Người gửi và người nhận
    $mail->setFrom('2.votandat4825@gmail.com', '2.votandat4825');
    $mail->addAddress('gamesnhanh@gmail.com', 'gamesnhanh');

    // Nội dung email
    $mail->isHTML(true);
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body in bold!';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>