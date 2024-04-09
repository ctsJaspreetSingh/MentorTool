<?php 

session_start();

if(isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "You are already logged in";
    header('Location: mentorDashboard.php');
    exit(0);
}

$page_title = "Login Page";
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">


                <!-- <?php if(isset($_SESSION['status'])) : ?>
                    <div class="alert alert-success">
                        <h5><?php echo htmlspecialchars($_SESSION['status']); ?></h5>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?> -->

                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login</h5>
                    </div>

                    <div class="card-body">
                        
                        <form action="logincode.php" method="POST">
                           
                            <div class="form-group mb-3">
                                <label for="">Email Adresse</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Passwort</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <!-- <div class="form-group">
                                <label for="comment">Kommentar</label>
                                <textarea name="comment" class="form-control" required></textarea>
                            </div> -->

                          
                            <div class="form-group">
                                <button type="submit" name="login_now_btn" class="btn btn-primary">Login</button>

                                <a href="password-reset.php" class="float-end">Passwort vergessen?</a>
                            </div>
                        </form>
                        <hr>
                        <h5>
                            Keine Verifizierungs Email erhalten?
                            <a href="resend-email-verification.php">Erneut senden</a>
                        </h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
