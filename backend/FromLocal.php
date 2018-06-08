<?php
function createFromLocal($category=null,$separator=null){
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");
        return false;
    }
$files= listDirectory("fromLocalDic/categories/CAE");
    foreach ($files as $fileName){
     echo   $fileName ."<br/>";
    }

    $myfile = fopen(__DIR__."/../sources/fromLocalDic/categories/CAE/".$files[0], "r") or die("Unable to open file!");
// Output one line until end-of-file
    while(!feof($myfile)) {
        echo fgets($myfile) . "<br>";
    }
    fclose($myfile);
}