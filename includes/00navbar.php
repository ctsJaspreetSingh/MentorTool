<!-- 
<div class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Mentor Tool</a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <?php if(!isset($_SESSION['authenticated'])): ?>
        <?php if(basename($_SERVER['PHP_SELF']) !== "register.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
        <?php endif ?>
        
        <?php if(basename($_SERVER['PHP_SELF']) !== "login.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        <?php endif ?>
    <?php else: ?>
        <?php if(basename($_SERVER['PHP_SELF']) !== "profile.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profil</a>
            </li>
        <?php endif ?>

        <?php if(basename($_SERVER['PHP_SELF']) !== "mentorDashboard.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="mentorDashboard.php">Mentor Dashboard</a>
            </li>
        <?php endif ?>
        <?php if(basename($_SERVER['PHP_SELF']) !== "menteeDashboard.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="menteeDashboard.php">Mentee Dashboard</a>
            </li>
        <?php endif ?>
        
        <?php if(basename($_SERVER['PHP_SELF']) == "mentorDashboard.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="mentor_request.php">Anfragen</a>
            </li>
        <?php endif ?>
        
        <?php if(basename($_SERVER['PHP_SELF']) == "menteeDashboard.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        <?php endif ?>
        
        <?php if(basename($_SERVER['PHP_SELF']) !== "menteeDashboard.php" && basename($_SERVER['PHP_SELF']) !== "profile.php"): ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        <?php endif ?>
    <?php endif ?>
</ul>


                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
 -->