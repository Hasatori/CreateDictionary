<?php
require_once 'backend/Libraries.php';

if(isset($_POST['type'])){
    $type=$_POST['type'];
    switch ($type){
        case 'getVocabularies':
            datamuseGetVocabularies();
            break;
        case 'uploadVocabularies':
            datamuseUploadVocabularies();
            break;

    }

}


buildHeader("Datamuse API");
buildNavBar("Datamuse API");
?>

<div class="container">

    <button class="btn btn-success" onclick="datamuseApiAction('uploadVocabularies')">Nahrát data</button>

    </div>
</div>
<?php
buildFooter();