<?php
require 'environment.php';

$config = array();
if(ENVIRONMENT == 'development'){
	define("BASE_URL", "http://localhost/ead/");
	$config['dbname'] = 'ead';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
        $config['charset'] ='utf8';
}
else{
	define("BASE_URL", "http://eadtc.esy.es/");
	$config['dbname'] = 'u979827010_ead';
	$config['host'] = 'mysql.hostinger.com.br';
	$config['dbuser'] = 'u979827010_bruno';
	$config['dbpass'] = 't3t@Dentaria23';
    $config['charset'] ='utf8';
}
global $db;
try{
	$db = new PDO("mysql:dbname=".$config['dbname'].";charset=".$config['charset'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
	echo "Erro: ".$e->getMessage();
}