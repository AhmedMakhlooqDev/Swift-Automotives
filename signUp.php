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
    <link rel="stylesheet" type="text/css" href="css/SignUp.css">

</head>

<body>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_name("u201700684");
    session_start();

    include_once "./Model/User.php";
    // check if request coming from post method
    if (isset($_POST["submit"])) {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $gender = $_POST["gender"];
        $nationality = $_POST["nationality"];

        $user = new User();
        $user->initWith(null, $fname, $lname, $phone, $email, $password, 1, $gender, $nationality);
        $user->add();
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

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                        </div>




                        <div id="logon" class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="password" required>
                        </div>




                        <!-- Example single danger button -->
                        <select name="gender" class="btn btn-danger" style="margin-bottom: 15px; padding-right: 267px;" required>
                            <option>male</option>
                            <option>Female</option>
                        </select>


                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="nationality" class="form-control" placeholder="Nationality" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" value="Register" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        have an account?<a href="#">Login</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#">Forgot your password?</a>
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