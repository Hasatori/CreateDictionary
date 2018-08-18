<?php
include_once "Libraries.php";
function parseJson()
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }

    $vocabularies = getAllVocabularies($db, "english");
    foreach ($vocabularies as $vocabulary) {
        $file = json_decode(file_get_contents("https://glosbe.com/gapi/translate?from=eng&dest=cs&format=json&phrase=" . $vocabulary["english_value"] . "&pretty=true"), true);
        if (isEmpty($file)) {
            echo "empty";
        } else {
            try {
                $translations = array();
                foreach ($file["tuc"] as $word) {
                    $translation = @$word["phrase"]["text"];
                    if ($translation != null) {
                        array_push($translations, $translation);
                    }
                }
                $existing = array();
                $notExisting = array();
                foreach ($translations as $translation) {
                    if (vocExists($db, $translation, "czech") && synonymExists($db, $translation, "czech")) {
                        array_push($existing, $translation);
                    } else {
                        array_push($notExisting, $translation);
                    }
                }
                if (count($existing) > 0) {
                    foreach ($existing as $existingVoc) {
                        if (count($notExisting) > 0) {
                            foreach ($notExisting as $notExistingVoc) {
                                // echo "Přidávání " . $notExistingVoc . " jako synonymum " . $existingVoc . PHP_EOL;
                                try {
                                    insertNewSynonym($db, "czech", $existingVoc, $notExistingVoc, "", "", null);
                                } catch (PDOException $message) {
                                    if ($message->errorInfo[1] == 1062) {
                                        continue;
                                    } else {
                                        echo PHP_EOL . $message . PHP_EOL;
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    try {
                        insertNewVoc($db, "czech", $vocabulary["english_value"], $notExisting[0]);
                        if (count($notExisting) > 1) {
                            for ($i = 1; count($notExisting); $i++) {
                                insertNewSynonym($db, "czech", $notExisting[0], $notExisting[$i], "", "", null);
                            }
                        }
                    } catch (PDOException $message) {
                        if ($message->errorInfo[1] == 1062) {
                            continue;
                        } else {

                            echo PHP_EOL . $message . PHP_EOL;
                            continue;
                        }
                    }
                }
            } catch
            (PDOException $message) {
                if ($message->errorInfo[1] == 1062) {
                    continue;
                } else {
                    echo PHP_EOL . $message . PHP_EOL;
                    continue;
                }
            }
        }
        usleep(300000);
    }
    /*
           foreach ($vocabularies as $vocabulary){

$file = json_decode(file_get_contents("https://glosbe.com/gapi/translate?from=eng&dest=cs&format=json&phrase=".$vocabulary."&pretty=true"), true);
if (isEmpty($file)) {
    echo "empty";
} else {
    $translations = array();
    foreach ($file["tuc"] as $word) {
        $translation = @$word["phrase"]["text"];
        if ($translation != null) {
            array_push($translations, $translation);
        }

    }
    $existing = array();
    $notExisting = array();
    foreach ($translations as $translation) {
        if (vocExists($db, $translation, "czech") && synonymExists($db, $translation, "czech")) {
            array_push($existing, $translation);
        } else {
            array_push($notExisting, $translation);
        }

    }
    foreach ($existing as $existingVoc) {
        foreach ($notExisting as $nonExistingVoc) {
            echo "Přidávání " . $nonExistingVoc . " jako synonymum " . $existingVoc . PHP_EOL;
            insertNewSynonym($db,"czech",$existingVoc,$nonExistingVoc,"","",null);
        }
    }

}
usleep(300000);
}


}

    */

}


function isEmpty($file)
{
    if (count($file["tuc"]) == 0) {
        return true;
    } else {
        foreach ($file["tuc"] as $object) {
            if ((@$object["phrase"]) != null) {
                return false;
            }
        }
    }
    return true;
}
