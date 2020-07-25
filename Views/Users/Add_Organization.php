<?php
    require_once '../../Models/User_Model.php';
    $user = new User_Models();
    $results = $user->Fetch_Organization_Type();
    if(isset($_POST['submit'])){
        $organization_name = $_POST['organization_name'];
        $organization_type = $_POST['organization_type'];
        $organization_address1 = $_POST['organization_address1'];
        $organization_address2 = $_POST['organization_address2'];
        $organization_country = $_POST['organization_country'];
        $organization_state = $_POST['organization_state'];
        $organization_city = $_POST['organization_city'];
        $organization_postal_code = $_POST['organization_postal_code'];
        $organization_main_contact = $_POST['organization_main_contact'];
        $organization_secondary_contact = $_POST['organization_secondary_contact'];
        $user->Add_Organization($organization_name,$organization_address1,$organization_address2,$organization_country,$organization_state,$organization_city,$organization_postal_code,$organization_main_contact,$organization_secondary_contact,$organization_type);
        
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Organization</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../Style_Sheet/Style.css">
    </head>
    <body>
        <form method="post" action="#"> 
            
            <div class="container">
                <h2>Add Organization</h2>
                <div>
                    <label>Organization name</label>
                </div>
                <div>
                    <input type="text" name="organization_name" class="form-control" required/>
                </div>
                <div>
                    <label>Organization type:</label>
                </div>
                <div>
                    
                    <select name="organization_type" class="form-control">
                    <?php
                        foreach ($results as $result){
                            
                    ?>
                        <option value=<?= $result['organization_type_id']?>><?= $result['organization_type_name'] ?></option>
                    <?php
                    }
                    ?>
                    </select>
                    
                    
                </div>
                <div>
                    <label>Address 1</label>
                </div>
                <div>
                    <input type="text" name="organization_address1" class="form-control" required/>
                </div>
                <div>
                    <label>Address 2</label>
                </div>
                <div>
                    <input type="text" name="organization_address2" class="form-control"/>
                </div>
                <div>
                    <label>Country:</label>
                </div>
                <div>
                    <select class="form-control" name="organization_country">
                        <option value="Canada">Canada</option>
                        <option value="USA">United State of America</option>
                    </select>
                </div>
                <div>
                    <label>State:</label>
                </div>
                <div>
                    <select class="form-control" name="organization_state">
                        <option value="Ontario">Ontario</option>
                        <option value="British Columbia">BC</option>
                    </select>
                </div>
                <div>
                    <label>City:</label>
                </div>
                <div>
                    <input type="text" name="organization_city" class="form-control" />
                </div>
                <div>
                    <label>Postal code:</label>
                </div>
                <div>
                    <input type="text" name="organization_postal_code" class="form-control" />
                </div>
                <div>
                    <label>Main contact:</label>
                </div>
                <div>
                    <input type="text" name="organization_main_contact" class="form-control" required/>
                </div>
                <div>
                    <label>Secondary contact:</label>
                </div>
                <div>
                    <input type="text" name="organization_secondary_contact" class="form-control" required/>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="submit" />
                </div>
            </div>
        </form>
    </body>
</html>