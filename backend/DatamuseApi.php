<?php
function datamuseGetVocabularies(){
   /** ini_set('memory_limit', '-1');
    $files= listDirectory("datamuseApi/topicWordLists");
$result=array();
    file_put_contents(__DIR__.'/../sources/datamuseApi/vocabularies_new.txt','{');
    foreach ($files as $file){
        $json=json_decode(file_get_contents(__DIR__.'/../sources/datamuseApi/topicWordLists/'.$file),true);
        foreach ($json as $vocabulary){
            $value=$vocabulary["word"];

       if(!in_array($value,$result)){
           array_push($result,$value);
           file_put_contents(__DIR__.'/../sources/datamuseApi/vocabularies_new.txt',json_encode($vocabulary).',',FILE_APPEND);

       }
        }
    }
    file_put_contents(__DIR__.'/../sources/datamuseApi/vocabularies_new.txt','}',FILE_APPEND);


   /** $json=json_decode(file_get_contents(__DIR__.'/../sources/datamuseApi/topicWordLists/vocabularies.json'),true);
    $values=$json['english'];
    $count =0;
global $allowed;
$allowed=false;
    foreach ($values as $object){

        $value =$object['english_value'];
        if($value ==='delany'){
            $allowed=true;
        }

        $link='https://api.datamuse.com/words?&topics='.$value.'&md=dpsrf&max=1000';
        $filePath=__DIR__. '/../sources/datamuseApi/topicWordLists/'.$value .'.json';

        if($allowed){

        @file_put_contents($filePath, @file_get_contents($link, 'r'));

    }
        $count++;
}*/

}

function datamuseUploadVocabularies(){
      ini_set('memory_limit', '-1');
     $vocabularies=json_decode(file_get_contents(__DIR__.'/../sources/datamuseApi/vocabularies_new.json'),true);
$count=0;
foreach ($vocabularies as $v) {
    if ($count < 500) {
    $count++;
    $value = @$v['word'];
    $score = @$v['score'];
    $partOfSpeech='';
    $pronounciation='';
    $frequency ='';
    $tags=@$v['tags'];
    foreach ($tags as $tag){
        if(strpos($tag, 'f:') !== false){
            $frequency = @str_replace('f:','',$tag);
        }
        else if(strpos($tag, 'pron:') !== false){
            $pronounciation = @str_replace('pron:','',$tag);
        }else if(in_array($tag,getPartsOfSpeechAbbreviations())){
            $partOfSpeech=$tag;
        }
    }

    $definitionsArray = @$v['defs'];
        $definitions= json_encode($definitionsArray);
        $definitions=preg_replace('/\w+\\\\[t]/','',$definitions);
        $definitions=str_replace('"','',$definitions);
        $pattern = '/(\[)(.*)(\])/';
        $replacement = '$2';
        $definitions=trim(preg_replace($pattern,$replacement,$definitions));
    echo $value . '=>' . $score . '=>' . $partOfSpeech . '=>' . $pronounciation . '=>' . $frequency . '=>' .$definitions. PHP_EOL;

}
}
}