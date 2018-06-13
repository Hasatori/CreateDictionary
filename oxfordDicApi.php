<?php
require_once 'backend/Libraries.php';

if(isset($_POST['type'])){
echo processOxfordPost($_POST);
exit();
}
buildHeader("Oxford Dictionaries API");
buildNavBar("Oxford Dictionaries API");
?>

<button class="btn btn-success" onclick="uploadOxfordApiWordLists()">Zkusit</button>
    <div class="form-group">
        <label for="result">Výsledek</label>
        <textarea class="form-control rounded-0" id="result" rows="8"></textarea>
    </div>
<?php
buildFooter();
