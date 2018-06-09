<?php
function listDirectory($dir) {

    $result = array();

    $cdir = scandir(__DIR__.'/../sources/'.$dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }

    return $result;
}


function vocExists($db, $val) {

    $query = $db->prepare("SELECT * FROM english where english_value=:val");
    $query->execute([':val' => $val]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return count($result) === 1 ? true : false;
}

function insertNewVoc($db,$englishValue,$partOfSpeech,$type='word',$topic=null,$pronounction=null,$explanation=null,$category=null,$counting=null) {
    $query = $db->prepare("INSERT INTO english (`english_value`,`type`,`topic`,`partOfSpeech`,`pronounciation`,`explanation`,`category`,`counting`)"
        . " VALUES(:english_value,:type,:topic,:partOfSpeech,:pronounciation,:explanation,:category,:counting)");
    $query->execute([
        ':english_value'=>$englishValue,
        ':type'=>$type,
        ':topic'=>$topic,
        ':partOfSpeech'=>$partOfSpeech,
        ':pronounciation'=>$pronounction,
        ':explanation'=>$explanation,
        ':category'=>$category,
        ':counting'=>$counting

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