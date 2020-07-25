<?php
    require_once '../../Models/User_Model.php';
    if(isset($_POST['submit'])){
        $organization_type_name = $_POST['organization_type_name'];
        $user = new User_Models();
        if($user->Add_Organization_Type($organization_type_name)){
            echo 'Added';
        }
        
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Organization type</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../Style_Sheet/Style.css">
    </head>
    <body>
        <div>
            <h2>Add Organization Type</h2>
            <form method="post" action="#"> 
                <div>
                    <label>Organization type</label>
                </div>
                <div>
                    <input type="text" name="organization_type_name" class="form-control" required/>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="submit" />
                </div>
            </form>
       </div>
    </body>
</html>