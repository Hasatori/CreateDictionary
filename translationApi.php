<?php
require_once 'backend/Libraries.php';

if(isset($_POST['fromLanguage'])&& isset($_POST['toLanguage'])&&isset($_POST['firstValue'])){
    $fL=$_POST['fromLanguage'];
    $tL=$_POST['toLanguage'];
    $fV=$_POST['firstValue'];
    $result =translate($fL,$tL,$fV);
}else{
    $fL='en';
    $tL='cs';
    $synonyms=null;
}


buildHeader("Překladač API");
buildNavBar("Překladač API");
?>
<form method="post">
    <div class="container">
        <div class="col-sm-2"></div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="fromLanguage">Z jazyka:</label>
                <select class="form-control" id="fromLanguage" name="fromLanguage">
                    <option value="en" <?php echo $fL==='en'? 'selected':''?>>Angličtina</option>
                    <option value="cs" <?php echo $fL==='cs'? 'selected':''?>>Čeština</option>
                    <option value="de" <?php echo $fL==='de'? 'selected':''?>>Němčina</option>
                    <option value="es" <?php echo $fL==='es'? 'selected':''?>>Španělština</option>
                    <option value="ru" <?php echo $fL==='ru'? 'selected':''?>>Ruština</option>
                </select>
            </div>
            <div class="form-group">
                <label for="firstValue">Slovíčko k přeložení:</label>
                <input type="text" class="form-control" id="firstValue" name="firstValue" required value="<?= @$_POST['firstValue'] ?>">

            </div>
        </div>

        <div class="col-sm-4">

            <div class="form-group">
                <label for="toLanguage">Do jazyka:</label>
                <select class="form-control" id="toLanguage" name="toLanguage">
                    <option value="cs" <?php echo $tL==='cs'? 'selected':''?>>Čeština</option>
                    <option value="en" <?php echo $tL==='en'? 'selected':''?>>Angličtina</option>
                    <option value="de" <?php echo $tL==='de'? 'selected':''?>>Němčina</option>
                    <option value="es" <?php echo $tL==='es'? 'selected':''?>>Španělština</option>
                    <option value="ru" <?php echo $tL==='ru'? 'selected':''?>>Ruština</option>
                </select>
            </div>


        </div>

        <div class="col-sm-2"></div>
        <button type="submit" class="btn btn-success">Přeložit</button>
    </div>
</form>
<br/>
    <br/>
    <br/>
    <div class="container translationResultContainer">
        <h4 class="text-left">Překlad</h4>
        <p  id="translation" class="text-info text-left" >
            <?php
            if (isset($result))
            echo trim($result[0]);
            ?>

        </p>
        <h4  class="text-left">Synonyma a příbuzná slova</h4>
        <p  id="synonyms" class="text-info text-left" >
            <?php
            if (isset($result))
             $synonyms = $result[1];
            foreach ($synonyms as $synonym){
                $language = getFullLanguageFromAbr($tL);
                echo $synonym['synonym'].' '.$synonym[$language.'_gender'].' '.$synonym[$language.'_part_of_speech'].'</br>';
            }
            ?>


        </p>
    </div>
<?php
buildFooter();
