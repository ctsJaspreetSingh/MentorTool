<?php
include('dbcon.php');

// Überprüfen, ob die Anfrage-ID übergeben wurde
if(isset($_GET['id'])) {
    // Anfrage-ID erhalten
    $requestId = $_GET['id'];

    // SQL-Abfrage zum Löschen der Anfrage
    $query = "DELETE FROM requests WHERE id = $requestId";
    
    // Anfrage ausführen
    $result = mysqli_query($con, $query);

    // Überprüfen, ob die Anfrage erfolgreich war
    if($result) {
        echo "Anfrage erfolgreich gelöscht.";
    } else {
        echo "Fehler beim Löschen der Anfrage.";
    }
} else {
    echo "Anfrage-ID nicht gefunden.";
}

// Datenbankverbindung schließen
mysqli_close($con);
?>
