<?php

function translate(string $fromLanguage,string $toLanguage,string $firstValue){
    $db = connectToDatabase();

    if ( $db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
  /**  if(!vocExists(PDO $db,$firstValue)){
        $_SESSION['error'] = array(true, "Toto slovíčko neznáme");
        return false;
    }*/
    $fromTable=getFullLanguageFromAbr($fromLanguage);
    $fromColumnName=$fromTable.'_value';
    $toTable=getFullLanguageFromAbr($toLanguage);
    $toColumnName=$toTable.'_value';
    $englishValue= getEnglishValue( $db,$fromTable,$fromColumnName,$firstValue);

    $query = $db->prepare("SELECT $toColumnName,$toTable.synonyms FROM $fromTable join $toTable using(english_value)
    where english_value=:englishValue LIMIT 1");
    $query->execute([':englishValue' => $englishValue]);
    $result = $query->fetch();
    return $result;

}

function getEnglishValue(PDO $db,string $fromTable,string $fromColumnName,string $firstValue){
    $query = $db->prepare("SELECT english_value FROM $fromTable where $fromColumnName=:firstValue LIMIT 1");
    $query->execute([':firstValue' => $firstValue]);
    return $query->fetch()[0];

}
















