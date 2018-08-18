<?php


function getSlovnikCZTranslations()
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
   $vocabularies=getVocabularies($db, "english");
  for($i=0;$i<10;$i++){
      echo $vocabularies[$i]['english_value'].PHP_EOL;
  }
    $handle = fopen("http://www.slovnik.cz/bin/mld.fpl?vcb=home&trn=přeložit&dictdir=encz.en&lines=30000&js=1", "r");
    if ($handle) {
        $ready = false;
        while (($line = fgets($handle)) !== false) {
            if ($ready) {
                $string = $line;
                preg_replace('/<i title="gnu">g<\\/i>/i', '', $line);
                $pattern = '/<.*?>/i';
                $replacement = '';
                $parts = preg_split("/ - /", preg_replace($pattern, $replacement, $string));
                echo $parts[0] . "=" . $parts[1] . PHP_EOL;
            }
            if (strpos($line, 'vocables_main') !== false) {
                $ready = true;
            }
            if (strpos($line, 'id="seek"') !== false) {
                $ready = false;
            }
        }

        fclose($handle);
    } else {
        // error opening the file.
    }

}