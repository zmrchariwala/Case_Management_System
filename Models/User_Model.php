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
    function Login_Process($email_address,$password){
        $db = Database::getDb();
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
                    return 'Active';
                    exit();
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
    function Send_Mail($user_email,$message,$subject)
    {
        require 'phpmailer/vendor/autoload.php';
        $mail= new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug  = 3;
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
}
