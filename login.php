<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name("u201700684");
session_start();

include_once './Model/User.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $hasLoggenIn = $user->login($email, $password);
    $id = $user->getUSER_ID();
    // echo "isLogged in $id";
    if($hasLoggenIn){
        echo "this is working";
        header("Location: index.php");
    }

}
include 'header.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Swift Automotives</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="css/login.css">

    

</head>

<body>

   




    <div class="container">

        <div>
            <h1 id="title">Swift Automotives</h1>
        </div>
        <div class="d-flex justify-content-center h-65">


            <div class="card">
                <div class="card-body">
                    <form id="cardBody" method="POST">
                        <div id="logon" class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control" placeholder="Email">

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="password">
                        </div>
                       
                        <div class="form-group">
                            <input type="submit" name='submit' value="Login" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="#">Sign Up</a>
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