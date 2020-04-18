<?php
try{

$db = new PDO('mysql:host=localhost;dbname=project', 'root', 'root');

} catch(PDOException $e){
     die('Erreur : '.$e->getMessage());
}
 ?>