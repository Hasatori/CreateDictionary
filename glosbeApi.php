<?php
require_once 'backend/Libraries.php';
if (isset($_POST['type'])) {
    $type = $_POST['type'];
    switch ($type) {
        case 'parseJson':
           parseJson();
            break;
    }
exit();
}

buildHeader("Glosbe API");
buildNavBar("Glosbe API");

?>

<button class="btn btn-success" onclick="glosbeApiAction('parseJson')">Zkusit</button>
    <div class="form-group">
        <label for="result">Výsledek</label>
        <textarea class="form-control rounded-0" id="result" rows="8"></textarea>
    </div>

<?php
buildFooter();