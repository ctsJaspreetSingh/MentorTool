<?php 
//das wird alles nache
session_start();

$page_title = "Registration Page";
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    


<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                 <?php if(isset($_SESSION['status'])) : ?>
                    <div class="alert alert-success">
                        <h5><?php echo htmlspecialchars($_SESSION['status']); ?></h5>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?> 
                    
                <div class="card shadow">
                <div class="card-header text-center">
                        <h5>Registration</h5>
                    </div>

                    <div class="card-body">
                        
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Nachname</label>
                                <input type="text" name="nachname" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Vorname</label>
                                <input type="text" name="vorname" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">ctsID</label>
                                <input type="text" name="ctsID" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Email Addresse</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Passwort</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Passwort bestätigen</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="user_type">User Typ</label>
                                <select name="user_type" id="user_type" class="form-control" placeholder="Rolle auswählen" required>
                                    <option value="" disabled selected>Bitte Rolle auswählen</option>
                                    <option value="Mentor">Mentor</option>
                                    <option value="Mentee">Mentee</option>
                                </select>
                            </div>

                            
                            <div class="form-group text-center">
                                <button type="submit" name="register_btn" class="btn btn-primary">Registrieren</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>