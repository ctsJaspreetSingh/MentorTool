<?php
// Verbindung zur Datenbank herstellen
include('dbcon.php');

// Überprüfen, ob die Benutzer-ID übergeben wurde
if(isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // SQL-Abfrage, um das Profil des Benutzers abzurufen
    $query = "SELECT * FROM profile WHERE user_id = $userId";
    $result = mysqli_query($con, $query);

    // Überprüfen, ob die Abfrage erfolgreich war
    if($result) {
        // Überprüfen, ob ein Profil für den Benutzer vorhanden ist
        if(mysqli_num_rows($result) > 0) {
            // Profilinformationen abrufen
            $profileData = mysqli_fetch_assoc($result);

            // Profilinformationen als JSON zurückgeben
            echo json_encode($profileData);
        } else {
            // Kein Profil für den Benutzer gefunden
            echo "No profile found for the user.";
        }
    } else {
        // Fehlermeldung anzeigen, falls die Abfrage fehlschlägt
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Benutzer-ID nicht übergeben
    echo "User ID not provided.";
}

// Verbindung zur Datenbank schließen
mysqli_close($con);
?>
