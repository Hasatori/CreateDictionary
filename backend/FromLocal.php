<?php
function uploadGroup(string $english_group = null, string $separator = null)
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    $files = listDirectory("fromLocalDic/categories/" . $english_group);
    $firstArray = array();
    $partOfSpeech = array();
    $type = array();
    $counting = array();
    $secondArray = array();
    $partsOfSpeech = array(" n ", " np ", " v ", " vp ", " adj ", ' adjp ', " adv ", " advp ", ' pp ');
    $db->beginTransaction();
    try {
    foreach ($files as $fileName) {
        //  $result=$result.PHP_EOL. '####################  START  ####################'.PHP_EOL;
        $myfile = fopen(__DIR__ . "/../sources/fromLocalDic/categories/CAE/" . $fileName, "r") or die("Unable to open file!");

        $count = 0;

        while (!feof($myfile)) {

            if ($count > 6) {
                $line = fgets($myfile);
                if (strpos($line, 'Complete CAE') !== false) {
                    continue;
                }
                $words = preg_split('/' . $separator . '/', $line);
                if (count($words) > 1) {
                    preg_match('/\[.*\]/', $words[0], $countingType);
                    preg_match('/( n )|( np )|( v )|( vp )|( adj )|( adjp )|( adv )|( advp )|( pp )/', $words[0], $partOfSpeechAndType);
                    $countingVal = getcountingType(@$countingType[0]);
                    $partOfSpeechVal = getTypeAndPartOfSpeech(@$partOfSpeechAndType[0])[1];
                    $typeVal = getTypeAndPartOfSpeech(@$partOfSpeechAndType[0])[0];
                    array_push($counting, $countingVal);
                    array_push($partOfSpeech, $partOfSpeechVal);
                    array_push($type, $typeVal);
                    $words[0] = str_replace($partsOfSpeech, '', $words[0]);
                    $words[0] = preg_replace('/\[.*\]/', '', $words[0]);
                    $words[0] = preg_replace('/\s[a-z]+\+[a-z]+\s/', '', $words[0]);
                    array_push($firstArray, $words[0]);
                    array_push($secondArray, str_replace(array("\r", "\n"), ' ', $words[1]));


                    if (vocExists($db, $words[0])) {
                        $vocabulary = getVocabulary($db, $words[0]);
                        updateExisting(
                            $db,
                            'english',
                            $vocabulary['english_value'],
                            $typeVal,
                            $vocabulary['topic'],
                            $partOfSpeechVal,
                            $vocabulary['english_pronunciation'],
                            $words[1],
                            $vocabulary['english_examples'],
                            $vocabulary['english_synonyms'],
                            $english_group,
                            $vocabulary['grammar_category'],
                            $countingVal,
                            $vocabulary['frequency'],
                            $vocabulary['origin']
                        );
                    } else {
                        insertNewVoc($db, 'english', $words[0], $typeVal, '', $partOfSpeechVal, '', $words[1],'', '', $english_group, '', $countingVal, '', 'original');

                    }
                } else {

                    $secondArray[count($secondArray) - 1] = $secondArray[count($secondArray) - 1] . str_replace(array("\r", "\n"), '', $words[0]);
                }

            } else {
                fgets($myfile);
            }
            $count++;
        }
        fclose($myfile);

        /** for ($i=0;$i<count($firstArray);$i++){
         * $result=$result. $firstArray[$i].$counting[$i].' '.$partOfSpeech[$i].' '.$type[$i].'='.$secondArray[$i].PHP_EOL;
         * }
         * $result=$result.PHP_EOL. '####################  STOP  ####################'.PHP_EOL; */
    }
    } catch (PDOException $message) {
        $db->rollBack();
        return PHP_EOL . $message . PHP_EOL;

    }
    if ($db->commit() === false) {
        $db->rollBack();
        return PHP_EOL . "Vložení hodnot se nezdařilo" . PHP_EOL;

    }

    return PHP_EOL . 'Hodnoty vloženy' . PHP_EOL;

}

function insertFromLocal(PDO $db, $value, $explanation, $counting, $partOfSpeech, $type, $english_group)
{
    if (vocExists($db, $value)) {
        updateExisting($db, $value, $explanation, $counting, $partOfSpeech, $type, $english_group);
    } else {
        insertNewVoc($db, $value, $partOfSpeech, $type, null, null, $explanation, $english_group, $counting);
    }

}

function getcountingType(string $value=null)
{
    switch ($value) {
        case '[C]':
            return "countable";
        case '[U]':
            return "uncountable";
        default:
            return '';
    }
}

function getTypeAndPartOfSpeech(string $value=null)
{

    switch (trim($value)) {
        case 'n':
            return array('word', 'noun');
        case 'np':
            return array('phrase', 'noun');
        case 'v':
            return array('word', 'verb');
        case 'vp':
            return array('phrase', 'verb');
        case 'adj':
            return array('word', 'adjective');
        case 'adjp':
            return array('phrase', 'adjective');
        case 'adv':
            return array('word', 'adverb');
        case 'advp':
            return array('phrase', 'adverb');
        default:
            return array('', '');
    }
}


function uploadPronouncation()
{
    $json = json_decode(file_get_contents(__DIR__ . "/../sources/fromLocalDic/pronounciation/pronounciations.json"));

    global $allowed;
    $allowed = false;

    foreach ($json as $vocabulary => $link) {
        if ($allowed === true) {
            @file_put_contents(__DIR__ . '/../sources/fromLocalDic/pronounciation/audioFiles/' . $vocabulary . '.mp3', @file_get_contents($link, 'r'));
        }
        if ($vocabulary === "101") {

            $allowed = true;
        }
    }
}

function uploadPhrasalVerbs()
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    if (($handle = fopen(__DIR__ . "/../sources/fromLocalDic/phrasalVerbs/phrasalVerbs.csv", "r")) !== FALSE) {

        $db->beginTransaction();
        try {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if (vocExists($db, $data[0])) {
                    $vocabulary = getVocabulary($db, $data[0]);
                    updateExisting(
                        $db,
                        'english',
                        $vocabulary['english_value'],
                        $vocabulary['type'],
                        $vocabulary['topic'],
                        'verb',
                        $vocabulary['english_pronunciation'],
                        $data[1],
                        $data[2],
                        $vocabulary['english_synonyms'],
                        $vocabulary['group_name'],
                        'phrasal verbs',
                        $vocabulary['english_counting'],
                        $vocabulary['frequency'],
                        $vocabulary['origin']
                    );
                } else {
                    insertNewVoc($db, 'english', $data[0], 'phrase', '', 'verb', '', $data[1], $data[2], '', '', 'phrasal verbs', '', '', 'original');

                }

            }
        } catch (PDOException $message) {
            $db->rollBack();
            return PHP_EOL . $message . PHP_EOL;

        }
        if ($db->commit() === false) {
            $db->rollBack();
            return PHP_EOL . "Vložení hodnot se nezdařilo" . PHP_EOL;

        }

        fclose($handle);
        return PHP_EOL . 'Hodnoty vloženy' . PHP_EOL;

    }

}