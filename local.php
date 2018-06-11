<?php
require_once 'backend/Libraries.php';

            if (isset($_POST['category'])&&isset($_POST['separator'])) {
                $category=$_POST['category'];
                $separator= $_POST['separator'];
                echo createFromLocal($category,$separator);
                exit();
            }
            if(isset($_POST['type'])){
                $type=$_POST['type'];
                switch ($type){
                    case "pronounciation":
                        echo uploadPronouncation();

                        break;
                    case "phrasalVerbs":
                        uploadPhrasalVerbs();
                        break;
                }

            exit();
            }

buildHeader("Lokální soubor");
buildNavBar("Lokální soubor");
?>

<div class="row localSection">
    <div class="container">
        <h3>Nahrávání skupiny</h3>
        <label class="btn btn-default">
            Skupina zdroje: <select class='selectpicker' id="categoriesList">
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
    </div>

    <div class="row localSection">
        <div class="container">
            <h3>Nahrávání výslovnosti</h3>
            <button class="btn btn-success" onclick="startUpload('pronounciation')">Začít</button>

            <table class="table table-bordered table-dark">
                <thead>
                <tr>
                    <th scope="col">Slovíčko</th>
                    <th scope="col">Výslovnost</th>

                </tr>
                </thead>
                <tbody id="pronounciationResultTableBody">


                </tbody>
            </table>

        </div>
    </div>

    <div class="row localSection">
        <div class="container">
            <h3>Nahrávání frázových sloves</h3>
            <button class="btn btn-success" onclick="startUpload('phrasalVerbs')">Začít</button>

            <table class="table table-bordered table-dark">
                <thead>
                <tr>
                    <th scope="col">Slovíčko</th>
                    <th scope="col">Výslovnost</th>

                </tr>
                </thead>
                <tbody id="pronounciationResultTableBody">


                </tbody>
            </table>

        </div>
    </div>





<?php
buildFooter();