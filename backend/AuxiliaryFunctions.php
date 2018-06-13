<?php
function listDirectory(string $dir) {

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


function vocExists(PDO $db,string  $val=null) {

    $query = $db->prepare("SELECT * FROM vocabulary_english where english_value=:val LIMIT 1");
    $query->execute([':val' => $val]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return count($result) === 1 ? true : false;
}

function insertNewVoc(PDO $db,string $language,string $value,string $type,string $topic,
                      string $partOfSpeech,string $pronunciation,string $explanation,
                      string $examples,string $synonyms,string $groupName,string $grammarCategory,string $counting,string $frequency,string $origin){
    if($language==='english') {
        $query = $db->prepare("INSERT INTO vocabulary_english (english_value,type, topic, english_part_of_speech, english_pronunciation, english_explanation, english_examples, english_synonyms, group_name, grammar_category, english_counting, frequency,origin)"
            . " VALUES(:value,:type,:topic,:partOfSpeech,:pronunciation,:explanation,:examples,:synonyms,:groupName,:grammarCategory,:counting,:frequency,:origin)");
        $query->execute([
            ':value' => $value,
            ':type' => $type,
            ':topic' => $topic,
            ':partOfSpeech' => $partOfSpeech,
            ':pronunciation' => $pronunciation,
            ':explanation' => $explanation,
            ':examples' => $examples,
            ':synonyms' => $synonyms,
            ':groupName' => $groupName,
            ':grammarCategory' => $grammarCategory,
            ':counting' => $counting,
            ':frequency' => $frequency,
            ':origin' => $origin
        ]);
    }else{


    }
}
function updateExisting(PDO $db,string $language,string $value,string $type,string $topic,
                        string $partOfSpeech,string $pronunciation,string $explanation,
                        string $examples,string $synonyms,string $groupName,string $grammarCategory,string $counting,string $frequency,string $origin){
    if($language==='english') {
    $query = $db->prepare("UPDATE vocabulary_english SET 
                         type=:type,
                         topic=:topic,
                         english_part_of_speech=:partOfSpeech,
                         english_pronunciation=:pronunciation,
                         english_explanation=:explanation,
                         english_examples=:examples,
                         english_synonyms=:synonyms,
                         group_name=:groupName,
                         grammar_category=:grammarCategory,
                         english_counting=:counting,
                         frequency=:frequency,
                         origin=:origin
                        WHERE english_value=:value");

        $query->execute([
            ':value' => $value,
            ':type' => $type,
            ':topic' => $topic,
            ':partOfSpeech' => $partOfSpeech,
            ':pronunciation' => $pronunciation,
            ':explanation' => $explanation,
            ':examples' => $examples,
            ':synonyms' => $synonyms,
            ':groupName' => $groupName,
            ':grammarCategory' => $grammarCategory,
            ':counting' => $counting,
            ':frequency' => $frequency,
            ':origin' => $origin
        ]);
    }else{


    }

}
function insertExistingVoc(PDO $db,string $language,string $englishValue,string $targetValue,string $partOfSpeech,string $synonyms) {
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
function getVocabulary(PDO $db,string $value){

    $query = $db->prepare("SELECT * FROM vocabulary_english where english_value=:val LIMIT 1");
    $query->execute([':val' => $value]);
   return  $query->fetch(PDO::FETCH_ASSOC);

}


function checkLanguage(bool $language) {
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

function getTableNameFromLanguageAbr(string $language){
    switch ($language) {
        case "cs":
            return "vocabulary_czech";
        case "sk":
            return "vocabulary_slovak";
        case "de":
            return "vocabulary_german";
        case "ru":
            return "vocabulary_russian";
        case "es":
            return "vocabulary_spanish";
        case "en":
            return "vocabulary_english";
        default :
            return  false;
    }
}

function getFullPartOfSpeech(string $abbraviation){
    switch ($abbraviation){
        case "n":
            return "noun";
        case "v":
            return 'verb';
        case "adj":
            return "adjective";
        case "adv":
            return "adverb";
        case "pron":
            return "pronoun";
        case "prep":
            return "preposition";
        case "conj":
            return "conjunction";
        case "interj":
            return "interjection";
    }
}

function getPartsOfSpeechAbbreviations(){
    return array('n','v','adj','adv','pron','prep','conj','interj');
}

function getVocabularies(PDO $db,string $language){
    $tableName='vocabulary_'.$language;
    $columnName=$language.'_value';

    $query = $db->prepare("SELECT $columnName FROM $tableName");
    $query->execute();
    return $query->fetchAll();

}