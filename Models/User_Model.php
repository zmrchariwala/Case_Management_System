<?php
require_once '../../Database/Database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class User_Models
{
    function User_Registration($first_name,$middle_name,$last_name,$date_of_birth,$gender,$email_address,$password,$start_date,$end_date,$home_phone,$mobile_phone,$address1,$address2,$city,$state,$postal_code,$country,$designation,$location_id,$department_id){
        try{
        $db = Database::getDb();
        $password_hash = sha1($password);
        $date_format = date('Y-m-d', strtotime($date_of_birth));
        //$date_format = date('Y-m-d',$date_of_birth);
        $start_date_format = date('Y-m-d',strtotime($start_date));
        $end_date_format = date('Y-m-d',strtotime($end_date));
        $current_date = date('Y-m-d');
        $role = 'User';
        $status = 'Inactive';
        //$query= "CALL add_users($first_name,$middle_name,$last_name,$date_of_birth,$gender,$email_address,$password,$start_date,$end_date,$home_phone,$mobile_phone,$address1,$address2,$city,$state,$postal_code,$country,$designation,$location_id,$department_id,$ss,$ss,$role,$status);";
        //$query= "CALL add_users('Johnny','Adam','Jeffery','1990-10-25','Male','john@gmail.com','password123','2012-02-01',null,null,'6477867876','57 East road',null,'Toronto','Ontario','L1S 5W2','Canada','Sales staff',3,1,'hi','hi','User','Inactive');";
        $query= "CALL add_users(:first_name,:middle_name,:last_name,:date_of_birth,:gender,:email_address,:password,:start_date,:end_date,:home_phone,:mobile_phone,:address1,:address2,:city,:state,:country,:postal_code,:designation,:department_id,:location_id,:add_date,:modification_date,:role,:status);";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':middle_name',$middle_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':date_of_birth',$date_format);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':email_address',$email_address);
        $stmt->bindParam(':password',$password_hash);
        $stmt->bindParam(':start_date',$start_date_format);
        $stmt->bindParam(':end_date',$end_date_format);
        $stmt->bindParam(':home_phone',$home_phone);
        $stmt->bindParam(':mobile_phone',$mobile_phone);
        $stmt->bindParam(':address1',$address1);
        $stmt->bindParam(':address2',$address2);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        $stmt->bindParam(':country',$country);
        $stmt->bindParam(':postal_code',$postal_code);
        
        $stmt->bindParam(':designation',$designation);
        $stmt->bindParam(':location_id',$location_id);
        $stmt->bindParam(':department_id',$department_id);
        $stmt->bindParam(':add_date', $current_date);
        $stmt->bindParam(':modification_date',$current_date);
        $stmt->bindParam(':role',$role);
        $stmt->bindParam(':status',$status);
        $result = $stmt->execute();
        return $result;
        }
        catch (PDOException $e)
        {
            echo 'hi';
            echo $e->getMessage();
        }
        
    }
    function Last_Id(){
        $db = Database::getDb();
        $id = $db->lastInsertId();
        return $id;
    }
    function User_Activation($email_address){
        $db = Database::getDb();
        $status = 'Active';
        $query = "UPDATE users_registration SET status = :status WHERE email_address = :email_address";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':email_address',$email_address);
        $result = $stmt->execute();
        return $result;
    }
    function Login_Process($email_address,$password,$user_type){
        $db = Database::getDb();
        if($user_type === "Case manager"){
            
        
            $query = "select * from users_registration where email_address = :email_address";
            $stmt=$db->prepare($query);
            $stmt->bindParam(':email_address',$email_address);
            //$stmt->bindParam(':password',$password);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //echo $results;

            if($stmt->rowcount() == 1)
            {
                $hash_password = sha1($password);
                foreach ($results as $result){
                    if($hash_password === $result['password'])
                    {
                        if($result['status'] === "Active")
                        {

                            $code = $this->Generate_Code();
                            $update_code = "UPDATE users_registration SET activation_code = :code WHERE email_address = :email_address";
                            $stmt1=$db->prepare($update_code);
                            $stmt1->bindParam(':code',$code);
                            $stmt1->bindParam(':email_address',$email_address);
                            $result = $stmt1->execute();
                            $_SESSION['email_address']=$email_address;
                            $message = "Your login code is ".$code;
                            $subject = "Login code";
                            $this->Send_Mail($email_address, $message, $subject);
                            //return 'Active';
                            //exit();
                            header("location:Two_Factor_Authentication.php");
                        }
                        else {
                            return 'Inactive';
                            exit();
                        }
                    }
                    else{
                        return 'Incorrect password';
                        exit();
                    }
                }
            }
            else{
                return 'Incorrect email address';
                exit();
            }
        }else if($user_type === "Supervisor"){
            
            $query = "select * from supervisor_registration where supervisor_email_address = :email_address";
            $stmt=$db->prepare($query);
            $stmt->bindParam(':email_address',$email_address);
            //$stmt->bindParam(':password',$password);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //echo $results;
            
            if($stmt->rowcount() == 1)
            {
                $hash_password = sha1($password);
                foreach ($results as $result){
                    if($hash_password === $result['supervisor_password'])
                    {
                        if($result['supervisor_account_status'] === "Active")
                        {

                            $code = $this->Generate_Code();
                            $update_code = "UPDATE supervisor_registration SET supervisor_activation_code = :code WHERE supervisor_email_address = :email_address";
                            $stmt1=$db->prepare($update_code);
                            $stmt1->bindParam(':code',$code);
                            $stmt1->bindParam(':email_address',$email_address);
                            $result = $stmt1->execute();
                            $_SESSION['email_address']=$email_address;
                            $message = "Your login code is ".$code;
                            $subject = "Login code";
                            $this->Send_Mail($email_address, $message, $subject);
                            $hash_user_type = base64_encode($user_type);
                            header("location:Two_Factor_Authentication.php?u_id='$hash_user_type'");
                        }
                        else {
                            return 'Inactive';
                            exit();
                        }
                    }
                    else{
                        return 'Incorrect password';
                        exit();
                    }
                }
            }
            else{
                return 'Incorrect email address';
                exit();
            }
        }
        
    }
    function Generate_Code(){
        $code = mt_rand(100000, 999999);
        return $code;
    }
    function Verify_Code($email_address,$code,$user_type){
        $db = Database::getDb();
        if($user_type === "Case manager"){
            
        
        $query = "select * from users_registration where email_address = :email_address AND activation_code = :code";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':email_address',$email_address);
        $stmt->bindParam(':code',$code);
        $result = $stmt->execute();
        if($stmt->rowcount() == 1)
        {
            return 'Correct';
        }
        else{
            return 'Wrong code';
        }
        }else if($user_type === "Supervisor"){
            $query = "select * from supervisor_registration where supervisor_email_address = :email_address AND supervisor_activation_code = :code";
            $stmt=$db->prepare($query);
            $stmt->bindParam(':email_address',$email_address);
            $stmt->bindParam(':code',$code);
            $result = $stmt->execute();
            if($stmt->rowcount() == 1)
            {
                return 'Correct';
            }
            else{
                return 'Wrong code';
            }
        }
        //return $result;
        
    }
    
    function Send_Mail($user_email,$message,$subject)
    {
        require 'phpmailer/vendor/autoload.php';
        $mail= new PHPMailer(true);
        $mail->IsSMTP();
        //$mail->SMTPDebug  = 3;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPOptions=array(
            'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_signed'=>true
            )
        );
        //print_r($user_email);
        $mail->AddAddress($user_email);
        $mail->Username="zmrchariwala@gmail.com";
        $mail->Password="princedonno1";
        $mail->SetFrom('zmrchariwala@gmail.com');
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }
    function Add_Organization_Type($organization_type_name){
        $db = Database::getDb();
        $query = "CALL add_organization_type(:organization_type_name)";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':organization_type_name',$organization_type_name);
        $result = $stmt->execute();
        return $result;
    }
    function Fetch_Organization_Type(){
        $db = Database::getDb();
        $query = "select * from organization_type";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
         return $results;
    }
    function Add_Organization($organization_name,$organization_address1,$organization_address2,$organization_country,$organization_state,$organization_city,$organization_postal_code,$organization_main_contact,$organization_secondary_contact,$organization_type){
        $db = Database::getDb();
        $current_date = date('Y-m-d');
        $add_by = 1;
        $query = "CALL add_organization(:organization_name,:organization_address1,:organization_address2,:organization_country,:organization_state,:organization_city,:organization_postal_code,:organization_primary_contact,:organization_secondary_contact,:organization_type_id,:organization_add_date,:organization_add_by,:organization_modification_date)";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':organization_name',$organization_name);
        $stmt->bindParam(':organization_address1',$organization_address1);
        $stmt->bindParam(':organization_address2',$organization_address2);
        $stmt->bindParam(':organization_country',$organization_country);
        $stmt->bindParam(':organization_state',$organization_state);
        $stmt->bindParam(':organization_city',$organization_city);
        $stmt->bindParam(':organization_postal_code',$organization_postal_code);
        $stmt->bindParam(':organization_primary_contact',$organization_main_contact);
        $stmt->bindParam(':organization_secondary_contact',$organization_secondary_contact);
        $stmt->bindParam(':organization_type_id',$organization_type);
        $stmt->bindParam(':organization_add_date',$current_date);
        $stmt->bindParam(':organization_add_by',$add_by);
        $stmt->bindParam(':organization_modification_date',$current_date);
        $result = $stmt->execute();
        
    }
    function Fetch_Organizations(){
        $db = Database::getDb();
        $query = "select * from organization";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_ASSOC);
         return $results;
    }
    function Add_Branch($branch_id,$branch_address1,$branch_address2,$branch_country,$branch_state,$branch_city,$branch_postal_code,$branch_main_contact,$branch_secondary_contact){ 
        $db = Database::getDb();
        $current_date = date('Y-m-d');
        $branch_add_by = 1;
        $query = "CALL add_branch(:organization_id,:branch_address1,:branch_address2,:branch_country,:branch_state,:branch_city,:branch_postal_code,:branch_primary_contact,:branch_secondary_contact,:branch_add_date,:branch_add_by,:branch_modification_date)";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':organization_id',$branch_id);
        $stmt->bindParam(':branch_address1',$branch_address1);
        $stmt->bindParam(':branch_address2',$branch_address2);
        $stmt->bindParam(':branch_country',$branch_country);
        $stmt->bindParam(':branch_state',$branch_state);
        $stmt->bindParam(':branch_city',$branch_city);
        $stmt->bindParam(':branch_postal_code',$branch_postal_code);
        $stmt->bindParam(':branch_primary_contact',$branch_main_contact);
        $stmt->bindParam(':branch_secondary_contact',$branch_secondary_contact);
        $stmt->bindParam(':branch_add_date',$current_date);
        $stmt->bindParam(':branch_add_by',$branch_add_by);
        $stmt->bindParam(':branch_modification_date',$current_date);
        $result = $stmt->execute();
        
        //CALL add_branch(5,'Toronto',null,'Canada','Ontario','Toronto','L4T 1T7','4155565654','4155565654','2012-02-01',1,'2012-02-01');
    }
    function Fetch_Branches($organization_id){
        $db = Database::getDb();
        $query = "CALL fetch_organization_branches($organization_id)";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchall(PDO::FETCH_OBJ);
         return $results;
    }
    
    function Create_Contact($first_name,$middle_name,$last_name,$date_of_birth,$gender,$email_address,$home_phone,$mobile_phone,$address1,$address2,$city,$state,$postal_code,$country,$organization_id,$organization_branch_id,$designation,$start_date,$end_date){
        $db = Database::getDb();
        $date_format = date('Y-m-d', strtotime($date_of_birth));
        $start_date_format = date('Y-m-d',strtotime($start_date));
        $end_date_format = date('Y-m-d',strtotime($end_date));
        $current_date = date('Y-m-d');
        $add_by = 1;
        $query = "CALL add_contact(:first_name,:middle_name,:last_name,:date_of_birth,:gender,:email_address,:start_date,:end_date,:home_phone,:mobile_phone,:address1,:address2,:city,:state,:country,:postal_code,:designation,:organization_id,:organization_branch_id,:add_date,:add_by,:modification_date);";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':middle_name',$middle_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':date_of_birth',$date_format);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':email_address',$email_address);
        
        $stmt->bindParam(':start_date',$start_date_format);
        $stmt->bindParam(':end_date',$end_date_format);
        $stmt->bindParam(':home_phone',$home_phone);
        $stmt->bindParam(':mobile_phone',$mobile_phone);
        $stmt->bindParam(':address1',$address1);
        $stmt->bindParam(':address2',$address2);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        $stmt->bindParam(':country',$country);
        $stmt->bindParam(':postal_code',$postal_code);
        
        $stmt->bindParam(':designation',$designation);
        $stmt->bindParam(':organization_id',$organization_id);
        $stmt->bindParam(':organization_branch_id',$organization_branch_id);
        
        $stmt->bindParam(':add_date', $current_date);
        $stmt->bindParam(':add_by', $add_by);
        $stmt->bindParam(':modification_date',$current_date);
        $stmt->execute();
    }
    
    function Create_Supervisor($first_name,$middle_name,$last_name,$date_of_birth,$gender,$email_address,$password,$home_phone,$mobile_phone,$address1,$address2,$city,$state,$postal_code,$country,$organization_id,$organization_branch_id){
        $db = Database::getDb();
        $date_format = date('Y-m-d', strtotime($date_of_birth));
        $current_date = date('Y-m-d');
        $add_by = 1;
        $status = "Active";
        $activation_code = NULL;
        $hash_password = sha1($password);
        $query = "CALL add_supervisor(:first_name,:middle_name,:last_name,:date_of_birth,:gender,:email_address,:password,:home_phone,:mobile_phone,:address1,:address2,:city,:state,:country,:postal_code,:organization_id,:organization_branch_id,:add_date,:add_by,:modification_date,:status,:activation_code);";
        $stmt=$db->prepare($query);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':middle_name',$middle_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':date_of_birth',$date_format);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':email_address',$email_address);
        $stmt->bindParam(':password',$hash_password);
        $stmt->bindParam(':home_phone',$home_phone);
        $stmt->bindParam(':mobile_phone',$mobile_phone);
        $stmt->bindParam(':address1',$address1);
        $stmt->bindParam(':address2',$address2);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        $stmt->bindParam(':country',$country);
        $stmt->bindParam(':postal_code',$postal_code);
        $stmt->bindParam(':organization_id',$organization_id);
        $stmt->bindParam(':organization_branch_id',$organization_branch_id);
        $stmt->bindParam(':add_date', $current_date);
        $stmt->bindParam(':add_by', $add_by);
        $stmt->bindParam(':modification_date',$current_date);
        $stmt->bindParam(':status',$status);
        $stmt->bindParam(':activation_code',$activation_code);
        $result = $stmt->execute();
        return $result;
    }
    
}
