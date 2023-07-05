<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name("u201700684");
session_start();

include_once './Model/reservation.php';
include_once './Model/invoice.php';

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

$reservation_code = $_GET['reservationCode'];


include 'header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Swift Automotives</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>






    <div class="container-fluid" style="flex-direction: column;">

        <div>
            <h1 id="title">Swift Automotives</h1>
        </div>



        <div class="container-fluid" style="width: 100%;">



            <div class="d-flex justify-content-center">


                <div class="card" style="padding: 6em; margin-top: 3em; margin-bottom: 14.2em;">
                    <div>






                        <div style="color: white;">
                            <h1 style="font-weight: bold; text-align: center;">Thank You!</h1>
                            <h5 style=" text-align: center;">Please Find Down Your Reservation Code</h5>
                            <h5 style=" text-align: center;"><?php echo $reservation_code ?></h5>
                            
                        </div>





                    </div>
                </div>

            </div>



        </div>




    </div>
</body>
<?php


include 'footer.php';
?>

</html>