<?php

//AUQUI FICAM CONFIGURAÇÕES GERAIS
require 'environment.php';

global $config;
global $db;

//CONFIG BANCO DE DADOS
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost:81/sage_loja/");
	$config['dbname'] = 'sage_loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://localhost:81/sage_loja/");
	$config['dbname'] = 'sage_loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

//CONFIGURAÇÃO DE LINGUAGEM
$config['default_lang']='pt-br';

$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>