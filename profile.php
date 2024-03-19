<?php
session_start();
$page_title = "Profile Dashboard";
include('includes/header.php'); 
include('includes/navbar.php'); 
include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to view your profile.";
    header("Location: login.php");
    exit();
}

// Benutzer-ID aus der Session erhalten
$user_id = $_SESSION['auth_user']['id'];

// SQL-Abfrage zum Abrufen der Profildaten
$query = "SELECT * FROM profile WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    // Profildaten vorhanden
    $profile_data = mysqli_fetch_assoc($result);
    // Profildaten in Variablen speichern
    $job_title = $profile_data['job_title'];
    $skillset = $profile_data['skillset'];
    $specialty = $profile_data['specialty'];
    $interests = $profile_data['interests'];
    $comment = $profile_data['comment'];
    $max_mentee = $profile_data['max_mentee'];
    $is_mentor = $profile_data['is_mentor'];
} else {
    // Profildaten nicht gefunden
    $_SESSION['status'] = "Profile not found.";
    header("Location: create_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Profile</h2>
        <p><strong>Job Title:</strong> <?php echo $job_title; ?></p>
        <p><strong>Skillset:</strong> <?php echo $skillset; ?></p>
        <p><strong>Specialty:</strong> <?php echo $specialty; ?></p>
        <p><strong>Interests:</strong> <?php echo $interests; ?></p>
        <p><strong>Comment:</strong> <?php echo $comment; ?></p>
        <p><strong>Max Mentee:</strong> <?php echo $max_mentee; ?></p>
        <p><strong>Mentor:</strong> <?php echo $is_mentor ? 'Yes' : 'No'; ?></p>

        <!-- Button zum Bearbeiten des Profils -->
        <form action="edit_profile.php" method="GET">
            <button type="submit" class="btn btn-primary">Edit Profile</button>
        </form>
    </div>
</body>
</html>
