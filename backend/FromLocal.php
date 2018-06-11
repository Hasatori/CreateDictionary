<?php
function createFromLocal($english_group=null,$separator=null){
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
$files= listDirectory("fromLocalDic/categories/".$english_group);
    $firstArray=array();
    $partOfSpeech=array();
    $type=array();
    $counting=array();
    $secondArray=array();
    $partsOfSpeech=array(" n ", " np ", " v ", " vp ", " adj ", ' adjp ', " adv ", " advp ",' pp ');
    foreach ($files as $fileName){
      //  $result=$result.PHP_EOL. '####################  START  ####################'.PHP_EOL;
        $myfile = fopen(__DIR__."/../sources/fromLocalDic/categories/CAE/".$fileName, "r") or die("Unable to open file!");

        $count=0;

        while(!feof($myfile)) {

            if($count>6) {
                $line=fgets($myfile);
                if(strpos($line,'Complete CAE')!==false){
                    continue;
                }
                $words=preg_split('/'.$separator.'/',$line);
                if(count($words)>1){
                    preg_match('/\[.*\]/',$words[0],$countingType);
                    preg_match('/( n )|( np )|( v )|( vp )|( adj )|( adjp )|( adv )|( advp )|( pp )/',$words[0],$partOfSpeechAndType);
                    $countingVal=getcountingType(@$countingType[0]);
                    $partOfSpeechVal=getTypeAndPartOfSpeech(@$partOfSpeechAndType[0])[1];
                    $typeVal=getTypeAndPartOfSpeech(@$partOfSpeechAndType[0])[0];
                    array_push($counting,$countingVal);
                    array_push($partOfSpeech,$partOfSpeechVal);
                    array_push($type,$typeVal);
                    $words[0]=str_replace($partsOfSpeech,'',$words[0]);
                    $words[0]=preg_replace('/\[.*\]/','',$words[0]);
                    $words[0]=preg_replace('/\s[a-z]+\+[a-z]+\s/','',$words[0]);
                    array_push($firstArray,$words[0]);
                    array_push($secondArray,str_replace(array("\r", "\n"), ' ', $words[1]));

                insertFromLocal($db,$words[0],$words[1],$countingVal,$partOfSpeechVal,$typeVal,$english_group);
                }else{

                    $secondArray[count($secondArray)-1]=$secondArray[count($secondArray)-1].str_replace(array("\r", "\n"), '', $words[0]);
                }

            }else {
                fgets($myfile);
            }  $count++;
        }
        fclose($myfile);

       /** for ($i=0;$i<count($firstArray);$i++){
            $result=$result. $firstArray[$i].$counting[$i].' '.$partOfSpeech[$i].' '.$type[$i].'='.$secondArray[$i].PHP_EOL;
        }
        $result=$result.PHP_EOL. '####################  STOP  ####################'.PHP_EOL; */
    }
$result = array($firstArray,$secondArray,$counting,$partOfSpeech,$type);
return json_encode($result,true);
}

function getcountingType($value){
switch ($value){
    case '[C]':return "countable";
    case '[U]':return "uncountable";
    default: return '';
}
}
function getTypeAndPartOfSpeech($value){

    switch (trim($value)){
        case 'n':
            return array('word','noun');
        case 'np':
            return array('phrase','noun');
        case 'v':
            return array('word','verb');
        case 'vp':
            return array('phrase','verb');
        case 'adj':
            return array('word','adjective');
        case 'adjp':
            return array('phrase','adjective');
        case 'adv':
            return array('word','adverb');
        case 'advp':
            return array('prase','adverb');
        default:
            return  array('','');
    }
}
function insertFromLocal($db,$value,$explanation,$counting,$partOfSpeech,$type,$english_group){
    if(vocExists($db,$value)){
     updateExisting($db,$value,$explanation,$counting,$partOfSpeech,$type,$english_group);
    }else{
         insertNewVoc($db,$value,$partOfSpeech,$type,null,null,$explanation,$english_group,$counting);
    }

}
function updateExisting($db,$value,$type,$topic,$partOfSpeech,$pronounciation,$explanation,$examples,$synonyms,$english_group,$grammarCategory,$counting){



    $query = $db->prepare("UPDATE english SET 
                         type=:type,
                         topic=:topic,
                         partOfSpeech=:partOfSpeech,
                         pronounciation=:pronounciation,
                         explanation=:explanation,
                         examples=:examples,
                         synonyms=:synonyms,
                         english_group=:english_group,
                         grammarCategory=:grammarCategory,
                         counting=:counting
                        WHERE english_value=:english_value");
var_dump($query);
   $query->execute([
       ':english_value'=>$value,
       ':type'=>$type,
       ':topic'=>$topic,
       ':partOfSpeech'=>$partOfSpeech,
       ':pronounciation'=>$pronounciation,
       ':explanation'=>$explanation,
       ':examples'=>$examples,
       ':synonyms'=>$synonyms,
       ':english_group'=>$english_group,
       ':grammarCategory'=>$grammarCategory,
       ':counting'=>$counting
    ]);

}

function uploadPronouncation(){
  $json=json_decode(file_get_contents(__DIR__."/../sources/fromLocalDic/pronounciation/pronounciations.json"));

global $allowed;
    $allowed=false;

foreach ($json as $vocabulary => $link){
   if($allowed===true){
   @file_put_contents(__DIR__. '/../sources/fromLocalDic/pronounciation/audioFiles/'.$vocabulary.'.mp3', @file_get_contents($link, 'r'));
}
if($vocabulary==="101"){

    $allowed=true;
}
}
}

function uploadPhrasalVerbs(){
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    if (($handle = fopen(__DIR__."/../sources/fromLocalDic/phrasalVerbs/phrasalVerbs.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
if(vocExists($db,$data[0])){
    $vocabulary=getVocabulary($db,$data[0]);


    updateExisting(
        $db,
        $vocabulary['english_value'],
        $vocabulary['type'],
        $vocabulary['topic'],
        $vocabulary['partOfSpeech'],
        $vocabulary['pronounciation'],
        $data[1],
        $data[2],
        $vocabulary['synonyms'],
        $vocabulary['english_group'],
        'phrasal verbs',
        $vocabulary['counting']
    );
}else{
  insertNewVoc($db,$data[0],'phrase',null,'verb',null,$data[1],$data[2],null,null,'phrasal verbs',null);

}

        }
        fclose($handle);
    }

}