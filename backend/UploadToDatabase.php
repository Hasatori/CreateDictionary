<?php

function uploadDictionaryToDatabase($file,$language) {
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    $row = 0;
    if (($handle = fopen(__DIR__ .'/../sources/' . $file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, "#")) !== FALSE) {
            if($row == 0){ $row++; continue; }
          try {
                if (vocExists($db, $data[0])) {
                    insertExistingVoc($db
                            ,getTableNameFromLanguageAbr($language)
                            ,$data[0]
                            ,$data[1]
                            ,$data[2]
                            ,$data[3]);
                }else{
                    $db ->beginTransaction();
                    insertNewVoc($db
                            ,$data[0]
                            ,$data[2]
                            );
                            insertExistingVoc($db
                            ,getTableNameFromLanguageAbr($language)
                            ,$data[0]
                            ,$data[1]
                            ,$data[2]
                            ,$data[3]);
                    if(!$db ->commit()){
                        $db ->rollBack();
                    }
                    
                }
                }
        catch( PDOException $Exception) {
                    var_dump($data);
            }
                $row++;
            
        }
        fclose($handle);
    }
}

function vocExists($db, $val) {

    $query = $db->prepare("SELECT * FROM english where english_value=:val");
    $query->execute([':val' => $val]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return count($result) === 1 ? true : false;
}

function insertNewVoc($db,$englishValue,$partOfSpeech) {
     $query = $db->prepare("INSERT INTO english (`english_value`"
            .               ",`partOfSpeech`)"
                        . " VALUES(:enVal,:partOfSpeech)"); 
              $query->execute([
                          ':enVal' => $englishValue
                         ,':partOfSpeech' => $partOfSpeech
                        
                        ]);
}

function insertExistingVoc($db,$language,$englishValue,$targetValue,$partOfSpeech,$synonyms) {
    $columnName=$language.'_value';
    $query = $db->prepare("INSERT INTO $language (`english_value`,`$columnName`"
            .               ",`partOfSpeech`,`synonyms`)"
                        . " VALUES(:enVal,:targetValue,:partOfSpeech,:synonyms)");
                $query->execute([
                          ':enVal' => $englishValue
                         ,':targetValue' => $targetValue
                         ,':partOfSpeech' => $partOfSpeech
                         ,':synonyms' => $synonyms
                        
                        ]);
}

function checkLanguage($language) {
    switch ($language) {
        case "cs":
            return true;
        case "sk":
            return true;
        case "de":
            return true;
        case "ru":
            return true;
        case "es":
            return true;

        default :
            return false;
    }
}

function getTableNameFromLanguageAbr($language){
        switch ($language) {
        case "cs":
            return "czech";
        case "sk":
            return "slovak";
        case "de":
            return "german";
        case "ru":
            return "russian";
        case "es":
            return "spanish";

        default :
            return false;
    }
}
