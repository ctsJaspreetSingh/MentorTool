<?php
session_start();

$page_title = "Resend Email";
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
                    <h5>Email Verifikation erneut senden</h5>
                </div>

                <div class="card-body">

                    <form action="resend-code.php" method="POST">
                        <div class="form-group mb-3">
                            <label>Email Adresse</label>
                            <input type="text" name="email" class="form-control" placeholder="Email Adresse eingeben">
                        </div>
                        <div class="form-group mb-3">
                                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Abschicken</button>
                            </div>
                    </form>
                </div>
            </div>

            </div>
        </div>
    </div>

</div>