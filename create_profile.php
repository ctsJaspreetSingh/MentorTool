<?php
session_start();
include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to create your profile.";
    header("Location: login.php");
    exit();
}

// Überprüfen, ob das Formular gesendet wurde
if (isset($_POST['create_profile_btn'])) {
    // Daten aus dem Formular erhalten
    $job_title = $_POST['job_title'];
    $skillset = $_POST['skillset'];
    $specialty = $_POST['specialty'];
    $interests = $_POST['interests'];
    $comment = $_POST['comment'];
    $max_mentee = $_POST['max_mentee'];
    $is_mentor = isset($_POST['is_mentor']) ? 1 : 0; // Konvertiere den Wert des Mentor-Flags in 1 oder 0

    // Benutzer-ID aus der Session erhalten
    $user_id = $_SESSION['auth_user']['id'];

    // SQL-Abfrage zum Einfügen der Profildaten in die Datenbank
    $query = "INSERT INTO profile (job_title, skillset, specialty, interests, comment, max_mentee, is_mentor, user_id) 
              VALUES ('$job_title', '$skillset', '$specialty', '$interests', '$comment', '$max_mentee', '$is_mentor', '$user_id')";

    // SQL-Abfrage ausführen
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // Profil erfolgreich erstellt, jetzt das Feld 'profile_created' in der 'users'-Tabelle aktualisieren
        $update_query = "UPDATE users SET profile_created = 1 WHERE id = '$user_id'";
        $update_query_run = mysqli_query($con, $update_query);
    
        if ($update_query_run) {
            $_SESSION['status'] = "Profile created successfully.";
            $_SESSION['profile_created'] = true; // Setze das Flag für das erstellte Profil
            header("Location: mentorDashboard.php"); // Weiterleitung zum Dashboard nach erfolgreicher Profilerstellung
            exit();
        } else {
            $_SESSION['status'] = "Failed to update profile status.";
            header("Location: create_profile.php"); // Weiterleitung zur Profilerstellungsseite im Falle eines Fehlers
            exit();
        }
    }
    
}
?>

<!-- HTML-Formular für die Profilerstellung -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <h2>Create Your Profile</h2>
        <form action="create_profile.php" method="POST">
            <div class="form-group">
                <label for="job_title">Job Title</label>
                <input type="text" name="job_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="skillset">Skillset</label>
                <input type="text" name="skillset" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="specialty">Specialty</label>
                <input type="text" name="specialty" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="interests">Interests</label>
                <textarea name="interests" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea name="comment" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="max_mentee">Max Mentee</label>
                <input type="number" name="max_mentee" class="form-control" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="is_mentor" class="form-check-input" id="is_mentor">
                <label class="form-check-label" for="is_mentor">Mentor</label>
            </div>
            <button type="submit" name="create_profile_btn" class="btn btn-primary">Create Profile</button>
        </form>
    </div>
</body>
</html>
