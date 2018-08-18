<?php

function getCategories()
{
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    $query = $db->prepare("SELECT distinct(topic) FROM vocabulary_english where topic not like '' order by frequency ASC");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}



function getVocForCategory($category){
    $db = connectToDatabase();

    if ($db == null) {
        $_SESSION['error'] = array(true, "Není spojení s databází");

        return false;
    }
    $query = $db->prepare("SELECT english_value FROM vocabulary_english where topic='$category'");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}