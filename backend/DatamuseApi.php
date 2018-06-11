<?php
function datamuesGetVocabularies(){
    ini_set('memory_limit', '-1');
    $json=json_decode(file_get_contents(__DIR__.'/../sources/datamuseApi/topicWordLists/vocabularies.json'),true);

    $values=$json['english'];
$count =0;
    foreach ($values as $object){
        $value =$object['english_value'];
        $filePath=__DIR__. '/../sources/datamuseApi/topicWordLists/'.$value .'.json';
        $count%500===0?sleep(10):null;
        if($count>70000){
            return;
        }
        if(!file_exists($filePath)){

        $link='https://api.datamuse.com/words?&topics='.$value.'&md=dpsrf&max=1000';
        @file_put_contents($filePath, @file_get_contents($link, 'r'));

    }
        $count++;
}


}