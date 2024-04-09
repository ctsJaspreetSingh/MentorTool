<?php
session_start();
include('dbcon.php');

if (isset($_POST['login_now_btn'])) {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1 ";
        $login_query_run = mysqli_query($con, $login_query);

        if (mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_array($login_query_run);

            if ($row['verify_status'] == "1") {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'id' => $row['id'],
                    'username' => $row['nachname'],
                    'vorname' => $row['vorname'],
                    'ctsID' => $row['ctsID'],
                    'email' => $row['email'],
                    'user_type' => $row['user_type'], // Speichern des Benutzertyps in der Session
                ];

                // Überprüfen, ob das Profil bereits erstellt wurde
                if ($row['profile_created'] == 0) {
                    // Weiterleitung zur Profilerstellungsseite
                    header("Location: create_profile.php");
                    exit();
                }

                // Weiterleitung basierend auf dem Benutzertyp
                if ($row['user_type'] == 'Mentor') {
                    header("Location: mentorDashboard.php");
                } else
                {
                    header("Location: menteeDashboard.php");
                }
                exit(); // Beenden Sie das Skript nach der Weiterleitung
            } else {
                echo '<script>
                        window.alert("Bitte verifizieren Sie Ihre Email 
                        zuerst und versuchen es später nochmals.");
                        window.location.href = "login.php";
                    </script>'; 
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Wrong Password or Email.";
            echo '<script>
                    window.alert("Wrong Password or Email");
                    window.location.href = "login.php";
                </script>';
          
        }
    } else {
        
        echo '<script>
                window.alert("All fields are mandatory");
                window.location.href = "login.php";
            </script>';
        
    }
}
session_destroy();
?>
