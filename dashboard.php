<?php 
session_start();

$page_title = "Dashboard";
include('includes/header.php'); 
include('includes/navbar.php'); 

// Verbindung zur Datenbank herstellen
include('dbcon.php');

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
    echo "<table class='table table-bordered'>";
    echo "<tr><th>Last Name</th><th>First Name</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['nachname']."</td>";
        echo "<td>".$row['vorname']."</td>";
        echo "<td><button onclick='showProfileDetails(".$row['id'].")'>Show Profile</button></td>";
        echo "</tr>";
        echo "<tr id='profileDetails_".$row['id']."' style='display: none;'><td colspan='2'>";
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
    echo "</table>";
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
