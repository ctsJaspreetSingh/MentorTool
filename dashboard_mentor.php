<?php 
session_start();

$page_title = "Mentor Dashboard";
include('includes/header.php'); 
include('includes/navbar.php'); 

// Überprüfen, ob der Benutzer bereits ein Profil hat
if(!isset($_SESSION['profile_created'])) {
    // Weiterleitung zur Profilerstellungsseite, falls noch kein Profil vorhanden ist
    header("Location: create_profile.php");
    exit();
}

// Profil wurde bereits erstellt, normale Dashboard-Inhalte anzeigen
echo "Mentor Dashboard";

?>
