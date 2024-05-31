<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require_once "vendor/autoload.php";

// Check if all required fields are set
if(isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid email address.'));
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Mailer configuration
        $mail->isSMTP();
        $mail->Host = 'in-v3.mailjet.com';
        $mail->SMTPAuth = true;
        $mail->Username = '1b8369ce9f0fdf1efa95e242621943ca'; // Replace with your Mailjet username
        $mail->Password = '4c2a03dd8facbb847c7aed87ad635f0e'; // Replace with your Mailjet password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom($email, $name);
        $mail->addAddress('majhalaeltabangay@gmail.com', 'Dan');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Dan Contact';
        $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><b>Message:</b> $message";

        // Send email
        $mail->send();
        
        // Send a JSON response
        echo json_encode(array('status' => 'success', 'message' => 'Email sent successfully.'));
    } catch (Exception $e) {
        // Send a JSON response
        echo json_encode(array('status' => 'error', 'message' => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo));
    }
} else {
    // Send a JSON response
    echo json_encode(array('status' => 'error', 'message' => 'All fields are required.'));
}
?>
