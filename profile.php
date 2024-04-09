<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS-Stile für das Profilbild */
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        /* CSS-Stile für die Profilinformationen */
        .profile-info {
            border: 1px solid #ddd; /* Hellgrauer Rahmen */
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9; /* Hintergrundfarbe */
            margin-bottom: 20px; /* Unterer Abstand */
        }
        /* CSS-Stile für die Profilinformationen */
        .profile-info p {
            margin-bottom: 5px;
            text-align: left; /* Text linksbündig ausrichten */
        }
    </style>
</head>
<body>

<?php
session_start();
$page_title = "Profile Dashboard";
include('includes/header.php'); 

include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to view your profile.";
    header("Location: login.php");
    exit();
}
if(isset($_SESSION['status'])) : ?>
                    <div class="alert alert-success">
                        <h5><?php echo htmlspecialchars($_SESSION['status']); ?></h5>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif;

// Benutzer-ID aus der Session erhalten
$user_id = $_SESSION['auth_user']['id'];

$query = "SELECT * FROM profile WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

// SQL-Abfrage zum Abrufen der Profildaten aus der users Tabelle
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Benutzerdaten in Variablen speichern
$user_email = $user_data['email'];
$user_firstname = $user_data['vorname'];
$user_lastname = $user_data['nachname'];
$user_type = $user_data['user_type'];

$_SESSION['user_type'] = $user_type;


if ($user_type == 'Mentor') {
    include('includes/navbar_mentor.php');
} elseif ($user_type == 'Mentee') {
    include('includes/navbar_mentee.php');
} else {
    // Standard-Navigation einfügen, wenn Benutzertyp weder Mentor noch Mentee ist
    include('includes/navbar.php');
}


// SQL-Abfrage zum Abrufen der Profildaten aus der profile Tabelle
$profile_query = "SELECT * FROM profile WHERE user_id = '$user_id'";
$profile_result = mysqli_query($con, $profile_query);

if (mysqli_num_rows($profile_result) > 0) {
    // Profildaten vorhanden
    $profile_data = mysqli_fetch_assoc($profile_result);
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
   // header("Location: create_profile.php");
    exit();
}

// Profilbild-Pfad aus der users Tabelle abrufen
//$profile_picture_path = $user_data['profile_picture'];

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2>Your Profile</h2>
            <!-- Anzeige des Profilbilds als Bild -->
            <?php if (!empty($profile_picture_path)) : ?>
                <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture" class="profile-picture">
            <?php else : ?>
                <img src="default.jpeg" alt="Default Profile Picture" class="profile-picture">
            <?php endif; ?>
            <div class="profile-info">
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Email:</strong> <?php echo $user_email; ?></p>
                        <p><strong>Vornamen:</strong> <?php echo $user_firstname; ?></p>
                        <p><strong>Nachnamen:</strong> <?php echo $user_lastname; ?></p>
                        <p><strong>Benutzertyp:</strong> <?php echo $user_type; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Job Titel:</strong> <?php echo $job_title; ?></p>
                        <p><strong>Skillset:</strong> <?php echo $skillset; ?></p>
                        <p><strong>Spezialität:</strong> <?php echo $specialty; ?></p>
                        <p><strong>Interessen:</strong> <?php echo $interests; ?></p>
                        <p><strong>Kommentar:</strong> <?php echo $comment; ?></p>
                        <!-- Nur anzeigen, wenn der Benutzer ein Mentor ist -->
                        <?php if ($user_type == 'Mentor') : ?>
                            <p><strong>Max Mentee:</strong> <?php echo $max_mentee; ?></p>
                            <p><strong>Mentor:</strong> <?php echo $is_mentor ? 'Ja' : 'Nein'; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Button zum Bearbeiten des Profils -->
            <form action="edit_profile.php" method="GET">
                <button type="submit" class="btn btn-primary mt-3">Edit Profile</button>
            </form>
        </div>
    </div>
</div>


<?php if ($user_type == 'Mentor') { ?>
    <!-- Meldung anzeigen, wenn Benutzer ein Mentor ist -->
    <p><strong>Der Benutzer ist ein Mentor.</strong></p>
<?php } ?>

<?php if ($user_type == 'Mentee') { ?>
    <!-- Meldung anzeigen, wenn Benutzer ein Mentee ist -->
    <p><strong>Der Benutzer ist ein Mentee.</strong></p>
<?php } ?>

</body>
</html>
