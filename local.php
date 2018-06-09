<?php
require_once 'backend/Libraries.php';

            if (isset($_POST['category'])&&isset($_POST['separator'])) {
                $category=$_POST['category'];
                $separator= $_POST['separator'];
                echo createFromLocal($category,$separator);
                exit();
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
Oddělovací znak:(může být i regulární výraz) <input type="text" id="separator" value="\(.*\)" >
        </label>
                <br/>
<br/>
        <button class="btn btn-success" onclick="startFromLocal()">Začít</button>  <button class="btn btn-danger" onclick="document.location.reload();">Ukončit</button>



    <table class="table table-bordered table-dark">
        <thead>
        <tr>
            <th scope="col">Hodnota</th>
            <th scope="col">Vysvětlení</th>
            <th scope="col">Počitatelnost</th>
            <th scope="col">Slovní druh</th>
            <th scope="col">Typ</th>
        </tr>
        </thead>
        <tbody id="resultTableBody">


        </tbody>
    </table>


    </div>






<?php
buildFooter();