<?php
session_start();
include('dbcon.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true); // Hier wird ein neues PHPMailer-Objekt erstellt

    try {
        // SMTP-Einstellungen setzen
        $mail->isSMTP();  
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'eventplannersingh08@gmail.com';
        $mail->Password = 'hkhr jbgj ocqk oqaf';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        // Aktiviere den Debug-Modus
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

        // Weitere E-Mail-Einstellungen
        $mail->setFrom('eventplannersingh08@gmail.com', $name);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Resend Email Verification from Jaspreet Singh';

        $email_template = "
        <h2>You have registered with Mentor Tool</h2>
        <h5>Verify your email address to log in to the system</h5>
        <br/><br/>
        <a href='http://localhost/MentorTool/verify-email.php?token=$verify_token'> Click me </a>
        ";

        $mail->Body = $email_template;
        $mail->send();
        
        echo "E-Mail wurde erfolgreich gesendet."; // Optional: Bestätigungsmeldung
        } catch (Exception $e) {
        echo "E-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
        }
}


if(isset($_POST['resend_email_verify_btn']))
{
    if(!empty(trim($_POST['email'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1 ";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

        if(mysqli_num_rows($checkemail_query_run) > 0)
        {
            $row = mysqli_fetch_array($checkemail_query_run);
            if($row['verify_status'] == "0")
            {

                $name =  $row['name'];
                $email =  $row['email'];
                $verify_token =  $row['verify_token'];

                resend_email_verify($name, $email, $verify_token);
                $_SESSION['status'] = "Verification Email Link has been sent to this email";
                header("Location: login.php");
                exit(0);

            } 
            else
            {
                $_SESSION['status'] = "Email already verified. Please Login!";
                header("Location: resend-email-verification.php");
                exit(0);
            }

        }
        else
        {
            $_SESSION['status'] = "Email is not registered. Pleade Register Now!";
            header("Location: register.php");
            exit(0);

        }
    }
    else
    {
        $_SESSION['status'] = "Please enter the email field";
        header("Location: resend-email-verification.php");
        exit(0);
    }

}

?>