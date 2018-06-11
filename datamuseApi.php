<?php
require_once 'backend/Libraries.php';

if(isset($_POST['type'])){
    $type=$_POST['type'];
    switch ($type){
        case'getVocabularies':
            datamuesGetVocabularies();
            break;


    }

}


buildHeader("Datamuse API");
buildNavBar("Datamuse API");
?>

<div class="container">

    <button class="btn btn-success" onclick="loadDatamuseUrl('getVocabularies')">Získat data</button>

    <div class="form-group">
        <label for="datamuseResult">Small textarea</label>
        <textarea class="form-control rounded-0" id="datamuseResult" rows="3"></textarea>
    </div>
</div>
<?php
buildFooter();