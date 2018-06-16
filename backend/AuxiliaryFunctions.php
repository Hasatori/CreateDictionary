<?php
function listDirectory(string $dir)
{

    $result = array();

    $cdir = scandir(__DIR__ . '/../sources/' . $dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}


function vocExists(PDO $db, string $val = null)
{

    $query = $db->prepare("SELECT * FROM vocabulary_english where english_value=:val LIMIT 1");
    $query->execute([':val' => $val]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return count($result) === 1 ? true : false;
}

function insertNewVoc(PDO $db, string $language, string $value, string $translationValue = null, string $type = null, string $topic = null, string $gender = null,
                      string $partOfSpeech = null, string $pronunciation = null, string $explanation = null,
                      string $examples = null, string $groupName = null, string $grammarCategory = null, string $counting = null, string $frequency = null, string $origin = null)
{
    if ($language === 'english') {
        $query = $db->prepare("INSERT INTO vocabulary_english (english_value,type, topic,english_gender, english_part_of_speech, english_pronunciation, english_explanation, english_examples, group_name, grammar_category, english_counting, frequency,origin)"
            . " VALUES(:value,:type,:topic,:gender,:partOfSpeech,:pronunciation,:explanation,:examples,:groupName,:grammarCategory,:counting,:frequency,:origin)");
        $query->execute([
            ':value' => $value,
            ':type' => $type,
            ':topic' => $topic,
            ':gender' => $gender,
            ':partOfSpeech' => $partOfSpeech,
            ':pronunciation' => $pronunciation,
            ':explanation' => $explanation,
            ':examples' => $examples,
            ':groupName' => $groupName,
            ':grammarCategory' => $grammarCategory,
            ':counting' => $counting,
            ':frequency' => $frequency,
            ':origin' => $origin
        ]);
    } else {
        $tableName = 'vocabulary_' . $language;
        $translationColumn = $language . '_value';
        $genderColumn = $language . '_gender';
        $partOfSpeechColumn = $language . '_part_of_speech';
        $explanationColumn = $language . '_explanation';
        $examplesColumn = $language . '_examples';
        $query = $db->prepare("INSERT INTO $tableName (
                    english_value,
                    $translationColumn,
                    $genderColumn,
                    $partOfSpeechColumn,
                    $explanationColumn,
                    $examplesColumn
                    )
                    VALUES(
                    :english_value,
                    :value,
                    :gender,
                    :partOfSpeech,
                    :explanation,
                    :examples)
                    ");
        $query->execute([
            ':english_value' => $value,
            ':value' => $translationValue,
            ':gender' => $gender,
            ':partOfSpeech' => $partOfSpeech,
            ':explanation' => $explanation,
            ':examples' => $examples
        ]);
    }
}

function insertNewSynonym(PDO $db, string $language, $value, $synonym, $gender, $partOfSpeech)
{
    $tableName = 'vocabulary_' . $language . '_synonyms';
    $valueColumn = $language . '_value';
    $genderColumn = $language . '_gender';
    $partOfSpeechColumn = $language . '_part_of_speech';

    $query = $db->prepare("INSERT INTO $tableName (
                   $valueColumn,
                    synonym,
                    $genderColumn,
                    $partOfSpeechColumn
                    )
                    VALUES(
                    :value,
                    :synonym,
                    :gender,
                    :partOfSpeech
                    )");

    $query->execute([
        ':value' => $value,
        ':synonym' => $synonym,
        ':gender' => $gender,
        ':partOfSpeech' => $partOfSpeech
    ]);
}


function updateExisting(PDO $db, string $language, string $value, string $type, string $topic, string $gender,
                        string $partOfSpeech, string $pronunciation, string $explanation,
                        string $examples, string $synonyms, string $groupName, string $grammarCategory, string $counting, string $frequency, string $origin)
{
    if ($language === 'english') {
        $query = $db->prepare("UPDATE vocabulary_english SET 
                         type=:type,
                         topic=:topic,
                         gender=:gender,
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
            ':gender' => $gender,
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
    } else {


    }
}

function insertExistingVoc(PDO $db, string $language, string $englishValue, string $targetValue, string $partOfSpeech, string $synonyms)
{
    $columnName = $language . '_value';
    $query = $db->prepare("INSERT INTO $language (`english_value`,`$columnName`"
        . ",`partOfSpeech`,`synonyms`)"
        . " VALUES(:enVal,:targetValue,:partOfSpeech,:synonyms)");
    $query->execute([
        ':enVal' => $englishValue
        , ':targetValue' => $targetValue
        , ':partOfSpeech' => $partOfSpeech
        , ':synonyms' => $synonyms

    ]);
}

function getVocabulary(PDO $db, string $value)
{

    $query = $db->prepare("SELECT * FROM vocabulary_english where english_value=:val LIMIT 1");
    $query->execute([':val' => $value]);
    return $query->fetch(PDO::FETCH_ASSOC);

}


function checkLanguage(bool $language)
{
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

function getFullLanguageFromAbr(string $language)
{
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

function getFullPartOfSpeech(string $abbraviation)
{
    switch ($abbraviation) {
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

function getPartsOfSpeechAbbreviations()
{
    return array('n', 'v', 'adj', 'adv', 'pron', 'prep', 'conj', 'interj');
}

function getVocabularies(PDO $db, string $language)
{
    $tableName = 'vocabulary_' . $language;
    $columnName = $language . '_value';

    $query = $db->prepare("SELECT $columnName FROM $tableName");
    $query->execute();
    return $query->fetchAll();

}

function getGenderTranlation(string $gender = null, string $resultLanguage = null)
{
    switch ($resultLanguage) {
        case 'cs':
            switch ($gender) {
                case 'masculine':
                    return 'mužský';
                case 'feminine':
                    return 'ženský';
                case 'neuter':
                    return 'střední';
            }
            break;
        case 'de':
            switch ($gender) {
                case 'masculine':
                    return 'masculine';
                case 'feminine':
                    return 'feminine';
                case 'neuter':
                    return 'neuter';
            }
            break;
        case 'ru':
        switch ($gender) {
            case 'masculine':
                return 'мужской';
            case 'feminine':
                return 'женский';
            case 'neuter':
                return 'среднего рода';
        }
        break;
        case 'es':
            switch ($gender) {
                case 'masculine':
                    return 'masculino';
                case 'feminine':
                    return 'feminino';
                case 'neuter':
                    return 'neutro';
                case 'common':
                    return 'común';
                case 'epicene':
                    return 'epiceno';
                case 'ambiguous':
                    return 'ambiguo';
            }
            break;

    }

}

function getPartOfSpeechTranslation(string $partOfSpeech = null, string $resultLanguage = null)
{
    switch ($resultLanguage) {
        case 'cs':
            switch ($partOfSpeech) {
                case 'noun':
                    return 'podstatné jméno';
                case 'adjective':
                    return 'přídavné jméno';
                case 'adverb':
                    return 'příslovce';
                case 'pronoun':
                    return 'zájmeno';
                case 'preposition':
                    return 'předložka';
                case 'conjunction':
                    return 'spojka';
                case 'interjection':
                    return 'citoslovce';
            }
            break;
        case 'de':
            switch ($partOfSpeech) {
                case 'noun':
                    return 'nomen';
                case 'verb':
                    return 'verben';
                case 'article':
                    return 'artikel';
                case 'adjective':
                    return 'adjektive';
                case 'pronoun':
                    return 'pronomen';
                case 'adverb':
                    return 'adverbien';
                case 'preposition':
                    return 'wechselpräpositionen';
                case 'numeral':
                    return 'zahlwörter';
                case 'proper noun':
                    return 'eigennamen';
            }
            break;
        case 'ru':
            switch ($partOfSpeech) {
                case 'noun':
                    return 'Существительные';
                case 'adjective':
                    return 'Прилагательные';
                case 'adverb':
                    return 'Наречие';
                case 'pronoun':
                    return 'Местоимения';
                case 'numeral':
                    return 'Числительные';
                case 'verb':
                    return 'Глаголы';
                case 'preposition':
                    return 'Предлоги';
                case 'conjunction':
                    return 'Союзы';
            }
            break;
        case 'es':
            switch ($partOfSpeech) {
                case 'noun':
                    return 'sustantivo';
                case 'adjective':
                    return 'adjetivos';
                case 'adverb':
                    return 'adverbios';
                case 'pronoun':
                    return 'pronombres';
                case 'numeral':
                    return 'número';
                case 'verb':
                    return 'verbos';
                case 'preposition':
                    return 'preposiciones';
                case 'conjunction':
                    return 'conjunciones';
                case 'interjection':
                    return 'interjecciones';

            }
            break;

    }

}