<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Swift Automotives</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt- mt-lg-0" style="font-size: 15px;">

            <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="index.php">Reserve</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="viewReservation.php">View Reservation</a>
            </li>


        </ul>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <?php
            include_once "./Model/User.php";
            $us = new User();
            if ($us->isAdmin()) {
            ?>
                <div id="Admin">
                    <a href="admin.php" class="btn btn-danger" style="margin-right: 1em;">
                        Admin Panel
                    </a>
                </div>
            <?php } ?>

            <div id="Logout">
                <a href="logout.php" class="btn btn-danger" style="margin-right: 1em;">
                    Logout
                </a>
            </div>
        <?php } else { ?>
            <div id="signup">
                <a href="signUp.php" class="btn btn-danger" style="margin-right: 1em;">
                    Sign Up
                </a>
            </div>
            <div id="login">
                <a href="login.php" class="btn btn-danger">
                    Login
                </a>
            </div>
        <?php } ?>
    </div>
</nav>