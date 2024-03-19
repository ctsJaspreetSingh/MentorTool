


<?php 
session_start(); // session_start() zuerst aufrufen
$page_title = "Mentor Dashboard";
include('includes/header.php'); 
include('includes/navbar.php'); 
include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to view your Mentor Dashboard.";
    header("Location: login.php");
    exit();
}

// Benutzer-ID aus der Session erhalten
$user_id = $_SESSION['auth_user']['id'];

$user_type_query = "SELECT user_type FROM users WHERE id = $user_id";
$user_type_result = mysqli_query($con, $user_type_query);

// Überprüfen, ob die Abfrage erfolgreich war
if ($user_type_result && mysqli_num_rows($user_type_result) > 0) {
    $user_type_row = mysqli_fetch_assoc($user_type_result);
    $_SESSION['user_type'] = $user_type_row['user_type']; // Benutzertyp in der Session speichern
}else {
    // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
    echo "Error: " . mysqli_error($con);
}

// SQL-Abfrage, um den Inhalt von users und profile zu kombinieren und anzuzeigen
$query = "SELECT users.*, profile.*
          FROM users 
          LEFT JOIN profile ON users.id = profile.user_id
          WHERE users.user_type = 'Mentor'"; // Nur Benutzer mit user_type = 'Mentor' auswählen
$result = mysqli_query($con, $query);

// Überprüfen, ob die Abfrage erfolgreich war
if($result) {
    // Daten anzeigen
    echo '<div class="py-5">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12 text-center">';
    echo "<h2>Verfügbare Mentors</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Last Name</th><th>First Name</th><th>Actions</th></tr></thead><tbody>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['nachname']."</td>";
        echo "<td>".$row['vorname']."</td>";
        echo "<td>";
        echo "<button class='btn btn-primary' onclick='showProfileDetails(".$row['id'].")'>Show Profile</button>";
        echo "<button class='btn btn-success' onclick='sendRequest(".$row['id'].")'>Send Request</button>";
        echo "</td>";
        echo "</tr>";
        echo "<tr id='profileDetails_".$row['id']."' style='display: none;'><td colspan='3'>";
        echo "<h3>Profile Details</h3>";
        echo "<p><b>Job Title:</b> ".$row['job_title']."</p>";
        echo "<p><b>Skillset:</b> ".$row['skillset']."</p>";
        echo "<p><b>Specialty:</b> ".$row['specialty']."</p>";
        echo "<p><b>Interests:</b> ".$row['interests']."</p>";
        echo "<p><b>Comment:</b> ".$row['comment']."</p>";
        echo "<p><b>Profile Picture:</b> ".$row['profile_picture']."</p>";
        echo "<p><b>Max Mentee:</b> ".$row['max_mentee']."</p>";
        echo "<p><b>Is Mentor:</b> ".$row['is_mentor']."</p>";
        echo "</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>"; // table-responsive
    echo '</div>'; // col-md-12
    echo '</div>'; // row
    echo '</div>'; // container
    echo '</div>'; // py-5
} else {
    // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
    echo "Error: " . mysqli_error($con);
}

// Verbindung zur Datenbank schließen
mysqli_close($con);
?>

<!-- Ihr restlicher HTML-Code hier -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="dashboard.js"></script>
<script>
function sendRequest(mentorId) {
    $.ajax({
        type: "POST",
        url: "send_request_email.php", // Datei für das Senden der E-Mail-Anfrage an den Mentor
        data: { mentor_id: mentorId },
        success: function(response) {
            alert(response); // Zeigt die Antwort der Serverseite an
        }
    });
}
</script>
