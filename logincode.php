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
                    header("Location: dashboard_mentor.php");
                } elseif ($row['user_type'] == 'Mentee') {
                    header("Location: dashboard_mentee.php");
                }
                exit(); // Beenden Sie das Skript nach der Weiterleitung
            } else {
                $_SESSION['status'] = "Please verify your Email";
                header("Location: login.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Wrong Password or Email.";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "All fields are mandatory";
        header("Location: login.php");
        exit(0);
    }
}
?>
