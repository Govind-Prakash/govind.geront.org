<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../vendor/PHPMailer/src/Exception.php';
  require '../vendor/PHPMailer/src/PHPMailer.php';
  require '../vendor/PHPMailer/src/SMTP.php';

  $receiving_email_address = 'govind7x@gmail.com';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_name = htmlspecialchars($_POST['name']);
    $from_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if ($from_email && $from_name && $subject && $message) {
      $mail = new PHPMailer(true);

      try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Your email address
        $mail->Password = 'your-email-password'; // Your email password (or app password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($receiving_email_address);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = nl2br($message);

        $mail->send();
        echo "Your message has been sent successfully.";
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    } else {
      echo "Please fill in all required fields.";
    }
  } else {
    echo "Invalid request.";
  }
?>
