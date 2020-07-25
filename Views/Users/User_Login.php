<?php
    session_start();
    require_once '../../Models/User_Model.php';
    if(isset($_POST['submit'])){
        $email_address = $_POST['email_address'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        $user = new User_Models();
        $results = $user->Login_Process($email_address, $password,$user_type);
        echo $results;
        //header("location:Two_Factor_Authentication.php");
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../Style_Sheet/Style.css">
    </head>
    <body>
        <form method="post" action="#">
            <div class="container">
                <h2>Login</h2>
                <div>
                    <label>Login as:</label>
                </div>
                <div>
                <div>
                    <select name="user_type" class="form-control">
                        <option>--Select User--</option>
                        <option value="Case manager" >Case Manager</option>
                        <option value="Supervisor" >Supervisor</option>
                    </select>
                </div>
                    <label>Please enter email address:</label>
                </div>
                <div>
                    <input type="text" name="email_address" class="form-control"/>
                </div>
                <div>
                    <label>Please enter password:</label>
                </div>
                <div>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div>
                    <input type="submit" class="btn btn-success" name="submit"/>
                </div>
            </div>
        </form>
    </body>
</html>
