<?php
require_once('tcpdf/tcpdf.php');
include 'db_connect.php';

$order_id = $_POST['order_id'];

$stmt = $conn->prepare("SELECT u.first_name, u.last_name, u.email, o.product_name, o.order_date 
                        FROM users u JOIN orders o ON u.id = o.user_id 
                        WHERE o.order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $productName, $orderDate);
$stmt->fetch();
$stmt->close();
$conn->close();

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$html = "
    <h1>Payment Receipt</h1>
    <p>Order ID: {$order_id}</p>
    <p>Name: {$firstName} {$lastName}</p>
    <p>Email: {$email}</p>
    <p>Product: {$productName}</p>
    <p>Order Date: {$orderDate}</p>
";
$pdf->writeHTML($html, true, false, true, false, '');
$pdfFile = "receipt_{$order_id}.pdf";
$pdf->Output($pdfFile, 'F');

// Send Email
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.example.com';
$mail->SMTPAuth = true;
$mail->Username = 'your_email@example.com';
$mail->Password = 'your_password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('your_email@example.com', 'Atari Electronic Store');
$mail->addAddress($email);
$mail->addAttachment($pdfFile);
$mail->isHTML(true);
$mail->Subject = 'Your Payment Receipt';
$mail->Body    = 'Please find attached your payment receipt.';

if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Receipt has been sent to your email.';
}

unlink($pdfFile); // Delete the file after sending the email
?>
