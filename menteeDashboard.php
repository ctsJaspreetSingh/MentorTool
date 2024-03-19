


<?php 
session_start();
$page_title = "Mentee Dashboard";
include('includes/header.php'); 
include('includes/navbar.php'); 
include('dbcon.php');



if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to view your Mentee Dashboard.";
    header("Location: login.php");
    exit();
}

// Benutzer-ID des eingeloggten Benutzers abrufen
$loggedInUserId= $_SESSION['auth_user']['id'];

// SQL-Abfrage, um die Daten des eingeloggten Benutzers abzurufen
$query = "SELECT * FROM users WHERE id = $loggedInUserId";
$result = mysqli_query($con, $query);

// Überprüfen, ob die Abfrage erfolgreich war
if($result) {
    // Daten anzeigen
    echo '<div class="py-5">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12 text-center">';
    echo "<h2>Angemeldeter Benutzer</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>ID</th><th>Last Name</th><th>First Name</th><th>ctsID</th><th>Email</th><th>User Type</th><th>Verify Status</th><th>Created At</th><th>Profile Created</th></tr></thead><tbody>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['nachname']."</td>";
        echo "<td>".$row['vorname']."</td>";
        echo "<td>".$row['ctsID']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['user_type']."</td>";
        echo "<td>".$row['verify_status']."</td>";
        echo "<td>".$row['created_at']."</td>";
        echo "<td>".$row['profile_created']."</td>";
        echo "</tr>";
        
        // menteeId der aktuellen Sitzung zuweisen
        $menteeId = $row['id'];
   }
    echo "</tbody></table>";
    echo "</div>"; // table-responsive
    echo '</div>'; // col-md-12
    echo '</div>'; // row
    echo '</div>'; // container
    echo '</div>'; // py-5
}  else {
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
        echo "<button class='btn btn-success' onclick='sendRequest(".$row['id'].", ".$menteeId.")'>Send Request</button>"; // Übergeben Sie mentorId und menteeId
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
    echo '</div>';

} else {
    // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
    echo "Error: " . mysqli_error($con);
}

// Verbindung zur Datenbank schließen
mysqli_close($con);
?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="dashboard.js"></script>
<script>
function sendRequest(mentorId, menteeId) { // Fügen Sie die menteeId als Parameter hinzu
    $.ajax({
        type: "POST",
        url: "send_request_email.php",
        data: { mentor_id: mentorId, mentee_id: menteeId }, // Übergeben Sie mentorId und menteeId
        success: function(response) {
            alert(response);
        }
    });
}
</script>




 