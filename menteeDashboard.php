<?php 
session_start();
$page_title = "Mentee Dashboard";
include('includes/header.php'); 
include('includes/navbar_mentee.php'); 
include('dbcon.php');

if (!isset($_SESSION['auth_user'])) {
    echo '  <script>
                window.alert("Sie haben keinen Zugriff auf das Mentor Dashboard");
                window.location.href = "login.php"; // Weiterleitung zur Login-Seite
            </script>';
    exit();
}
if ($_SESSION['auth_user']['user_type'] == 'Mentor') {
    echo '  <script>
                window.alert("Mentoren haben keinen Zugriff auf das Mentee Dashboard");
                window.location.href = "login.php"; 
            </script>';
    exit();
}

// Benutzer-ID des eingeloggten Benutzers abrufen
$loggedInUserId= $_SESSION['auth_user']['id'];

// SQL-Abfrage, um die Daten des eingeloggten Benutzers abzurufen
$query = "SELECT * FROM users WHERE id = $loggedInUserId";
$result = mysqli_query($con, $query);

// Überprüfen, ob die Abfrage erfolgreich war
if($result && mysqli_num_rows($result) > 0) {
    // Benutzerdaten abrufen
    $userData = mysqli_fetch_assoc($result);
    // "Hallo Vorname Nachname" anzeigen
    echo "<div class='container mt-4 text-center'>";
    echo "<h2 class='mb-4'>Hallo {$userData['vorname']} {$userData['nachname']}</h2>";
    echo "</div>";
    
    // menteeId der aktuellen Sitzung zuweisen
    $menteeId = $userData['id'];
} else {
    // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger' role='alert'>";
    echo "Error: User data not found.";
    echo "</div>";
    echo "</div>";
    exit(); // Beende das Skript, wenn die Benutzerdaten nicht gefunden werden können
} 
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Verfügbare Mentoren</h2>
    <!-- Filterformular -->
    <form method="GET" action="">
        <div class="form-group">
            <label for="filter">Filtern nach Skill:</label>
            <select class="form-control" id="filter" name="filter">
                <option value="">Alle Skills</option>
                <?php
                $query = "SELECT DISTINCT skillset FROM profile WHERE skillset != ''";
                $result = mysqli_query($con, $query);
                if($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['skillset']."'>".$row['skillset']."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtern</button>
    </form>
</div>

<?php
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
// Restlicher Code hier ...

// SQL-Abfrage, um den Inhalt von users und profile zu kombinieren und anzuzeigen
$query = "SELECT users.*, profile.*
          FROM users 
          LEFT JOIN profile ON users.id = profile.user_id
          WHERE users.user_type = 'Mentor' AND users.id != $loggedInUserId"; // Nur Benutzer mit user_type = 'Mentor' auswählen und den eingeloggten Benutzer ausschließen

if (!empty($filter)) {
    $filter = mysqli_real_escape_string($con, $filter);
    $query .= " AND profile.skillset = '$filter'";
}

$result = mysqli_query($con, $query);

// Überprüfen, ob die Abfrage erfolgreich war
if($result) {
    // Daten anzeigen
    echo "<div class='container mt-4'>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Nachname</th><th>Vorname</th><th>Email</th><th>Aktionen</th></tr></thead><tbody>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['nachname']."</td>";
        echo "<td>".$row['vorname']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td class='text-center'>";
        echo "<div class='btn-group' role='group'>";
        echo "<button class='btn btn-primary btn-rounded mr-2' onclick='showProfileDetails(".$row['id'].")'>Show Profile</button>";
        echo "<button class='btn btn-success btn-rounded' onclick='sendRequest(".$row['id'].", ".$menteeId.", \"".$row['email']."\")'>Send Request</button>"; // Übergeben Sie mentorId, menteeId und Mentor-E-Mail
        echo "</div>";
        echo "</td>";
        echo "</tr>";
        echo "<tr id='profileDetails_".$row['id']."' style='display: none;'><td colspan='4'>";
        echo "<h3>Profil Details</h3>";
        echo "<p><b>Job Titel:</b> ".$row['job_title']."</p>";
        echo "<p><b>Skillset:</b> ".$row['skillset']."</p>";
        echo "<p><b>Spezialität:</b> ".$row['specialty']."</p>";
        echo "<p><b>Interessen:</b> ".$row['interests']."</p>";
        echo "<p><b>Kommentar:</b> ".$row['comment']."</p>";
       // echo "<p><b></b> ".$row['profile_picture']."</p>";
        echo "<p><b>Max Mentee:</b> ".$row['max_mentee']."</p>";
        //echo "<p><b>Is Mentor:</b> ".$row['is_mentor']."</p>";
        echo "</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>"; // table-responsive
    echo "</div>"; // container
} else {
    // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger' role='alert'>";
    echo "Error: " . mysqli_error($con);
    echo "</div>";
    echo "</div>";
}

// Verbindung zur Datenbank schließen
mysqli_close($con);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="dashboard.js"></script>
<script>
function sendRequest(mentorId, menteeId, mentorEmail) { // Fügen Sie die menteeId und die Mentor-E-Mail als Parameter hinzu
    $.ajax({
        type: "POST",
        url: "send_request_email.php",
        data: { mentor_id: mentorId, mentee_id: menteeId, mentor_email: mentorEmail }, // Übergeben Sie mentorId, menteeId und Mentor-E-Mail
        success: function(response) {
            alert(response);
        }
    });
}
</script>
