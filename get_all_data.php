<?php
// get_all_data.php

session_start();

// Verbindung zur Datenbank herstellen
include('dbcon.php');

// SQL-Abfrage, um den Inhalt von users und profile zu kombinieren und anzuzeigen
$query = "SELECT users.*, profile.*
          FROM users 
          LEFT JOIN profile ON users.id = profile.user_id";
$result = mysqli_query($con, $query);

// Überprüfen, ob die Abfrage erfolgreich war
if($result) {
    // Daten als JSON zurückgeben
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
    echo "Error: " . mysqli_error($con);
}

// Verbindung zur Datenbank schließen
mysqli_close($con);

?>