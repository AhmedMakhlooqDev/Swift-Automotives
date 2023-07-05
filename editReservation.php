<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/admin.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_name("u201700684");
    session_start();

    include_once "./Model/User.php";
    include_once "./Model/reservation.php";
    include_once "./car.php";

    $us = new User();
    if (!$us->isAdmin()) {
        header("location: index.php");
    }

    $code = "";
    
    $START_DATE = "";
    $END_DATE = "";
    $result = false;
    $echoaaa = "";

    if (isset($_POST["submit"])) {

        $START_DATE = $_POST["START_DATE"];
        $END_DATE = $_POST["END_DATE"];
        $code = $_GET["Code"];
        $reservation = new Reservation();
        $rows = $reservation->getResevationDetails($code, $_SESSION["user_id"]);
        $result = $reservation->amendReservation($START_DATE,$END_DATE,$rows->CAR_ID,$code);
        //if result = false not updated else done
        if(!$result){
            $echoaaa = "Date not possible";
        } else {
            $echoaaa = "Updated successfully";
        }

    }
    ?>

<body style="background-color: #212529; ">
    <nav class="sb-topnav navbar navbar-expand  " style="background-color: black;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home.php" style="color: white;">Swift Automotives</a>
        <a class="navbar-brand ps-1" href="viewCars.php" style="color: white;">View current Cars</a>
        <!-- Sidebar Toggle-->


    </nav>
    <div id="layoutSidenav">

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid " style="width: 50%;">
                    <h1 class="mt-4">Edit Car</h1>
                    <form method="POST" id="cardBody">
                    <div class="col-xl-10">
                        <div class="card mb-4">
                            <div class="card-header" style="color: white;">
                                <i class="fas fa-chart-bar me-1" style="color: white; "></i>
                                Enter The new Reservation Period
                            </div>
                            </div>
                            <div class="card-body">
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Start Date</span>
                                    </div>
                                    <input type="date" name="START_DATE" class="form-control" value="">
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">End Date</span>
                                    </div>
                                    <input type="date" name="END_DATE" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group" style="padding-left: 15px; padding-bottom: 15px;">
                                <input type="submit" name='submit' value="Apply Changes " class="btn float-right login_btn" style="background-color: red; color: white;">
                            </div>
                            <?php echo $echoaaa ?>
                        </div>
                    </div>
                    </form>
                </div>
            </main>
            <footer class="py-4  mt-auto" style="background-color: black;">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2021</div>

                    </div>
                </div>
            </footer>
        </div>
    </div>


</body>

</html>