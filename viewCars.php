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
include_once "./car.php";

$us = new User();
if (!$us->isAdmin()) {
    header("location: index.php");
}

if (isset($_POST["submit"])) {

    $search = $_POST["search"];
    $query = "SELECT * FROM dbproj_car WHERE MATCH(CAR_MAKE) AGAINST(?)";

    $connection = Database::getInstance()->getConnection();
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $stmt = $stmt->get_result();
    $cars = [];
    while ($row = $stmt->fetch_object()) {
        $car = new Car();
        $car->initWith($row->CAR_ID, $row->CAR_MAKE, $row->CAR_MODEL, $row->CAR_YEAR, $row->CAR_IMAGE, $row->CAR_TYPE_ID, $row->CAR_PRICE_PER_DAY);
        array_push($cars, $car);
    };
}



?>

<body style="background-color: #212529; ">
    <nav class="sb-topnav navbar navbar-expand  " style="background-color: black;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home.php" style="color: white;">Swift Automotives</a>
        
        <!-- Sidebar Toggle-->


    </nav>
    <div id="layoutSidenav">

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4" style="width: 50%;">
                    <h1 class="mt-4">Search Available Cars</h1>


                    <form id="cardBody" method="POST">

                        <div class="col-xl-15">

                            <div id="logon" class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Car Model</span>
                                </div>
                                <input type="text" name="search" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="submit" value="Search" name="submit" class="btn float-right login_btn" style="background-color: white;">
                            </div>
                            <div class="card-body">


                                <table class="table table-dark">
                                    <thead>
                                        <tr>
                                            
                                            <th scope="col"></th>
                                            
                                            <th scope="col">Car ID</th>
                                            <th scope="col">Car Make</th>
                                            <th scope="col">Car Model</th>
                                            <th scope="col">Car Year</th>
                                            <th scope="col">Car Type</th>
                                            <th scope="col">Price/day</th>
                                            <th scope="col">Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        /**
                                         * @var Car $v
                                        */
                                        if(!empty($cars)){
                                        foreach ($cars as $v) {
                                        ?>
                                            <tr>
                                                
                                                <td><a href="edit.php?id=<?=$v->getCAR_ID()?>" class="btn btn-primary" style="width: 6rem;height:2.5rem;">Edit</a></td>                                               
                                                <th scope="row"><?= $v->getCAR_ID() ?></th>
                                                <td><?= $v->getCAR_MAKE() ?></td>
                                                <td><?= $v->getCAR_MODEL() ?></td>
                                                <td><?= $v->getCAR_YEAR() ?></td>
                                                <td><?= $v->getCAR_TYPE_ID() ?></td>
                                                <td><?= $v->getCAR_PRICE_PER_DAY() ?> BD</td>
                                                <td><img src="<?= $v->getCAR_IMAGE() ?>" width="100px" height="50px"></td>
                                            </tr>

                                        <?php }} ?>
                                    </tbody>
                                </table>
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