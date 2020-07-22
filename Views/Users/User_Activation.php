<html>
    <head>
        <meta charset="UTF-8">
        <title>User registration</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../Style_Sheet/Style.css">
    </head>
    <body>
        <?php 
            require_once '../../Models/User_Model.php';
            $user = new User_Models();
            $email_address = $_GET['id'];
            echo $decode_email_addres = base64_decode($email_address);
            if($user->User_Activation($decode_email_addres))
            {
                echo 'done';
            }
            else{
                echo 'not done';
            }
            
        ?>
    </body>
</html>