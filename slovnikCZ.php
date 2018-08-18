<?php
require_once 'backend/Libraries.php';
if (isset($_POST['type'])) {
    $type = $_POST['type'];
    switch ($type) {
        case 'getSlovnikCZTranslations':
           getSlovnikCZTranslations();
            break;
    }
    exit();
}


buildHeader("Slovník.cz");
buildNavBar("Slovník.cz");





?>
<button class="btn btn-success" onclick="slovnikCZAction('getSlovnikCZTranslations')">Zkusit</button>
    <div class="form-group">
        <label for="result">Výsledek</label>
        <textarea class="form-control rounded-0" id="result" rows="20"></textarea>
    </div>










<?php
buildFooter();