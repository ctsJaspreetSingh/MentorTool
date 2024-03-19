<?php
include('dbcon.php');

// Überprüfen, ob die Anfrage-ID übergeben wurde
if(isset($_GET['id'])) {
    // Anfrage-ID erhalten
    $requestId = $_GET['id'];

    // SQL-Abfrage zum Aktualisieren des Anfragestatus auf "akzeptiert"
    $query = "UPDATE requests SET status = 'akzeptiert' WHERE id = $requestId";
    
    // Anfrage ausführen
    $result = mysqli_query($con, $query);

    // Überprüfen, ob die Anfrage erfolgreich war
    if($result) {
        echo "Anfrage erfolgreich akzeptiert.";
    } else {
        echo "Fehler beim Akzeptieren der Anfrage.";
    }
} else {
    echo "Anfrage-ID nicht gefunden.";
}

// Datenbankverbindung schließen
mysqli_close($con);
?>
