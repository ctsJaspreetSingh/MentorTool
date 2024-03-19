<?php
session_start();
include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to edit your profile.";
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

// Überprüfen, ob das Formular gesendet wurde
if (isset($_POST['update_profile_btn'])) {
    // Daten aus dem Formular erhalten
    $job_title = $_POST['job_title'];
    $skillset = $_POST['skillset'];
    $specialty = $_POST['specialty'];
    $interests = $_POST['interests'];
    $comment = $_POST['comment'];
    $max_mentee = $_POST['max_mentee'];
    $is_mentor = isset($_POST['is_mentor']) ? 1 : 0; // Konvertiere den Wert des Mentor-Flags in 1 oder 0

    // SQL-Abfrage zum Aktualisieren der Profildaten in der Datenbank
    $update_query = "UPDATE profile SET job_title='$job_title', skillset='$skillset', specialty='$specialty', interests='$interests', comment='$comment', max_mentee='$max_mentee', is_mentor='$is_mentor' WHERE user_id='$user_id'";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        $_SESSION['status'] = "Profile updated successfully.";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to update profile.";
        header("Location: edit_profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Your Profile</h2>
        <form action="edit_profile.php" method="POST">
            <div class="form-group">
                <label for="job_title">Job Title</label>
                <input type="text" name="job_title" class="form-control" value="<?php echo $job_title; ?>" required>
            </div>
            <div class="form-group">
                <label for="skillset">Skillset</label>
                <input type="text" name="skillset" class="form-control" value="<?php echo $skillset; ?>" required>
            </div>
            <div class="form-group">
                <label for="specialty">Specialty</label>
                <input type="text" name="specialty" class="form-control" value="<?php echo $specialty; ?>" required>
            </div>
            <div class="form-group">
                <label for="interests">Interests</label>
                <textarea name="interests" class="form-control" required><?php echo $interests; ?></textarea>
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea name="comment" class="form-control"><?php echo $comment; ?></textarea>
            </div>
            <div class="form-group">
                <label for="max_mentee">Max Mentee</label>
                <input type="number" name="max_mentee" class="form-control" value="<?php echo $max_mentee; ?>" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="is_mentor" class="form-check-input" id="is_mentor" <?php if ($is_mentor) echo "checked"; ?>>
                <label class="form-check-label" for="is_mentor">Mentor</label>
            </div>
            <button type="submit" name="update_profile_btn" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>
