<?php
function uploadTopicLists()
{
    $db = connectToDatabase();
    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");
        return false;
    }
    $topicLists = listDirectory("oxfordDictionaryApi/topicWordLists");
    $path = __DIR__ . "/../sources/oxfordDictionaryApi/topicWordLists/";
    $db->beginTransaction();
    try {
        foreach ($topicLists as $topicList) {
            $file = file_get_contents($path . $topicList);
            $json = json_decode($file, true);
            $results = $json["results"];
            $topic = str_replace('.json', '', $topicList);

            foreach ($results as $value) {
                if (!isset($value['word'])) {
                    continue;
                }
                if (vocExists($db, @$value['word'])) {
                    $vocabulary = getVocabulary($db, $value['word']);
                    $englishValue = $vocabulary['english_value'];
                    if (substr($value['word'], 0, 1) === '-') {
                        $englishValue = substr($value['word'], 1);
                    };
                    updateExisting(
                        $db,
                        'english',
                        $englishValue,
                        $vocabulary['type'],
                        $topic,
                        $vocabulary['english_gender'],
                        $vocabulary['english_part_of_speech'],
                        $vocabulary['english_pronunciation'],
                        $vocabulary['english_explanation'],
                        $vocabulary['english_examples'],
                        $vocabulary['group_name'],
                        $vocabulary['grammar_category'],
                        $vocabulary['english_counting'],
                        $vocabulary['frequency'],
                        $vocabulary['origin']
                    );

                } else {
                    insertNewVoc($db, 'english', $value['word'], '', 'word', $topic, '', '', '', '', '', '', '', '', '', 'original');
                }


            }
        }
    } catch (PDOException $message) {
        $db->rollBack();
        return PHP_EOL . $message . PHP_EOL;
    }
    if ($db->commit() === false) {
        $db->rollBack();
        return PHP_EOL . "Vložení hodnot se nezdařilo" . PHP_EOL;

    }
    return PHP_EOL . "Hodnoty vloženy" . PHP_EOL;
}


function processOxfordPost(array $post)
{
    $type = $post['type'];

    switch ($type) {
        case "topicWordList":
            uploadTopicLists();
            break;

    }
}