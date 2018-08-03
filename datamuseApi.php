<?php
require_once 'backend/Libraries.php';

if (isset($_POST['type'])) {
    $type = $_POST['type'];
    switch ($type) {
        case 'getVocabularies':
            datamuseGetVocabularies();
            break;
        case 'uploadVocabularies':
            echo datamuseUploadVocabularies();
            exit();
        case 'uploadSynonyms':
            uploadSynonyms();
            exit();
    }

}


buildHeader("Datamuse API");
buildNavBar("Datamuse API");
?>

    <div class="container">

        <button class="btn btn-success" onclick="datamuseApiAction('uploadVocabularies')">Nahrát slovíčka</button>
        <button class="btn btn-success" onclick="datamuseApiAction('uploadSynonyms')">Nahrát synonyma</button>
        <div class="form-group">
            <label for="result">Výsledek</label>
            <textarea class="form-control rounded-0" id="result" rows="8"></textarea>
        </div>

    </div>

<?php
buildFooter();