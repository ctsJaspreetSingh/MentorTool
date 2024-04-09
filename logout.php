<?php
session_start();

unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);


// JavaScript-Code, um ein Popup-Fenster für die Abmeldemeldung anzuzeigen
echo '<script>
    window.alert("Loggout erfolgreich");
    window.location.href = "login.php"; // Weiterleitung zur Login-Seite
</script>';
?>
