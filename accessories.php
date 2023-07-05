<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>


<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login Page</title>
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

    include_once("./database.php");

    if(!isset($_SESSION['user_id'])){
        header('location: login.php');
    }

    if (isset($_POST["submit"])) {

        $query = "SELECT * FROM dbproj_car_accessories WHERE CAR_ACCESSORIES_ID = ?";
        $connection = Database::getInstance()->getConnection();

        $carid = $_GET['car_id'];
        $startDate = $_GET['start_date'];
        $enddate = $_GET['end_date'];




        $totalAccessories = 0;
        $outputAccessories = '';
        $listAccessories = '';

        $userAccessories = [];
        foreach ($_POST["accessory"] as $accessory) {
            array_push($userAccessories, $accessory);
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $accessory);
            $stmt->execute();
            $stmt = $stmt->get_result();
            $row = $stmt->fetch_assoc();
            $price = floatval($row['CAR_ACCESSORIES_PRICE']);
            $totalAccessories += $price;
            $outputAccessories .= '<p>'.$row['CAR_ACCESSORIES_NAME'].': '.$row['CAR_ACCESSORIES_PRICE'].' BD</p>';
            
            if($accessory == $_POST['accessory'][count($_POST['accessory'])-1]){
                $listAccessories .= "$accessory";
            }
            else{
                $listAccessories .= "$accessory,";
            }
        }
        $_SESSION["accessory"] = $userAccessories;

        header("Location: checkout.php?car_id={$carid}&start_date={$startDate}&end_date={$enddate}&totalAccessories={$totalAccessories}&outputAccessories={$outputAccessories}&listAccessories={$listAccessories}");
    }

    include 'header.php';
    ?>





    <div class="container">

        <div>
            <h1 id="title">Swift Automotives</h1>
        </div>
        <div class="d-flex justify-content-center h-65">


            <div class="card">
                <div class="card-body">
                    <form method="post" id="cardBody">

                        <label style="color: white;">Choose Accessories</label>
                        <!-- Example single danger button -->
                        <div class="form-check" style="color: white;">
                            <input class="form-check-input" name="accessory[]" type="checkbox" value="1" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Leather Seats : 65.000 BD
                            </label>
                        </div>
                        <div class="form-check" style="color: white;">
                            <input class="form-check-input" name="accessory[]" type="checkbox" value="2" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Android Screen : 35.000 BD
                            </label>
                        </div>
                        <div class="form-check" style="color: white;">
                            <input class="form-check-input" name="accessory[]" type="checkbox" value="3" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Sensors : 40.000 BD
                            </label>
                        </div>
                        <div class="form-check" style="color: white;">
                            <input class="form-check-input" name="accessory[]" type="checkbox" value="4" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Apple Car play : 99.000 BD
                            </label>
                        </div>


                        <div class="form-group">
                            <input type="submit" value="Search" name="submit" class="btn float-right login_btn">
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