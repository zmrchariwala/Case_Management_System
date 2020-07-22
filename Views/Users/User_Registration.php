<?php
    require_once '../../Models/User_Model.php';
    if(isset($_POST['submit']))
    {
        $user = new User_Models();
        //$result = $user->User_Registration($_POST['first_name'],$_POST['middle_name'],$_POST['last_name'],$_POST['date_of_birth'],$_POST['gender'],$_POST['email_address'],$_POST['password'],$_POST['start_date'],$_POST['end_date'],$_POST['home_phone'],$_POST['mobile_phone'],$_POST['address1'],$_POST['address2'],$_POST['city'],$_POST['state'],$_POST['postal_code'],$_POST['country'],$_POST['designation'],$_POST['location'],$_POST['department']);
        
        if($user->User_Registration($_POST['first_name'],$_POST['middle_name'],$_POST['last_name'],$_POST['date_of_birth'],$_POST['gender'],$_POST['email_address'],$_POST['password'],$_POST['start_date'],$_POST['end_date'],$_POST['home_phone'],$_POST['mobile_phone'],$_POST['address1'],$_POST['address2'],$_POST['city'],$_POST['state'],$_POST['postal_code'],$_POST['country'],$_POST['designation'],$_POST['location'],$_POST['department'])){
            //$id = $user->Last_Id();
            $email_address = $_POST['email_address'];
            //echo $id;
            $encrypt_email_address = base64_encode($email_address);
            $user_email = "zmrchariwala@gmail.com";
            $message = "<a href='http://localhost:8888/Case_Management_System/Views/Users/User_Activation.php?id=$encrypt_email_address'>Hello</a>";
            $subject ="Activation";
            $user->Send_Mail($user_email, $message, $subject);
        }
        else{
            echo 'not';
        }
        
    }
?>
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
        <form action="#" method="post">
            <div class="container">
                <h2>Registration</h2>
                <h5>Small thought</h5>
                <hr>

                <fieldset>
                    <legend>Personal information</legend>
                <div class="flex_container">
                    <div class="personal_information">
                        <div>
                            <label>First name:</label>
                        </div>
                        <div>
                            <input type="text" name="first_name" class="form-control" required/>
                        </div>
                        <div>
                            <label>Middle name:</label>
                        </div>
                        <div>
                            <input type="text" name="middle_name" class="form-control" />
                        </div>
                        <div>
                            <label>Last name:</label>
                        </div>
                        <div>
                            <input type="text" name="last_name" class="form-control" required/>
                        </div>
                        <div>
                            <label>Date of birth:</label>
                        </div>
                        <div>
                            <input type="date" name="date_of_birth" class="form-control" placeholder="YYYY-MM-DD" required/>
                        </div>
                        <div>
                            <label>Gender:</label>
                        </div>
                        <div>
                            <input type="radio" value="Male" name="gender" />
                            <label>Male</label>
                            <input type="radio" value="Female" name="gender" />
                            <label>Female</label>
                            <input type="radio" value="Others" name="gender" />
                            <label>Other</label>
                        </div>
                        <div>
                            <label>Home Phone:</label>
                        </div>
                        <div>
                            <input type="text" name="home_phone" class="form-control" />
                        </div>
                        <div>
                            <label>Mobile Phone:</label>
                        </div>
                        <div>
                            <input type="text" name="mobile_phone" class="form-control" required/>
                        </div>
                    </div>
                    <div class="address_information">
                        <div>
                            <label>Address 1:</label>
                        </div>
                        <div>
                            <input type="text" name="address1" class="form-control" required/>
                        </div>
                        <div>
                            <label>Address 2:</label>
                        </div>
                        <div>
                            <input type="text" name="address2" class="form-control" />
                        </div>
                        <div>
                            <label>Country:</label>
                        </div>
                        <div>
                            <select class="form-control" name="country">
                                <option value="Canada">Canada</option>
                                <option value="USA">United State of America</option>
                            </select>
                        </div>
                        <div>
                            <label>State:</label>
                        </div>
                        <div>
                            <select class="form-control" name="state">
                                <option value="Ontario">Ontario</option>
                                <option value="British Columbia">BC</option>
                            </select>
                        </div>
                        <div>
                            <label>City:</label>
                        </div>
                        <div>
                            <input type="text" name="city" class="form-control" />
                        </div>
                        <div>
                            <label>Postal code:</label>
                        </div>
                        <div>
                            <input type="text" name="postal_code" class="form-control" />
                        </div>
                    </div>
                </div>
                </fieldset>

                <fieldset>
                    <legend>Workplace details</legend>
                    <div class="workplace_information">
                        <div>
                            <label>Designation:</label>
                        </div>
                        <div>
                            <input type="text" name="designation" class="form-control" required/>
                        </div>
                        <div>
                            <label>Start date:</label>
                        </div>
                        <div>
                            <input type="date" name="start_date" class="form-control" required/>
                        </div>
                        <div>
                            <label>End date:</label>
                        </div>
                        <div>
                            <input type="date" name="end_date" class="form-control" required/>
                        </div>
                        <div>
                            <input type="checkbox" value="working"/> <label>Currently working</label>
                        </div>
                        <div>
                            <label>Location:</label>
                        </div>
                        <div>
                            <select class="form-control" name="location">
                                <option value="1">Location 1</option>
                                <option value="2">Location 2</option>
                            </select>
                        </div>
                        <div>
                            <label>Department:</label>
                        </div>
                        <div>
                            <select class="form-control" name="department">
                                <option value="1">Department 1</option>
                                <option value="2">Department 2</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Login details</legend>
                    <div class="login_information">
                        <div>
                        <label>Email address:</label>
                        </div>
                        <div>
                            <input type="email" name="email_address" class="form-control" required="email"/>
                        </div>
                        <div>
                            <label>Password:</label>
                        </div>
                        <div>
                            <input type="password" name="password" class="form-control" />
                        </div> 
                        <div>
                            <label>Reenter password:</label>
                        </div>
                        <div>
                            <input type="password" name="password1" class="form-control" />
                        </div> 
                    </div>
                </fieldset>
                <div>
                    <input type="submit" class="btn btn-primary" name="submit" />
                </div>
            </div>
        </form>
        <footer>
            
        </footer>
    </body>
</html>

