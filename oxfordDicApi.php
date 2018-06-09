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
<p id="result"></p>
<?php
buildFooter();
