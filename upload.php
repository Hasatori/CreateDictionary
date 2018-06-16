<?php
require_once 'backend/Libraries.php';

if (isset($_POST['sourceFile'])) {
   echo  uploadTranslation($_POST["sourceFile"]);
    exit();
}

buildHeader("Nahrávání slovníků");
buildNavBar("Nahrávání slovníků");
?>
    <div class="row localSection">
        <div class="container">
            <label class="btn btn-default">
                Soubor pro nahrání: <select class='selectpicker' id="sourceFile">
                    <?php
                    $sources = listDirectory('fromExternalResults');
                    foreach ($sources as $source) {
                        echo '<option>' . $source . '<option/>';
                    }
                    ?>

                </select>
            </label>
            <button class="btn btn-success" onclick="uploadExternalResults()">Nahrát do databáze</button>

        </div>
    </div>
    <div class="row localSection">
        <div class="container">
            <div class="form-group">
                <label for="result">Výsledek</label>
                <textarea class="form-control rounded-0" id="result" rows="8"></textarea>
            </div>

        </div>
    </div>
<?php
buildFooter();