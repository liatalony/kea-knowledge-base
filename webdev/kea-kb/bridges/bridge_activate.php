<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

// echo  $_POST['email'];
// exit();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("{$_SERVER['DOCUMENT_ROOT']}/webdev/kea-kb/PHPMailer/src/PHPMailer.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/webdev/kea-kb/PHPMailer/src/SMTP.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/webdev/kea-kb/PHPMailer/src/Exception.php");

$password = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/webdev/kea-kb/views/password.txt");

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    $q = $db->prepare('SELECT user_uuid FROM users where email = :email LIMIT 1');    
    $q->bindValue(':email', $_POST['email']);
    $q->execute();
    $user = $q->fetch();

// echo $user['user_verify_code'];
// exit();

    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'liat311.test@gmail.com';                     //SMTP username
    $mail->Password   = $password;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    //Recipients
    $mail->setFrom('liat311.test@gmail.com', 'Activate your account'); //sender
    $mail->addAddress('liat311.test@gmail.com', 'The user');     //recipient
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to KEA KNowledge Base';
    $mail->Body    = "<b>WELCOME!</b><br>Now that you have signed up, click on the link to activate your account.<br><a href='http://localhost/activate/{$user['user_uuid']}'>Activate my account Here!</a>";
    $mail->AltBody = 'You are now a new user!';

    $mail->send();
  

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
