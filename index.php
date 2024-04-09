<?php 
session_start();


// Überprüfen, ob der Benutzer bereits angemeldet ist
if(isset($_SESSION['auth_user'])) {
    // Wenn der Benutzer bereits angemeldet ist, zerstören Sie die Sitzung und leiten Sie ihn zur Login-Seite weiter
    session_destroy();
    header("Location: index.php");
    exit();
}

$page_title = "Home Page";
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Mentor Tool</h2>
                <h4>IPA-Singh</h4>

                <!-- Buttons für Register und Login -->
                <div class="mt-4">
    <a href="register.php" class="btn btn-primary mx-2" style="background-color: #98B6DC; border: none;">Register</a>
    <a href="login.php" class="btn btn-success mx-2" style="background-color: #98B6DC; border: none;">Login</a>
</div>


            </div>
        </div>
    </div>
</div> 

<?php include('includes/footer.php'); ?>
