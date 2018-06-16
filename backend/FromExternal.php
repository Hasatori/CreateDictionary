<?php

function uploadDictionaryToDatabase() {
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    $row = 0;
    if (($handle = fopen(__DIR__ .'/../sources/' . $file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, "#")) !== FALSE) {
            if($row == 0){ $row++; continue; }
          try {
                if (vocExists( $db, $data[0])) {
                    insertExistingVoc( $db
                            ,getFullLanguageFromAbr($language)
                            ,$data[0]
                            ,$data[1]
                            ,$data[2]
                            ,$data[3]);
                }else{
                    $db ->beginTransaction();
                    insertNewVoc( $db
                            ,$data[0]
                            ,$data[2]
                            );
                            insertExistingVoc( $db
                            ,getFullLanguageFromAbr($language)
                            ,$data[0]
                            ,$data[1]
                            ,$data[2]
                            ,$data[3]);
                    if(!$db ->commit()){
                        $db ->rollBack();
                    }
                    
                }
                }
        catch( PDOException $Exception) {
                    var_dump($data);
            }
                $row++;
            
        }
        fclose($handle);
    }
}


