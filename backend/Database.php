<?php
/**
 * Knihovna obsahující veškeré funkce pro manupulaci s databází. 
 *
 *  @author Oldřich Hradil 
 * 
 **/
/**
 * Poskytuje připoneí k databázi, na základě přihlašovacích údajů obsažených 
 * v konfiguračním souboru. 
 * @param mysqli|null $conn Vrací object mysqli, popřípade null pokud nastala 
 * chyba. 
 */
function connectToDatabase(){
 $config = parse_ini_file(INI_LOCATION);
 try{
$db = new PDO('mysql:host=localhost;dbname='.$config['dbname'].';charset=utf8',$config['username'] , $config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
 } catch (PDOException $ex){
     echo $ex;
     exit();
       return null;
 }

}
