<?php 
session_start(); // session_start() zuerst aufrufen
$page_title = "Mentor Anfragen";
include('includes/header.php'); 
include('includes/navbar.php'); 
include('dbcon.php');

if (!isset($_SESSION['auth_user'])) {
    $_SESSION['status'] = "Please log in to view your Mentor Anfragen.";
    header("Location: login.php");
    exit();
}

// Mentor-ID festlegen
$mentorId = 38; // Ändern Sie dies entsprechend der gewünschten Mentor-ID

// Überprüfen, ob Anfragen vorhanden sind
$query = "SELECT * FROM requests WHERE mentorId = $mentorId";
$result = mysqli_query($con, $query);

// Überprüfen, ob Anfragen vorhanden sind
if (mysqli_num_rows($result) > 0) {
    // HTML-Tabellenkopf für Anfragen erstellen
    echo "<table class='table table-bordered'>
            <tr>
                <th>ID</th>
                <th>Mentor ID</th>
                <th>Mentee ID</th>
                <th>Status</th>
                <th>Aktionen</th>
            </tr>";

    // Anfragen in der Tabelle anzeigen
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['mentorId'] . "</td>";
        echo "<td>" . $row['menteeId'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>";
        // Button zum Akzeptieren der Anfrage mit AJAX
        echo "<button class='btn btn-success accept-btn' data-request-id='" . $row['id'] . "'>Akzeptieren</button>";
        // Button zum Löschen der Anfrage mit AJAX
        echo "<button class='btn btn-danger delete-btn' data-request-id='" . $row['id'] . "'>Löschen</button>";
        echo "</td>";
        echo "</tr>";
    }

    // Tabellenende
    echo "</table>";
} else {
    echo "Keine Anfragen für diesen Mentor gefunden.";
}

// Datenbankverbindung schließen
mysqli_close($con);
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // AJAX-Anfrage zum Akzeptieren einer Anfrage
        $(".accept-btn").click(function() {
            var requestId = $(this).data('request-id');
            $.ajax({
                url: 'accept_request.php',
                type: 'GET',
                data: { id: requestId },
                success: function(response) {
                    alert(response); // Zeigen Sie die Antwortmeldung an
                    // Seite neu laden
                    window.location.reload();
                },
                error: function() {
                    alert("Fehler beim Akzeptieren der Anfrage.");
                }
            });
        });

        // AJAX-Anfrage zum Löschen einer Anfrage
        $(".delete-btn").click(function() {
            var requestId = $(this).data('request-id');
            $.ajax({
                url: 'delete_request.php',
                type: 'GET',
                data: { id: requestId },
                success: function(response) {
                    alert(response); // Zeigen Sie die Antwortmeldung an
                    // Seite neu laden
                    window.location.reload();
                },
                error: function() {
                    alert("Fehler beim Löschen der Anfrage.");
                }
            });
        });
    });
</script>
