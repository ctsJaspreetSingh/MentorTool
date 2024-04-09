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
            background-color: #1E215C; /* Dunklere Hintergrundfarbe */
        }

        .navbar-brand {
            color: #fff; /* Textfarbe ändern */
        }

        .navbar-nav .nav-link {
            color: #fff; /* Textfarbe ändern */
            position: relative; /* Positionierung relativ zum Elternelement */
        }

        .navbar-nav .nav-link:hover::after {
            content: attr(data-text); /* Zeige den Text an, der im "data-text" Attribut des Elements enthalten ist */
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

        .navbar-nav .nav-link.active {
            background-color: #3A3EAC; /* Hervorhebungsfarbe für den aktiven Link */
        }

        .navbar-toggler {
            color: #fff; /* Textfarbe des Toggler-Buttons ändern */
            border-color: #fff; /* Farbe des Toggler-Buttons ändern */
        }

        /* Weitere CSS-Stile hier */
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Mentor Tool</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['authenticated'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'mentorDashboard.php' ? 'active' : '' ?>" href="mentorDashboard.php" data-text="Dashboard">
                                <i class="bi bi-caret-down-square-fill"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'mentor_request.php' ? 'active' : '' ?>" href="mentor_request.php" data-text="Request">
                                <i class="bi bi-card-list"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : '' ?>" href="profile.php" data-text="Profile">
                                <i class="bi bi-person"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link logout <?= basename($_SERVER['PHP_SELF']) === 'logout.php' ? 'active' : '' ?>" href="logout.php" data-text="Logout">
                                <i class="bi bi-box-arrow-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(basename($_SERVER['PHP_SELF']) === 'register.php'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php elseif(basename($_SERVER['PHP_SELF']) === 'login.php'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
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
