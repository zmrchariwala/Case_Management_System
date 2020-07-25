<?php
    require_once '../../Models/User_Model.php';
    session_start();
    $email_address = $_SESSION['email_address'];
    if(isset($_POST['submit']))
    {
        $user = new User_Models();
        $code = $_POST['activation_code'];
        $user_type = $_GET['u_id'];
        $user_type = base64_decode($user_type);
        $results = $user->Verify_Code($email_address,$code,$user_type);
        
        if($results === 'Correct')
        {
            if($user_type === "Case manager"){
                header("");
            }else if($user_type === "Supervisor"){
                header("location:");
            }
        }
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User profile</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../Style_Sheet/Style.css">
    </head>
    <body>
        <form method="post" action="#"> 
            <div class="container">
                <div>
                    <label>Please enter the code:</label>
                </div>
                <div>
                    <input type="text" class="form-control" name="activation_code"/>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="submit"/>
                </div>
            </div>
        </form>
    </body>
</html>