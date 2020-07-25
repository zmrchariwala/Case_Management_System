<?php
    require_once '../../Models/User_Model.php';
    require_once '../../Database/Database.php';
    
    $db = Database::getDb();
    $user = new User_Models();
    $organization_id = $_GET['organization'];
    $results = $user->Fetch_Branches($organization_id);
    
    $jsonoff =  json_encode($results);

    header('Content-Type: application/json');


    echo  $jsonoff;

