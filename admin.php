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

<body style="background-color: #212529;">

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_name("u201700684");

    session_start();
    include_once "./Model/User.php";
    include_once "./car.php";


    //check if user is an Admin
    $us = new User();
    if (!$us->isAdmin()) {
        header("location: index.php");
    }

    //total revenue

    if(isset($_POST["proceed"])){

        $connection = Database::getInstance()->getConnection();
        
        $startD = $_POST['sDate'];
        $endD = $_POST['eDate'];

        $query = "SELECT sum(INVOICE_TOTAL) as sum FROM dbproj_invoice where INVOICE_DATE_CREATED BETWEEN ? AND ?"; 
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $startD, $endD);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $roww = $stmt->fetch_assoc();
    }
    

    //Add Car
    if (isset($_POST["submit"])) {

        $carMake = $_POST["carMake"];
        $carModel = $_POST["carModel"];
        $carYear = $_POST["carYear"];
        $carImage = $_POST["Image"];
        $carType = $_POST["carType"];
        $rentPrice = $_POST["carPrice"];

        $car = new Car();
        $car->initWith(null, $carMake, $carModel, $carYear, $carImage, $carType, $rentPrice);
        $car->addCar();
    }


    $popCars = [];
    //most popular cars
    $topQuery = "SELECT r.CAR_ID,c.CAR_MAKE ,c.CAR_MODEL ,c.CAR_TYPE_ID, c.CAR_YEAR, COUNT(r.RESERVATION_ID) as 'count' FROM dbproj_reservation r, dbproj_car c where c.CAR_ID = r.CAR_ID GROUP by CAR_ID ORDER BY count(RESERVATION_ID) DESC LIMIT 3";
    $connection = Database::getInstance()->getConnection();
    $res = $connection->query($topQuery);
    if ($res) {

        while ($row = $res->fetch_object()) {
            array_push($popCars, $row);
        }
    }



    echo $connection->error;

    ?>


    <nav class="sb-topnav navbar navbar-expand  " style="background-color: black;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home.php" style="color: white;">Swift Automotives</a>
        <a class="navbar-brand ps-1" href="viewCars.php" style="color: white;">Search Available Cars</a>
        <!-- Sidebar Toggle-->


    </nav>
    <div id="layoutSidenav">

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4" style="width: 50%;">
                    <h1 class="mt-4">Dashboard</h1>



                    <form id="cardBody" method="POST">

                        <div class="col-xl-15">
                            <div class="card mb-4">
                                <div class="card-header" style="color: white;">
                                    <i class="fas fa-chart-bar me-1" style="color: white; "></i>
                                    Add car
                                </div>


                                <div class="card-body">
                                    <div id="logon" class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Car Make</span>
                                        </div>
                                        <input type="text" name="carMake" class="form-control">
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div id="logon" class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Car Model</span>
                                        </div>
                                        <input type="text" name="carModel" class="form-control">
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div id="logon" class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Car Year</span>
                                        </div>
                                        <input type="text" name="carYear" class="form-control">
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div id="logon" class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Image URL</span>
                                        </div>
                                        <input type="text" name="Image" class="form-control">
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div id="logon" class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Car Type</span>
                                        </div>
                                        <input type="text" name="carType" class="form-control">
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div id="logon" class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rent Price/day</span>
                                        </div>
                                        <input type="text" name="carPrice" class="form-control">
                                    </div>

                                </div>

                                <div class="form-group" style="padding-left: 15px; padding-bottom: 15px;">
                                    <input type="submit" name='submit' value="Add Car" class="btn float-right login_btn" style="background-color: red; color: white;">
                                </div>

                            </div>
                        </div>

                    </form>


                    <div class="col-xl-15">
                        <div class="card mb-4">
                            <div class="card-header" style="color: white;">
                                <i class="fas fa-chart-bar me-1" style="color: white;"></i>
                                Most popular Cars
                            </div>
                            <div class="card-body">

                                <table class="table table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">Car ID</th>
                                            <th scope="col">Car Make</th>
                                            <th scope="col">Car Model</th>
                                            <th scope="col">Car Year</th>
                                            <th scope="col">Times Reserved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($popCars as $car) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $car->CAR_ID ?></th>
                                                <td><?php echo $car->CAR_MAKE ?></td>
                                                <td><?php echo $car->CAR_MODEL ?></td>
                                                <td><?php echo $car->CAR_YEAR ?></td>
                                                <td><?php echo $car->count ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-15">
                        <div class="card mb-4">
                            <div class="card-header" style="color: white;">
                                <i class="fas fa-chart-bar me-1" style="color: white;"></i>
                                Total Revenue
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Start Date</span>
                                    </div>
                                    <input type="date" name="sDate" class="form-control" required>
                                </div>
                                <div class="input-group form-group" style="margin-top: 10px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">End Date</span>
                                    </div>
                                    <input type="date" name="eDate" class="form-control" required>
                                </div>

                                <div class="form-group " style="margin-top: 10px;">
                                    <input type="submit" value="Submit" name="proceed" class="btn-danger float-right login_btn" style="color: white;">
                                </div>
                                <label style="margin-top: 5px;"><?php  if(!empty($roww["sum"])){echo $roww["sum"] . "BD";}else{echo "no revenue in this date";} ?></label>

                                </form>
                            </div>
                        </div>
                    </div>


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