<?php
include_once "Libraries.php";
function parseJson()
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }

    $file = json_decode(file_get_contents(__DIR__ . "/../sources/glosbe/example_en_to_cs.json"), true);
    if (isEmpty($file)) {
echo "empty";
    } else {
        foreach ($file["tuc"] as $word) {
            $translation = @$word["phrase"]["text"];
           // $meanings = @$word["meanings"];
            echo $translation != null ? $translation : "";
            /*  if ($meanings != null) {
                  echo " => ";
                  foreach ($meanings as $meaning) {
                      if (@$meaning["language"]["en"]!=null) {
                          echo ", anglický význam:" . $meaning["text"];
                      } else {
                          echo ", český význam:" . $meaning["text"];
                      }
                  }

              }
 */
            echo PHP_EOL;
        }
    }
   // sleep(10);

    /*$vocabularies = getAllVocabularies($db, "english");
    foreach ($vocabularies as $vocabulary) {
        echo $vocabulary["english_value"] . PHP_EOL;
    }*/
}


function isEmpty($file)
{
    return count($file["tuc"]) == 0 ? true : false;
}
