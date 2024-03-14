<?php 
//das wird alles nache
session_start();

$page_title = "Registration Page";
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
                    
                <div class="card shadow">
                <div class="card-header">
                        <h5>Registration form</h5>
                    </div>

                    <div class="card-body">
                        
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Nachname</label>
                                <input type="text" name="nachname" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Vorname</label>
                                <input type="text" name="vorname" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">ctsID</label>
                                <input type="text" name="ctsID" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="register_btn" class="btn btn-primary">Register Now</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>