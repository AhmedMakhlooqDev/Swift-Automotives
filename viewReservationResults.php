<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>


<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Swift Automotives</title>
    <!--Made with love by Mutiullah Samim -->
    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="css/login.css">



</head>

<body>

    <?php

    //if ID has been found (or passed through the link) call the Delete Function
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_name("u201700684");
    session_start();


    include_once "./Model/User.php";
    include_once "./Model/reservation.php";
    include_once "./car.php";

    include 'header.php';

    $reservationCode = "";


    $reservationCode = $_GET["ResCode"];
    $isAmended = false;

    $reservation = new Reservation();

    $rows = $reservation->getResevationDetails($reservationCode, $_SESSION["user_id"]);
    $isAmended = $reservation->isAmended($reservationCode);
    if (!empty($isAmended)) {
        $isAmended = true;
    }

    if (isset($_POST['submit'])) {
        $reservation_id = $rows->RESERVATION_ID;
        $invoice_id = $rows->INVOICE_ID;

        if (!empty($invoice_id) && !empty($reservation_id)) {
            $resDel = new Reservation();
            $resDel->deleteResevation($reservation_id, $invoice_id);
        }
    }

    //return reservation row if found
    if (!empty($rows)) {
        if ($isAmended) {
            echo '
            <div class="container" style="margin-top:8.5em;">
            <div class="d-flex justify-content-center">
                <form method="post" id="cardBody">
                    <div class="card" style="margin-top: 6em;">
                        <div class="row no-gutters" style=" margin-bottom: 35px; margin-left: 35px; width: 100%;">
                            <div class="col-md-10" style="color: white;">
                                <p>Car Make:&nbsp; ' . $rows->CAR_MAKE . '</p>
                                <p>Car Model:&nbsp; ' . $rows->CAR_MODEL . '</p>
                                <p>Start Date:&nbsp; ' . $rows->START_DATE . '</p>
                                <p>End Date:&nbsp; ' . $rows->END_DATE . '</p>
                                <p style="font-weight: bold;"> Accessories</p>
                                <p>Grand Total:&nbsp;' . $rows->INVOICE_TOTAL . ' BD</p>
                                <a href="editReservation.php?Code=' . $reservationCode . '" class="btn btn-primary" style="width: 10rem;height:2.5rem;">Edit Reservation</a>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Delete" class="btn btn-danger">
                                    </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        ';
        } else {
            echo '
                <div class="container" style="margin-top:8.5em;">
                <div class="d-flex justify-content-center">
                    <form method="post" id="cardBody">
                        <div class="card" style="margin-top: 6em;">
                            <div class="row no-gutters" style=" margin-bottom: 35px; margin-left: 35px; width: 100%;">
                                <div class="col-md-10" style="color: white;">
                                    <p>Car Make:&nbsp; ' . $rows->CAR_MAKE . '</p>
                                    <p>Car Model:&nbsp; ' . $rows->CAR_MODEL . '</p>
                                    <p>Start Date:&nbsp; ' . $rows->START_DATE . '</p>
                                    <p>End Date:&nbsp; ' . $rows->END_DATE . '</p>
                                    <p style="font-weight: bold;"> Accessories</p>
                                    <p>Grand Total:&nbsp;' . $rows->INVOICE_TOTAL . ' BD</p>

                                    <div class="form-group">
                                    <input type="submit" name="submit" value="Delete" class="btn btn-danger">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
    } else {
        echo '<h1>No such Reservation Found</h1>';
    }


    ?>



</body>
<?php


include 'footer.php';
?>

</html>