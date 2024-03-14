<?php
session_start();
include('dbcon.php');


if(isset($_POST['login_now_btn']))
{
    if(!empty(trim($_POST['email'])) &&!empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1 ";
        $login_query_run = mysqli_query($con, $login_query);

        if(mysqli_num_rows($login_query_run) > 0)
        {
            $row = mysqli_fetch_array($login_query_run);
            //echo $row['verify_status'];
            if($row['verify_status'] == "1")
            {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username' => $row['name'],
                    'phone' => $row['phone'],
                    'email' => $row['email'],
                ];
                $_SESSION['status'] = "You are logged in successfully.";
                header("Location: dashboard.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Please verify your Email";
                header("Location: login.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "Wrong Password or Email.";
            header("Location: login.php");
            exit(0);
        }

    }
    else
    {
        $_SESSION['status'] = "all fields are mandatory";
        header("Location: login.php");
        exit(0);
    }
   
}
?>