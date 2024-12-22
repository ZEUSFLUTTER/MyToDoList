<?php
include('conn.php');
session_start();


if(isset($_REQUEST['signUP'])) {
    ?>
    <script type="text/javascript">
        window.location ="f.php";
    </script>
    <?php
}


if(isset($_REQUEST['login'])) {
    $user = $_REQUEST['user'];
    $pass = $_REQUEST['pass'];

    $lgn = "SELECT * FROM reg WHERE user='$user' AND pass='$pass'";
    $reg = $conn->query($lgn);
    $chk = $reg->num_rows;

    if($chk == 1) {
        $_SESSION['user'] = $user; 
        ?>
        <script type="text/javascript">
            alert('Login success');
            window.location = "show.php";  
        </script>
        <?php
        exit();  
    } else {
     
        ?>
        <script type="text/javascript">
            alert('Login not successful');
            window.location = "login.php";  
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        .first_div {
            color: white;
            border-radius: 15px;
            margin: 150px;
            width: 50%;
            height: 100%;
            align-items: center;
            padding-top: 20px;
            padding-bottom: 90px;
            padding-left: 60px;
            padding-right: 60px;
            background-color: #3190D3;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Login Page</title>
</head>
<body>
    <center>
        <div class="first_div">
            <header>
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvV-lQazIfnPBqMEEskT8Pz0HwyVoEBfdAKP8ML2s9iBKien0K" width="90px" height="90px" alt="Logo">
                <h1>TO-DO LIST</h1>
            </header>
            <br>
            <form class="form-horizontal" method="POST">
                <div class="form-group">
                    <label for="inputUsername3" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" name="user" class="form-control" id="inputUsername3" placeholder="Enter your username">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="pass" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default" name="login" value="Sign In">Sign in</button>
                        <button type="submit" class="btn btn-default" name="signUP">Sign up</button>
                    </div>
                </div>
            </form>
        </div>
    </center>
</body>
</html>
