<?php 
session_start();

$page_title = "Mentor Dashboard";
include('includes/header.php'); 
include('includes/navbar.php'); 

// Verbindung zur Datenbank herstellen
include('dbcon.php');

// SQL-Abfrage, um den Inhalt von users und profile zu kombinieren und anzuzeigen
$query = "SELECT users.*, profile.*
          FROM users 
          LEFT JOIN profile ON users.id = profile.user_id";
$result = mysqli_query($con, $query);

// Überprüfen, ob die Abfrage erfolgreich war
if($result) {
    // Daten anzeigen
    echo '<div class="py-5">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12 text-center">';
    echo "<h2>All Users and Profiles</h2>";
    echo "<table class='table table-bordered'>";
    echo "<tr><th>Last Name</th><th>First Name</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['nachname']."</td>";
        echo "<td>".$row['vorname']."</td>";
        echo "<td><button onclick='showProfileDetails(".$row['id'].")'>Show Profile</button></td>";
        echo "</tr>";
        echo "<tr id='profileDetails_".$row['id']."' style='display: none;'><td colspan='2'>".$row['job_title']."<br>".$row['skillset']."<br>".$row['specialty']."<br>".$row['interests']."<br>".$row['comment']."<br>".$row['profile_picture']."<br>".$row['max_mentee']."<br>".$row['is_mentor']."</td></tr>";
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
