<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #333; /* Dunklere Hintergrundfarbe */
        }

        .navbar-brand {
            color: #fff; /* Textfarbe ändern */
        }

        .navbar-nav .nav-link {
            color: #fff; /* Textfarbe ändern */
        }

        .navbar-toggler {
            color: #fff; /* Textfarbe des Toggler-Buttons ändern */
            border-color: #fff; /* Farbe des Toggler-Buttons ändern */
        }

        .nav-link.logout {
            position: relative; /* Positionierung relativ zum Elternelement */
        }

        .nav-link.logout:hover::after {
            content: "Logout"; /* Text anzeigen */
            position: absolute; /* Absolute Positionierung */
            top: 100%; /* Position unterhalb des Icons */
            left: 50%; /* Horizontal zentrieren */
            transform: translateX(-50%); /* Zurückverschieben um die Hälfte der Breite */
            background-color: #333; /* Hintergrundfarbe */
            color: #fff; /* Textfarbe */
            padding: 0.5rem; /* Innenabstand */
            border-radius: 5px; /* Abgerundete Ecken */
            z-index: 1; /* Über dem Icon anzeigen */
        }


        .nav-link.profile {
            position: relative; /* Positionierung relativ zum Elternelement */
        }

        .nav-link.profile:hover::after {
            content: "Profile"; /* Text anzeigen */
            position: absolute; /* Absolute Positionierung */
            top: 100%; /* Position unterhalb des Icons */
            left: 50%; /* Horizontal zentrieren */
            transform: translateX(-50%); /* Zurückverschieben um die Hälfte der Breite */
            background-color: #333; /* Hintergrundfarbe */
            color: #fff; /* Textfarbe */
            padding: 0.5rem; /* Innenabstand */
            border-radius: 5px; /* Abgerundete Ecken */
            z-index: 1; /* Über dem Icon anzeigen */
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Meine Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                <?php if(isset($_SESSION['authenticated'])): ?>
                    <li class="nav-item">
                            <a class="nav-link profile" href="profile.php">
                                <i class="bi bi-person" style="font-size: 2rem;"></i> <!-- Größeres Icon -->
                            </a>
                        </li>
                    
                    <li class="nav-item">
                            <a class="nav-link logout" href="logout.php">
                                <i class="bi bi-box-arrow-right" style="font-size: 2rem;"></i> <!-- Logout-Icon -->
                            </a>
                        </li>

                <?php endif ?>
                
                    <?php if(basename($_SERVER['PHP_SELF']) === 'register.php') { ?> <!-- Prüfe, ob die aktive Seite "register.php" ist -->
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php } elseif(basename($_SERVER['PHP_SELF']) === 'login.php') { ?> <!-- Prüfe, ob die aktive Seite "login.php" ist -->
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>

    <!-- JavaScript for Bootstrap components -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
