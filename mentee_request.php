<?php
session_start();
$page_title = "Gesendete Anfragen";
include('includes/header.php');
include('includes/navbar_mentee.php');
include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to view data.";
    header("Location: login.php");
    exit();
}

// Benutzer-ID aus der Session erhalten
$user_id = $_SESSION['auth_user']['id'];

echo '<div class="py-5">';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-md-12 text-center">';
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<thead><tr><th>Vorname</th><th>Nachname</th><th>Status</th><th>Erstellt am</th><th>Aktion</th></tr></thead><tbody>";

$sql_endlich = "SELECT u.email, u.vorname, u.nachname, p.user_id, r.id AS request_id, r.status, r.created_at FROM users u INNER JOIN profile p ON u.id = p.user_id INNER JOIN requests r ON p.id = r.mentorId WHERE r.menteeId = '$user_id'";
$result_endlich = mysqli_query($con, $sql_endlich);

if ($result_endlich && mysqli_num_rows($result_endlich) > 0) {
    while ($row_endlich = mysqli_fetch_assoc($result_endlich)) {
        echo "<tr>";
        echo "<td>".$row_endlich['vorname']."</td>";
        echo "<td>".$row_endlich['nachname']."</td>";
        echo "<td>".$row_endlich['status']."</td>";
        echo "<td>".$row_endlich['created_at']."</td>";
        // Button zum Löschen der Anfrage
        echo "<td><form method='post' action='delete_request.php'><input type='hidden' name='request_id' value='".$row_endlich['request_id']."'><button type='submit' class='btn btn-danger'>Anfrage zurücknehmen</button></form></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Noch keine Anfragen gesendet</td></tr>";
}
echo "</tbody></table>";
echo "</div>"; // table-responsive
echo '</div>'; // col-md-12
echo '</div>'; // row
echo '</div>'; // container
echo '</div>'; // py-5

// Schließen der Verbindung zur Datenbank
mysqli_close($con);
?>
