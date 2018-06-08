<?php
function createFromLocal($category=null,$separator=null){

$files= listDirectory("fromLocalDic/categories/".$category);
    $result='';
    foreach ($files as $fileName){
        $result=$result.PHP_EOL. '####################  START  ####################'.PHP_EOL;
        $myfile = fopen(__DIR__."/../sources/fromLocalDic/categories/CAE/".$fileName, "r") or die("Unable to open file!");
// Output one line until end-of-file
        $count=0;
        $firstArray=array();
        $partOfSpeech=array();
        $type=array();
        $counting=array();
        $secondArray=array();
$partsOfSpeech=array(" n ", " np ", " v ", " vp ", " adj ", ' adjp ', " adv ", " advp ",' pp ');
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
                    array_push($counting,getcountingType(@$countingType[0]));
                    array_push($partOfSpeech,getTypeAndPartOfSpeech(@$partOfSpeechAndType[0])[1]);
                    array_push($type,getTypeAndPartOfSpeech(@$partOfSpeechAndType[0])[0]);
                    $words[0]=str_replace($partsOfSpeech,'',$words[0]);
                    $words[0]=preg_replace('/\[.*\]/','',$words[0]);
                    $words[0]=preg_replace('/\s[a-z]+\+[a-z]+\s/','',$words[0]);
                    array_push($firstArray,$words[0]);
                    array_push($secondArray,str_replace(array("\r", "\n"), '', $words[1]));
                }else{

                    $secondArray[count($secondArray)-1]=$secondArray[count($secondArray)-1].str_replace(array("\r", "\n"), '', $words[0]);
                }

            }else {
                fgets($myfile);
            }  $count++;
        }
        fclose($myfile);

        for ($i=0;$i<count($firstArray);$i++){
            $result=$result. $firstArray[$i].$counting[$i].' '.$partOfSpeech[$i].' '.$type[$i].'='.$secondArray[$i].PHP_EOL;
        }
        $result=$result.PHP_EOL. '####################  STOP  ####################'.PHP_EOL;
    }

return $result;
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
