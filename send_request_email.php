<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_POST['mentor_id']) && isset($_POST['mentee_id']) && isset($_POST['mentor_email'])) {
    // Hier den Code einfügen, um die E-Mail-Anfrage an den Mentor zu senden
    $mentorId = $_POST['mentor_id'];
    $menteeId = $_POST['mentee_id']; // Hinzufügen der menteeId
    $mentorEmail = $_POST['mentor_email']; // Abrufen der Mentor-E-Mail-Adresse

    // Code für das Senden der E-Mail an den Mentor unter Verwendung von PHPMailer
    $subject = "Anfrage von einem Mentee"; // Betreff der E-Mail
    $message = "Hallo,\n\nEine Anfrage von einem Mentee wurde gesendet. \n\n Unter dem folgenden Link können Sie Ihre Anfrage anschauen. \n\n http://localhost/MentorToolK/mentor_request.php"; // Nachricht der E-Mail

    $mail = new PHPMailer(true);

    try {
        // SMTP-Einstellungen setzen
        $mail->isSMTP();  
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'mentortoolsingh@gmail.com';
        $mail->Password = 'nnhd xrhz iowc mgnr';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        // Empfänger und Betreff festlegen
        $mail->setFrom('mentortoolsingh@gmail.com', 'Jaspreet Singh');
        $mail->addAddress($mentorEmail);
        $mail->Subject = $subject;

        // E-Mail-Nachricht festlegen
        $mail->Body = $message;

        // E-Mail senden
        $mail->send();

        // Speichern der Anfrage in der Datenbanktabelle 'requests'
        include('dbcon.php');
        $query = "INSERT INTO requests (mentorId, menteeId, status) VALUES ($mentorId, $menteeId, 'pending')";
        $result = mysqli_query($con, $query);
        if($result) {
            echo "Anfrage erfolgreich gesendet und in der Datenbank gespeichert.";
        } else {
            echo "Anfrage erfolgreich gesendet, aber ein Fehler ist beim Speichern in der Datenbank aufgetreten.";
        }
        mysqli_close($con);

    } catch (Exception $e) {
        echo "E-Mail konnte nicht gesendet werden. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Fehler: Mentor-ID, Mentee-ID oder Mentor-E-Mail nicht gefunden.";
}
?>
