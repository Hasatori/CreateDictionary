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

function insertNewVoc($db,$value,$type,$topic,$partOfSpeech,$pronounciation,$explanation,$examples,$synonyms,$english_group,$grammarCategory,$counting){
    $query = $db->prepare("INSERT INTO english (`english_value`,`type`,`topic`,`partOfSpeech`,`pronounciation`,`explanation`,`examples`,`synonyms`,`english_group`,`grammarCategory`,`counting`)"
        . " VALUES(:english_value,:type,:topic,:partOfSpeech,:pronounciation,:explanation,:examples,:synonyms,:english_group,:grammarCategory,:counting)");
    $query->execute([
        ':english_value'=>$value,
        ':type'=>$type,
        ':topic'=>$topic,
        ':partOfSpeech'=>$partOfSpeech,
        ':pronounciation'=>$pronounciation,
        ':explanation'=>$explanation,
        ':examples'=>$examples,
        ':synonyms'=>$synonyms,
        ':english_group'=>$english_group,
        ':grammarCategory'=>$grammarCategory,
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
function getVocabulary($db,$value){

    $query = $db->prepare("SELECT * FROM english where english_value=:val LIMIT 1");
    $query->execute([':val' => $value]);
   return  $query->fetch(PDO::FETCH_ASSOC);

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
        case "en":
            return "english";
        default :
            return false;
    }
}