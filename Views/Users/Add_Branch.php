<?php
    require_once '../../Models/User_Model.php';
    $user = new User_Models();
    $results = $user->Fetch_Organizations();
    if(isset($_POST['submit'])){
        $branch_id = $_POST['organization_id'];
        $branch_address1 = $_POST['branch_address1'];
        $branch_address2 = $_POST['branch_address2'];
        $branch_country = $_POST['branch_country'];
        $branch_state = $_POST['branch_state'];
        $branch_city = $_POST['branch_city'];
        $branch_postal_code = $_POST['branch_postal_code'];
        $branch_main_contact = $_POST['branch_main_contact'];
        $branch_secondary_contact = $_POST['branch_secondary_contact'];
        $user->Add_Branch($branch_id,$branch_address1,$branch_address2,$branch_country,$branch_state,$branch_city,$branch_postal_code,$branch_main_contact,$branch_secondary_contact);
        
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add branch</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../Style_Sheet/Style.css">
    </head>
    <body>
        
        <form method="post" action="#"> 
            <div class="container">
                <h2>Add branch</h2>
                <div>
                    <label>Organization</label>
                </div>
                <div>
                    
                    <select name="organization_id" class="form-control">
                    <?php
                        foreach ($results as $result){
                            
                    ?>
                        <option value=<?= $result['organization_id']?>><?= $result['organization_name'] ?></option>
                    <?php
                    }
                    ?>
                    </select>
                </div>
                <div>
                    <label>Address 1</label>
                </div>
                <div>
                    <input type="text" name="branch_address1" class="form-control" required/>
                </div>
                <div>
                    <label>Address 2</label>
                </div>
                <div>
                    <input type="text" name="branch_address2" class="form-control"/>
                </div>
                <div>
                    <label>Country:</label>
                </div>
                <div>
                    <select class="form-control" name="branch_country">
                        <option value="Canada">Canada</option>
                        <option value="USA">United State of America</option>
                    </select>
                </div>
                <div>
                    <label>State:</label>
                </div>
                <div>
                    <select class="form-control" name="branch_state">
                        <option value="Ontario">Ontario</option>
                        <option value="British Columbia">BC</option>
                    </select>
                </div>
                <div>
                    <label>City:</label>
                </div>
                <div>
                    <input type="text" name="branch_city" class="form-control" />
                </div>
                <div>
                    <label>Postal code:</label>
                </div>
                <div>
                    <input type="text" name="branch_postal_code" class="form-control" />
                </div>
                <div>
                    <label>Primary contact:</label>
                </div>
                <div>
                    <input type="text" name="branch_main_contact" class="form-control" required/>
                </div>
                <div>
                    <label>Secondary contact:</label>
                </div>
                <div>
                    <input type="text" name="branch_secondary_contact" class="form-control"/>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="submit" />
                </div>
            </div>
        </form>
    </body>
</html>