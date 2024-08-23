<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    $mail = new PHPMailer(true); // Create a new PHPMailer instance
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server address
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = getenv('SMTP_USERNAME'); // SMTP username from environment variable
        $mail->Password   = getenv('SMTP_PASSWORD'); // SMTP password from environment variable
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `ssl` also accepted
        $mail->Port       = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('contact.furnijourney@gmail.com', 'FurniJourney Support'); // Sender's email address and name
        $mail->addAddress($email); // Recipient's email address

        //Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'Contact Us Form Submission';
        $mail->Body    = "Thank you for reaching out to FurniJourney's Support & Contact Desk. We shall get back to you at the earliest.";

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        error_log($mail->ErrorInfo, 3, '/var/log/phpmailer_errors.log'); // Log error to a file
        echo "Failed to send email. Please try again later.";
    }
}
?>
