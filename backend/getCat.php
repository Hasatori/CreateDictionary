<?php
    if(isset($_GET['sort'])){
     $sort = $_GET['sort'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
    
     require_once "Libraries.php";
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    if($sort==="true"){
    $query = $db->prepare("SELECT distinct(topic) FROM vocabulary_english where topic not like '' order by topic ASC");
    }                                                                                                                      else{
    $query = $db->prepare("SELECT distinct(topic) FROM vocabulary_english where topic not like '' ");
    }
    
    $query->execute();
    echo json_encode($query->fetchAll());
    }