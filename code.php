<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($nachname, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();  
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'eventplannersingh08@gmail.com';
        $mail->Password = 'hkhr jbgj ocqk oqaf';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom('eventplannersingh08@gmail.com', $nachname);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification from Jaspreet Singh';

        $email_template = "
        <h2>You have registered with Mentor Tool</h2>
        <h5>Verify your email address to log in to the system</h5>
        <br/><br/>
        <a href='http://localhost/MentorTool/verify-email.php?token=$verify_token'> Click me </a>
        ";

        $mail->Body = $email_template;
        $mail->send();
        
        echo "E-Mail wurde erfolgreich gesendet.";
    } catch (Exception $e) {
        echo "E-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}";
    }
}

if(isset($_POST['register_btn']))
{
    $nachname = $_POST['nachname'];
    $vorname = $_POST['vorname'];
    $ctsID = $_POST['ctsID'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());
    $user_type = $_POST['user_type']; // Die Benutzerrolle wird hier einmal erfasst

    // Regex-Muster für Cognizant-E-Mail-Domäne
    $pattern = '/@cognizant\.com$/i';

    // Überprüfen, ob die E-Mail-Adresse zur Cognizant-Domäne gehört
    if (!preg_match($pattern, $email)) {
        $_SESSION['status'] =  "Die E-Mail-Adresse muss zu Cognizant gehören.";
        header("Location: register.php");
        exit;
    }

    // Überprüfen, ob die E-Mail bereits existiert
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0)
    {
        $_SESSION['status'] =  "Email Id already Exists";
        header("Location: register.php");
        exit;
    }
    else
    {
        $query = "INSERT INTO users (nachname, vorname, ctsID, email, password, verify_token, user_type) 
                  VALUES ('$nachname', '$vorname', '$ctsID', '$email', '$password', '$verify_token', '$user_type')";

        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            sendemail_verify("$nachname", "$email", "$verify_token");
            $_SESSION['status'] =  "Registration Successful. Please Verify your Email";
            header("Location: register.php");
            exit;
        }
        else
        {
            $_SESSION['status'] =  "Registration Failed";
            header("Location: register.php");
            exit;
        }
    }
}
?>
