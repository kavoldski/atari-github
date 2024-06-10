<?php
session_start();
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
include 'db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$order_id = $_POST['order_id'];
$amount = $_POST['amount'];

// Fetch user details
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email);
$stmt->fetch();
$stmt->close();

// Create HTML receipt
$receiptContent = "
    <h1>Payment Receipt</h1>
    <p>Order ID: {$order_id}</p>
    <p>Name: {$firstName} {$lastName}</p>
    <p>Email: {$email}</p>
    <p>Amount: \${$amount}</p>
";

// Display receipt on-screen
echo $receiptContent;

// Send Email
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.example.com';
$mail->SMTPAuth = true;
$mail->Username = 'your_email@example.com';
$mail->Password = 'your_password';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('your_email@example.com', 'Atari Electronic Store');
$mail->addAddress($email);
$mail->isHTML(true);
$mail->Subject = 'Your Payment Receipt';
$mail->Body    = $receiptContent;

if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo '<p>Receipt has been sent to your email.</p>';
}

$conn->close();
?>
