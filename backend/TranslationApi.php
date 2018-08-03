<?php

function translate(string $fromLanguage, string $toLanguage, string $firstValue)
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    /**  if(!vocExists(PDO $db,$firstValue)){
     * $_SESSION['error'] = array(true, "Toto slovíčko neznáme");
     * return false;
     * }*/
    $fromLanguage = getFullLanguageFromAbr($fromLanguage);
    $toLanguage = getFullLanguageFromAbr($toLanguage);
    $fromTable = 'vocabulary_' . $fromLanguage;
        $fromColumnName = $fromLanguage . '_value';
    $toTable = 'vocabulary_' . $toLanguage;
        $toColumnName = $toLanguage . '_value';
    $englishValue = getEnglishValue($db, $fromTable, $fromColumnName, $firstValue);

    $query = $db->prepare("SELECT $toColumnName FROM $fromTable join $toTable using(english_value)
    where english_value=:englishValue LIMIT 1");
    $query->execute([':englishValue' => $englishValue]);
    $translation = $query->fetch()[0];
    $synonyms = getSynonyms($db, $toLanguage, $translation);
    return array($translation, $synonyms);

}

function getEnglishValue(PDO $db, string $fromTable, string $fromColumnName, string $firstValue)
{
    $query = $db->prepare("SELECT english_value FROM $fromTable where $fromColumnName=:firstValue LIMIT 1");
    $query->execute([':firstValue' => $firstValue]);
    return $query->fetch()[0];

}

function getSynonyms(PDO $db, string $language, $value)
{
    $tableName = 'vocabulary_' . $language . '_synonyms';
    $columnName = $language.'_value';
    $query = $db->prepare("SELECT * FROM $tableName where $columnName=:value ");
    $query->execute([':value' => $value]);
    return $query->fetchAll(PDO::FETCH_ASSOC);

}














