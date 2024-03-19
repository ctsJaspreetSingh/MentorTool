<?php
// Session starten
session_start();

// Benutzertyp in der Session speichern
$_SESSION['user_type'] = "Mentor";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navtest</title>
</head>
<body>
    <?php include('includes/navbar.php'); ?>
</body>
</html>
