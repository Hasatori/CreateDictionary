<?php
require_once 'backend/Libraries.php';

if (isset($_POST['caregory'])) {
    $caregory=$_POST['caregory'];


}



buildHeader("Lokální soubor");
buildNavBar("Lokální soubor");
?>


<div class="container">
    <label class="btn btn-default">
        Kategorie zdroje: <select class='selectpicker' id="categoriesList">
            <option selected>CAE</option>
        </select>
    </label>

        <label class="btn btn-default">
Oddělovací znak:(může být i regulární výraz) <input type="text" id="separator" >
        </label>
                <br/>
<br/>
        <button class="btn btn-success" onclick="startFromLocal()">Začít</button>  <button class="btn btn-danger" onclick="document.location.reload();">Ukončit</button>



        <p  id="test" >
            <?php
           createFromLocal('CAE','\(.*\)');
            ?>

        </p>


    </div>






<?php
buildFooter();