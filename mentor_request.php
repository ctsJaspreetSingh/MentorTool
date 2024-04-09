<?php
session_start();
$page_title = "Erhaltene Anfragen";
include('includes/header.php');
include('includes/navbar_mentor.php');
include('dbcon.php');

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Bitte loggen Sie sich ein, um Ihr Profil anzusehen.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

// Funktion zum Löschen einer Anfrage
if(isset($_POST['delete_request_id'])) {
    $delete_request_id = $_POST['delete_request_id'];
    $sql_delete_request = "DELETE FROM requests WHERE id = '$delete_request_id'";
    if(mysqli_query($con, $sql_delete_request)) {
        $_SESSION['status'] = "Anfrage erfolgreich gelöscht.";
        header("Location: mentor_request.php"); // Weiterleitung zur Seite mit den erhaltenen Anfragen
        exit();
    } else {
        $_SESSION['error'] = "Fehler beim Löschen der Anfrage.";
    }
}

// Funktion zum Akzeptieren einer Anfrage
if(isset($_POST['accept_request_id'])) {
    $accept_request_id = $_POST['accept_request_id'];
    $sql_update_status = "UPDATE requests SET status = 'Akzeptiert' WHERE id = '$accept_request_id'";
    if(mysqli_query($con, $sql_update_status)) {
        $_SESSION['status'] = "Anfrage erfolgreich akzeptiert.";
        header("Location: mentor_request.php"); // Weiterleitung zur Seite mit den erhaltenen Anfragen
        exit();
    } else {
        $_SESSION['error'] = "Fehler beim Akzeptieren der Anfrage.";
    }
}

// Anzeigen oder Ausblenden der Anfragen
if(isset($_POST['toggle_requests'])) {
    $show_requests = $_POST['toggle_requests'];
    $_SESSION['show_requests'] = $show_requests;
}

echo '<div class="py-5">';
echo '<div class="container">';

// Tabelle für die erhaltenen Anfragen
echo '<div class="row">';
echo '<div class="col-md-12 text-center">';
echo "<h2>Erhaltene Anfragen</h2>";
echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<thead><tr><th>Mentee Vorname</th><th>Mentee Nachname</th><th>Status</th><th>Erhalten am</th><th>Aktionen</th></tr></thead><tbody>";

$sql_received_requests = "SELECT r.id, r.menteeId, u.vorname, u.nachname, r.status, r.created_at 
                         FROM requests r 
                         INNER JOIN users u ON r.menteeId = u.id 
                         WHERE r.mentorId IN (SELECT id FROM profile WHERE user_id = '$user_id')
                         AND r.status <> 'Akzeptiert'";
$result_received_requests = mysqli_query($con, $sql_received_requests);

if ($result_received_requests && mysqli_num_rows($result_received_requests) > 0) {
    while ($row_received_request = mysqli_fetch_assoc($result_received_requests)) {
        echo "<tr>";
        echo "<td>".$row_received_request['vorname']."</td>";
        echo "<td>".$row_received_request['nachname']."</td>";
        echo "<td>".$row_received_request['status']."</td>";
        echo "<td>".$row_received_request['created_at']."</td>";
        echo "<td><button class='btn btn-success' onclick='acceptRequest(".$row_received_request['id'].")'>Akzeptieren</button> <button class='btn btn-danger' onclick='deleteRequest(".$row_received_request['id'].")'>Löschen</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Keine Daten gefunden.</td></tr>";
}
echo "</tbody></table>";
echo "</div>"; // table-responsive
echo '</div>'; // col-md-12
echo '</div>'; // row

// Liste für die akzeptierten Anfragen
echo '<div class="row">';
echo '<div class="col-md-12 text-center">';

if(isset($_SESSION['show_requests']) && $_SESSION['show_requests'] == 'show') {
    echo "<h2>Akzeptierte Anfragen</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Mentee Vorname</th><th>Mentee Nachname</th><th>Status</th></tr></thead><tbody>";

    $sql_accepted_requests = "SELECT r.id, r.menteeId, u.vorname, u.nachname, r.status
                             FROM requests r 
                             INNER JOIN users u ON r.menteeId = u.id 
                             WHERE r.mentorId IN (SELECT id FROM profile WHERE user_id = '$user_id')
                             AND r.status = 'Akzeptiert'";
    $result_accepted_requests = mysqli_query($con, $sql_accepted_requests);

    if ($result_accepted_requests && mysqli_num_rows($result_accepted_requests) > 0) {
        while ($row_accepted_request = mysqli_fetch_assoc($result_accepted_requests)) {
            echo "<tr>";
            echo "<td>".$row_accepted_request['vorname']."</td>";
            echo "<td>".$row_accepted_request['nachname']."</td>";
            echo "<td>".$row_accepted_request['status']."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Keine akzeptierten Anfragen gefunden.</td></tr>";
    }

    echo "</tbody></table>";
    echo "</div>"; // table-responsive
    echo "<form method='post'>";
    echo "<input type='hidden' name='toggle_requests' value='hide'>";
    echo "<button class='btn btn-primary' type='submit'>Verberge akzeptierte Anfragen</button>";
    echo "</form>";
} else {
    echo "<form method='post'>";
    echo "<input type='hidden' name='toggle_requests' value='show'>";
    echo "<button class='btn btn-primary' type='submit'>Zeige akzeptierte Anfragen</button>";
    echo "</form>";
}

echo "</div>"; // col-md-12
echo "</div>"; // row

echo '</div>'; // container
echo '</div>'; // py-5

// Schließen der Verbindung zur Datenbank
mysqli_close($con);
?>

<script>
// JavaScript-Funktion zum Löschen einer Anfrage
function deleteRequest(requestId) {
    if (confirm("Sind Sie sicher, dass Sie diese Anfrage löschen möchten?")) {
        $.ajax({
            type: "POST",
            url: "mentor_request.php",
            data: {delete_request_id: requestId},
            success: function(response) {
                // Hier können Sie je nach Bedarf eine Rückmeldung anzeigen oder die Tabelle neu laden
                window.location.reload();
            }
        });
    }
}

// JavaScript-Funktion zum Akzeptieren einer Anfrage
function acceptRequest(requestId) {
    if (confirm("Sind Sie sicher, dass Sie diese Anfrage akzeptieren möchten?")) {
        $.ajax({
            type: "POST",
            url: "mentor_request.php",
            data: {accept_request_id: requestId},
            success: function(response) {
                // Hier können Sie je nach Bedarf eine Rückmeldung anzeigen oder die Tabelle neu laden
                window.location.reload();
            }
        });
    }
}
</script>
