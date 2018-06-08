<?php
require_once 'backend/Libraries.php';
if (isset($_POST['startFromExternal']) && isset($_POST['resultFile']) && isset($_POST['sourceFile'])) {
    $sourceFile = $_POST['sourceFile'];
    $resultFile = $_POST['resultFile'];
    if ($sourceFile == '') {
        $error = json_encode(array(false, "Chybí zdrojový soubor"));
        echo $error;
        exit();
    } else if ($resultFile == '') {
        $error = json_encode(array(false, "Chybí cílový soubor"));
        echo $error;
        exit();
    } else if ($_POST['startFromExternal'] == true) {
        $fp = fopen(__DIR__ . '/sources/fromExternalDic/' . $resultFile, 'w');
        $row = array('First_value', 'Second_value', 'Part_of_Speech', 'Synonyms');
        fputcsv($fp, $row, '#');
        fclose($fp);
        $success = json_encode(true);
        echo $success;
        exit();
    }
}

if (isset($_POST['result']) && isset($_POST['resultFile'])) {
    $resultFile = $_POST['resultFile'];
    $result = $_POST['result'];
    
    if ($resultFile == '') {
        $_SESSION['error'] = "Chybí cílový soubor";
        header("location:BASE");
        exit();
    } else {
        $fp = fopen(__DIR__ . '/sources/fromExternalDic/' . $resultFile, 'a');
            fputcsv($fp, $result, '#');
  fclose($fp);
        exit();
    }
}
if(isset($_POST['loadFile'])&& isset($_POST['firstLanguage'])&&isset($_POST['secondLanguage'])){
   $loadFile = $_POST['loadFile'];
    if ($loadFile == '') {
        $_SESSION['error'] = "Chybí soubor k nahrání";
        header("location:".BASE);
        exit();
    } else {
    
    }
} 
buildHeader("Externí služba");
buildNavBar("Externí služba");
?>
  
   
    <div class="container">
        <label class="btn btn-default">
            Zdroj: <input type="file" hidden id="sourceFile" >
        </label>
        <label class="btn btn-default">
            Jazyk zdroje: <select class='selectpicker'>
               <?php
               $list= listDirectory('fromExternalDic');
               foreach ($list as $fileName){
                   echo '<option>'.$fileName.'</option>';
               }

                   ?>

            </select>
        </label>
        <label class="btn btn-default">
            Uložit do souboru: <input type="file" hidden id="resultFile" >
        </label>
        <label class="btn btn-default">
            Jazyk zdroje: <select class='selectpicker' id="sourceLanguage">
                <option selected>en</option>

            </select>
        </label>
        <label class="btn btn-default">
            Překlad do: <select class='selectpicker' id="resultLanguage">


            </select>
        </label>

        <label class="btn btn-default">
            Delay: <input type="number" id="delay" min="50" max="1000" value="50">
        </label>
                <br/>
<br/>
        <button class="btn btn-success" onclick="startFromExternal()">Začít</button>  <button class="btn btn-danger" onclick="document.location.reload();">Ukončit</button>
    </div>
<?php
    buildeProgressBar();
    buildFooter();

