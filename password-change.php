<?php
session_start();

$page_title = "Password Change Update";
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                    <?php
                        if(isset($_SESSION['status']))
                        {
                            ?>
                            <div class="alert alert-success">
                                <h5><?=$_SESSION['status']; ?></h5>
                            </div>
                            <?php
                            unset($_SESSION['status']);
                        }
                    ?>

            <div class="card">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body p-4">

                    <form action="password-reset-code.php" method="POST">
                        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])) {echo $_GET['token'];} ?>">

                        <div class="form-group mb-3">
                            <label>Email Adresse</label>
                            <input type="text" name="email" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];} ?>" 
                                    class="form-control" placeholder="Enter Email Adress">
                        </div>
                        <div class="form-group mb-3">
                            <label>Neue Passwort</label>
                            <input type="text" name="new_password" class="form-control" placeholder="Neue Passwort eingeben">
                        </div>
                        <div class="form-group mb-3">
                            <label>Passwort bestätigen</label>
                            <input type="text" name="confirm_password" class="form-control" placeholder="Neuen Passwort bestätigen">
                        </div>

                        <div class="form-group mb-3">
                                <button type="submit" name="password_update" class="btn btn-success w-100">Passwort ändern</button>
                            </div>
                    </form>
                </div>
            </div>

            </div>
        </div>
    </div>

</div>