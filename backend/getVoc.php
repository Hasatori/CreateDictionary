<?php
if(isset($_GET['category'])){
$category=$_GET['category'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
    require_once "Libraries.php";
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

       echo false;
    }
     
    $query = $db->prepare("SELECT english_value FROM vocabulary_english where topic='$category'");
    $query->execute();
    echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
}
    
