<?php 
define('USER', 'superu');
define('PASSWD', 'admin');
define('BASE', 'myband');

try {
    $connect = new PDO('mysql:host=localhost;dbname='.BASE, USER, PASSWD);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}


?>