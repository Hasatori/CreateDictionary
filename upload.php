<?php
require_once 'backend/Libraries.php';
if(isset($_POST['uploadFile'])){
     $uploadFile = $_POST['uploadFile'];
   
 if ($uploadFile == '') {
        $_SESSION['error'] = "Chybí cílový soubor";
        header("location:".BASE."upload.php");
        exit();
    }else if(!checkLanguage(explode("_",$uploadFile)[1])){
            $_SESSION['error'] = "Špatný jazyk";
        header("location:".BASE."upload.php");
        exit();  
    }
    else {
        $language=explode("_",$uploadFile)[1];
        uploadDictionaryToDatabase($uploadFile,$language);
    }
}

buildHeader("Nahrávání slovníků");
buildNavBar("Nahrávání slovníků");
?> 

<div class="container">
               <label class="btn btn-default">
           Soubor pro nahrání: <input type="file" hidden id="uploadFile">
        </label>
            <button class="btn btn-success" onclick="loadToDatabase()">Nahrát do databáze</button> 
            
        </div>
<?php

buildeProgressBar();





buildFooter();