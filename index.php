

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name("u201700684");
session_start();

include_once './Model/reservation.php';

if (isset($_POST["submit"])) {
    $carModel = $_POST["carModel"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $carType = $_POST["carType"];
    $minPrice = $_POST["minPrice"];
    $maxPrice = $_POST["maxPrice"];


    $reservation = new Reservation();
    $carSearch = $reservation->Search($startDate, $endDate, $minPrice, $maxPrice, $carType, $carModel);
}


include 'header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Swift Automotives</title>
    <!--Made with love by Mutiullah Samim -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

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

        <div>
            <h3 id="titleS">Search Cars</h3>
        </div>

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form id="cardBody" method="POST">
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Car Model</span>
                                    </div>
                                    <input type="text" name="carModel" class="form-control">
                                </div>

                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Start Date</span>
                                    </div>
                                    <input type="date" name="startDate" class="form-control" required>
                                </div>

                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">End Date</span>
                                    </div>
                                    <input type="date" name="endDate" class="form-control" required>
                                </div>
                                <label>Car Type</label>
                                <select name="carType" style="width: 100%;" class="btn btn-danger" style="margin-bottom: 15px; padding-right: 278px;" aria-placeholder="Car Type" required>
                                    <option value="1">Sedan</option>
                                    <option value="2">Suv</option>
                                    <option value="3">Sport</option>
                                </select>
                                <label>Minimum Price</label>
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">price in BD</span>
                                    </div>
                                    <input type="text" name="minPrice" class="form-control" required>
                                </div>
                                <label>Maximum Price</label>
                                <div id="logon" class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">price in BD</span>
                                    </div>
                                    <input type="text" name="maxPrice" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Search" name="submit" class="btn float-right login_btn">
                                </div>
                            </form>
                        </div>
                    </div>








                </div>

                <div class="col-md-8">
                    <?php
                    if (!empty($carSearch)) {
                        foreach ($carSearch as $row) {
                            echo '
                            <div class="card" >
                            <div class="row no-gutters" style=" margin-bottom: 35px; margin-left: 35px">
                                <div class="col-sm-5">
                                    <img src="' . $row["CAR_IMAGE"] . '" style=" object-fit: contain; max-width: 400px; max-height: 250px;">
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h4 class="card-title">' . $row["CAR_MAKE"] . ' ' . $row["CAR_MODEL"] . '</h4>
                                            <p class="card-text">Year: ' . $row["CAR_YEAR"] . '</p>
                                            <p class="card-text">Car Type: ' . $row["CAR_TYPE_ID"] . '</p>
                                            <a href="accessories.php?car_id='.$row["CAR_ID"].'&start_date='.$_POST["startDate"].'&end_date='.$_POST["endDate"].'" class="btn btn-primary stretched-link">Reserve</a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    }else{
                        ?>
                        <div class="card">
                            <div class="row no-gutters" style=" margin-bottom: 35px; margin-left: 35px">
                            <h2>No Cars In Selection</h2>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
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