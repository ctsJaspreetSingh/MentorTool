<?php 
session_start();
$page_title = "Mentor Dashboard";
include('includes/header.php'); 
include('includes/navbar_mentor.php'); 
include('dbcon.php');

if (!isset($_SESSION['auth_user'])) {
    echo '  <script>
                window.alert("Sie haben keinen Zugriff auf das Mentor Dashboard");
                window.location.href = "login.php"; // Weiterleitung zur Login-Seite
            </script>';
    exit();
}


if ($_SESSION['auth_user']['user_type'] == 'Mentee') {
        echo '  <script>
                    window.alert("Mentees haben keinen Zugriff auf das Mentor Dashboard");
                    window.location.href = "login.php"; 
                </script>';
        exit();
    }

$loggedInUserId = $_SESSION['auth_user']['id'];

$query = "SELECT * FROM users WHERE id = $loggedInUserId";
$result = mysqli_query($con, $query);

if($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
    echo "<div class='container mt-4 text-center'>";
    echo "<h2 class='mb-4'>Hallo {$userData['vorname']} {$userData['nachname']}</h2>";
    echo "</div>";
    $menteeId = $userData['id'];
} else {
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger' role='alert'>";
    echo "Error: User data not found.";
    echo "</div>";
    echo "</div>";
    exit();
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

$query = "SELECT users.*, profile.*
          FROM users 
          LEFT JOIN profile ON users.id = profile.user_id
          WHERE users.user_type = 'Mentor' AND users.id != $loggedInUserId";

if (!empty($filter)) {
    $filter = mysqli_real_escape_string($con, $filter);
    $query .= " AND profile.skillset = '$filter'";
}

$result = mysqli_query($con, $query);

if($result) {
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
        echo "<button class='btn btn-primary btn-rounded mr-2' onclick='showProfileDetails(".$row['id'].")'>Profil anzeigen</button>";
        echo "<button class='btn btn-success btn-rounded' onclick='sendRequest(".$row['id'].", ".$menteeId.", \"".$row['email']."\")'>Anfrage senden</button>";
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
        echo "<p><b>Max Mentee:</b> ".$row['max_mentee']."</p>";
        echo "</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>"; // table-responsive
    echo "</div>"; // container
} else {
    echo "<div class='container mt-4'>";
    echo "<div class='alert alert-danger' role='alert'>";
    echo "Error: " . mysqli_error($con);
    echo "</div>";
    echo "</div>";
}

mysqli_close($con);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="dashboard.js"></script>
<script>
function sendRequest(mentorId, menteeId, mentorEmail) {
    $.ajax({
        type: "POST",
        url: "send_request_email.php",
        data: { mentor_id: mentorId, mentee_id: menteeId, mentor_email: mentorEmail },
        success: function(response) {
            alert(response);
        }
    });
}
</script>
