<?php
function uploadTranslation(string $sourceFile)
{
    $db = connectToDatabase();
    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");
        return false;
    }
    ini_set('memory_limit', '-1');
    $language = explode("_", $sourceFile)[0];
    $jsonFileContent = json_decode(file_get_contents(__DIR__ . '/../sources/fromExternalResults/' . $sourceFile), true);

    $db->beginTransaction();

    foreach ($jsonFileContent as $item) {
        try {
            //if ($count < $limit) {
                $regular = $item['en-' . $language]['regular'];

                foreach ($regular as $word) {
                    $pronounciation = '[' . @$word['ts'] . ']';
                    //echo ' || Originál: ' . $word['text'] . $pronounciation;

                    $translation = $word['tr'][0]['text'];
                    $partOfSpeech = @getPartOfSpeechTranslation($word['tr'][0]['pos']['tooltip'], $language);
                    $gender = @getGenderTranlation($word['gen']['tooltip'], $language);
                    insertNewVoc($db, getFullLanguageFromAbr($language), $word['text'],
                        $translation, '', '', $gender, $partOfSpeech);

                    //  echo ' || Překlad: ' . $translation . $partOfSpeech . ' ';
                    $synonyms = @$word['tr'][0]['syn'];
                    if ($synonyms !== null) {
                        // echo ' || Příbuzná slova a synonyma: ';
                        foreach ($synonyms as $synonym) {
                            $gender = @getGenderTranlation($synonym['gen']['tooltip'], $language);
                            $partOfSpeech = @getPartOfSpeechTranslation($synonym['pos']['tooltip'], $language);
                            //  echo $synonym['text'] . $gender . ' ' . $partOfSpeech;
                            insertNewSynonym($db, getFullLanguageFromAbr($language), $translation, $synonym['text'], $gender, $partOfSpeech);
                        }
                    }

                }
                // echo PHP_EOL;
                //$count++;
            //}else {

           // }
        } catch (PDOException $message) {
            $mesaggeType=$message->errorInfo[1];
            if ( $mesaggeType== 1452 || $mesaggeType == 1062 ) {
                continue;
            } else {
                $db->rollBack();
                return PHP_EOL . $message . PHP_EOL;
            }
        }

    }
    if ($db->commit() === false) {
        $db->rollBack();
        return PHP_EOL . "Vložení hodnot se nezdařilo." . PHP_EOL;
    }
    return PHP_EOL . "Hodnoty úspěšně vloženy." . PHP_EOL;
}

