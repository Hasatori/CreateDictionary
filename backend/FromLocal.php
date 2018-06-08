<?php
function createFromLocal($category=null,$separator=null){
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");
        return false;
    }
$files= listDirectory("fromLocalDic/categories/".$category);
    foreach ($files as $fileName){
        echo '<br/>####################  START  ####################<br/>';
        $myfile = fopen(__DIR__."/../sources/fromLocalDic/categories/CAE/".$fileName, "r") or die("Unable to open file!");
// Output one line until end-of-file
        $count=0;
        $firstArray=array();
        $secondArray=array();

        while(!feof($myfile)) {

            if($count>6) {
                $line=fgets($myfile);
                if(strpos($line,'Complete CAE')!==false){
                    continue;
                }
                $words=preg_split('/'.$separator.'/',$line);
                if(count($words)>1){
                    array_push($firstArray,$words[0]);
                    array_push($secondArray,$words[1]);
                }else{

                    $secondArray[count($secondArray)-1]=$secondArray[count($secondArray)-1].preg_replace( "/\r|\n/", "", $words[0]);
                }

            }else {
                fgets($myfile);
            }  $count++;
        }
        fclose($myfile);

        for ($i=0;$i<count($firstArray);$i++){
            echo $firstArray[$i].'='.$secondArray[$i]."<br/>";
        }
        echo '<br/>####################  STOP  ####################<br/>';
    }


}