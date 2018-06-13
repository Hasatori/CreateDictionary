<?php
require_once 'backend/Libraries.php';
if (isset($_POST['start']) && isset($_POST['resultLanguage'])) {
    $resultLanguage = $_POST['resultLanguage'];
    $db = connectToDatabase();

    if ($db == null) {
        echo json_encode(array(false, "Není spojení s databází"));
    }
    $vocabularies = getVocabularies($db, 'english');
    $path = __DIR__ . '/sources/fromExternalResults/' . $resultLanguage . '_result.txt';
    $resultFile = file_put_contents($path, '');
    echo  json_encode($vocabularies);
    exit();
    /*  //var_dump($vocabularies);
      $path = __DIR__.'/sources/fromExternalResults/'.$resultLanguage.'_result.json';
      $resultFile = file_put_contents($path,'[');

      foreach ($vocabularies as $key=>$vocabulary){
          $value = $vocabularies[$key][0];
          @file_put_contents($path,@file_get_contents("https://dictionary.yandex.net/dicservice.json/lookupMultiple?ui=en&srv=tr-text&sid=b85e299c.5b0c66ee.b4b73bca&text=" . $value. "&dict=en-" . $resultLanguage . ".regular&flags=103",true).',',FILE_APPEND);
      }

      $resultFile = file_put_contents($path,']',FILE_APPEND);
      echo 'Překlady do '.$resultLanguage.' provedeny';
      exit();*/
}
if (isset($_POST['result']) && isset($_POST['resultLanguage'])) {
    $resultLanguage = $_POST['resultLanguage'];
    $path = __DIR__ . '/sources/fromExternalResults/' . $resultLanguage . '_result.txt';
    @file_put_contents($path, serialize($_POST['result']).PHP_EOL, FILE_APPEND);
    exit();
}
buildHeader("Yandex API");
buildNavBar("Yandex API");
?>

    <div class="row localSection">
        <div class="container">

            <label class="btn btn-default">
                Překlad do: <select class='selectpicker' id="resultLanguage">
                    <option value="cs">Čeština</option>
                    <option value="de">Němčina</option>
                    <option value="ru">Ruština</option>
                    <option value="sl">Slovenština</option>
                    <option value="es">Španělština</option>

                </select>
            </label>

            <label class="btn btn-default">
                Delay: <input type="number" id="delay" min="50" max="1000" value="50">
            </label>
            <br/>
            <br/>
            <button class="btn btn-success" onclick="startFromExternal()">Začít</button>
            <button class="btn btn-danger" onclick="document.location.reload();">Ukončit</button>
        </div>
    </div>
    <!--<div class="row localSection">
          <div class="container">
              <div class="form-group">
                  <label for="result">Výsledek</label>
                  <textarea class="form-control rounded-0" id="result" rows="8"></textarea>
              </div>

          </div>
      </div>-->

    <div class="row localSection">
        <div class="container">

            <div class="form-group">
                <label for="result">Aktuální slovíčko</label>
                <input type="text" value="" id="result" class="form-control" readonly>

            </div>
        </div>
    </div>

<?php
buildeProgressBar();
buildFooter();

