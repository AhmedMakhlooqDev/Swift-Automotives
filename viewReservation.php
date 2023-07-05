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
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_name("u201700684");
    session_start();

    include_once "./Model/User.php";
    include_once "./Model/reservation.php";
    include_once "./car.php";

    if (isset($_POST["submit"])) {

        $reservationCode = $_POST['reservationCode'];

        //$reservation = new Reservation();

        //$rows = $reservation->getResevationDetails($reservationCode, $_SESSION["user_id"]);

        //echo $reservationCode;
        //echo  $_SESSION["user_id"];
        
        if (!empty($rows)) {
            echo 'found a reservation';
        } else {
            echo 'BS';
        }
        mail($email,"Reservation Code","your reservation code is: $randCode");
        header("Location: viewReservationResults.php?ResCode={$reservationCode}");
    }

    include 'header.php';
    ?>





    <div class="container">

        <div>
            <h1 id="title">Swift Automotives</h1>
        </div>
        <div class="d-flex justify-content-center" >


            <div class="card">
                <div class="card-body" >
                    <form method="post" id="cardBody">


                        

                    <div class="row">
                    
                    <label style="color: white;"> Enter Your Reservation Code</label>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="reservationCode" class="form-control" placeholder="Reservation Code" required>
                        </div>
                        <div class="form-group ">
                            <input type="submit" value="Submit" name="submit" class="btn float-right login_btn">
                        </div>
                    

                       


                    
                    </div>
                        


                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
<?php


include 'footer.php';
?>

</html>