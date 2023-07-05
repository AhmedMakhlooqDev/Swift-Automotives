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


if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

$carid = $_GET['car_id'];
$startDate = $_GET['start_date'];
$enddate = $_GET['end_date'];
$totAcc = $_GET['totalAccessories'];


$digits = 6;
$randCode = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
$reservation_code = $randCode;

$from_date = strtotime($startDate);
$to_date = strtotime($enddate);
$totalDays = round(($to_date - $from_date) / (60 * 60 * 24) + 1);
$today = date('Y-m-d H:i:s'); 
$query = "SELECT * FROM dbproj_car WHERE CAR_ID = ?";

$connection = Database::getInstance()->getConnection();



$stmt = $connection->prepare($query);
$stmt->bind_param("i", $carid);
$stmt->execute();
$stmt = $stmt->get_result();
$row = $stmt->fetch_assoc();


$grandTotal = ($row["CAR_PRICE_PER_DAY"] * $totalDays) + floatval($totAcc);

if(isset($_POST['submit'])){
   
    $billingAddress = $_POST["bill"];

    $reservation = new Reservation();
    $invoice = new Invoice();

    
    $invoice->initWith(null,$grandTotal,$today,null);
    $invoice->createInvoice();

    $reservation->initWith(null, $reservation_code, $startDate, $carid, $enddate,$invoice->getINVOICE_ID(), $_SESSION["user_id"], $billingAddress); 

    if(isset($_POST['accessories']) &&  !$_POST['accessories'] == ''){
        $reservation->addReservation(explode(',',$_POST['accessories']));
    }
    else{
        $reservation->addReservation();
    }

    header("location: invoice.php?reservationCode={$reservation_code}");
    
    

}


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

       

        <div class="container-fluid" style="width: 85%;">

            <div class="row">

                <div class="col-md-8">


                    <div class="card">
                        <div class="row no-gutters" style=" margin-bottom: 35px; margin-left: 35px">
                            <div class="col-md-5">
                                <h1 style="font-weight: bold;">Reservation Summary</h1>
                                <p>Car Make:&nbsp; <?php echo $row["CAR_MAKE"]; ?></p>
                                <p>Car Model:&nbsp;  <?php echo  $row["CAR_MODEL"]; ?></p>
                                <p>Year:&nbsp; <?php echo $row["CAR_YEAR"]; ?></p>
                                <p>Car Type:&nbsp;  <?php echo $row["CAR_TYPE_ID"]; ?></p>
                                <p>Start Date:&nbsp;  <?php echo $startDate; ?></p>
                                <p>End Date:&nbsp;  <?php echo $enddate; ?></p>
                                <p>Price Per Day:&nbsp;  <?php echo $row["CAR_PRICE_PER_DAY"]; ?> BD</p>
                                <h2 style="font-weight: bold;">Additional Accessories</h2>
                                <?php echo $_GET['outputAccessories']; ?>
                                <h1 >Grand Total:&nbsp;  <?php echo $grandTotal;  ?> BD</h1>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form id="cardBody" method="POST">


                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Billing Address</span>
                                    </div>
                                    <input type="text" name="bill" class="form-control" required>
                                </div>


                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Card Number</span>
                                    </div>
                                    <input type="text" name="minPrice" class="form-control" required>
                                </div>
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Expiry Date</span>
                                    </div>
                                    <input type="date" name="maxPrice" class="form-control" required>
                                </div>
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Pin</span>
                                    </div>
                                    <input type="text" name="maxPrice" class="form-control" required>
                                </div>



                                <div class="form-group">
                                    <input type="submit" value="Confirm" name="submit" class="btn float-right login_btn">
                                    <input type="hidden" name="accessories" value="<?php echo $_GET['listAccessories']; ?>">
                                </div>
                            </form>
                        </div>
                    </div>








                </div>





            </div>
        </div>



        <div class="container">








        </div>
    </div>
</body>
<?php


include 'footer.php';
?>

</html>