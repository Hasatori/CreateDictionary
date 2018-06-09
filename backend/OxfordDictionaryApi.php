<?php
function uploadTopicLists(){
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }

    $topicLists=listDirectory("oxfordDictionaryApi/topicWordLists");
    $path=__DIR__."/../sources/oxfordDictionaryApi/topicWordLists/";

    foreach ($topicLists as $topicList){
    $file = file_get_contents($path.$topicList);
    $json = json_decode($file,true);
    $results = $json["results"];
    $topic = str_replace('.json','',$topicList);

  foreach ($results as $value ){

if(vocExists($db,$value['word'])){
    updateExisting($db,$value['word'],$topic,null,null,null,'word',null);
}else{
    insertNewVoc($db,$value['word'],null,'word',$topic,null,null,null,null);
}
    }
    }
return true;
}
























function processOxfordPost($post){
    $type=$_POST['type'];

    switch ($type){
        case "topicWordList":
uploadTopicLists();
            break;

    }
}