<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    $mail->CharSet = 'UTF-8';
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();
    $mail->Mailer = "smtp";                                    //Send using SMTP
    $mail->Host = 'smtp.yandex.ru';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'info@weisstechsoft.de';                     //SMTP username
    $mail->Password = 'tmoxfbdxbsrgunwu';                               //SMTP password
    $mail->SMTPSecure = 'ssl';                                   //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    //Recipients
    $mail->setFrom('info@weisstechsoft.de', 'Mailer');
    $mail->addAddress('novak4803@gmail.com', 'User');     //Add a recipient

    $name = $phone = $email = $country = $message = "";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);
        $country = test_input($_POST["country"]);
        $message = test_input($_POST["message"]);
    }




    $body = '<h1>Contact Form  WeissTech:</h1>';

    if (!empty($name)) {
        $body .= '<p><strong>Full name: </strong>' . $name . '</p>';
    }
    if (!empty($phone)) {
        $body .= '<p><strong>Phone number: </strong>' . $phone . '</p>';
    }
    if (!empty($email)) {
        $body .= '<p><strong>Email: </strong>' . $email . '</p>';
    }
    if (!empty($country)) {
        $body .= '<p><strong>Country: </strong>' . $country . '</p>';
    }
    if (!empty($message)) {
        $body .= '<p><strong>Message: </strong>' . $message . '</p>';
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Contact Form  WeissTech';
    $mail->Body = $body;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    $message = 'Message has been sent';
} catch (Exception $e) {
    $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>
