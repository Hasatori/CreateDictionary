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
    where english_value=:englishValue");
    $query->execute([':englishValue' => $englishValue]);
    $translations = $query->fetchAll();
    //var_dump($translations);
    $synonyms = array();
    foreach ($translations as $translation) {
        $synonyms = array_merge($synonyms, getSynonyms($db, $toLanguage, $translation[$toLanguage . "_value"]));

    }
    return array($translations[0][$toLanguage . "_value"], $synonyms, getOtherTranslations($db, $fromLanguage, $toLanguage, $translations[0][$toLanguage . "_value"]));
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
    $columnName = $language . '_value';
    $query = $db->prepare("SELECT * FROM $tableName where $columnName=:value ");
    $query->execute([':value' => $value]);
    return $query->fetchAll(PDO::FETCH_ASSOC);

}

function getOtherTranslations(PDO $db, string $fromLanguage, string $toLanguage, $value)
{
    $valueColumn = $fromLanguage . "_value";
    $tableName = 'vocabulary_' . $toLanguage;
    $columnName = $toLanguage . '_value';

    $query = $db->prepare("SELECT $valueColumn FROM $tableName where $columnName=:value ");
    $query->execute([':value' => $value]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}














