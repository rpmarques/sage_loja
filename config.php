<?php

//AUQUI FICAM CONFIGURAÇÕES GERAIS
require './environment.php';

global $config;
global $db;

//CONFIG BANCO DE DADOS
$config = array();
if(ENVIRONMENT == 'development') {
	 ini_set('display_errors', 1);
	 ini_set('display_startup_errors', 1);
	 error_reporting(E_ALL);
	define("BASE_URL", "http://localhost:81/sage_loja/");
	$config['dbname'] = 'sage_loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	define("BASE_URL", "http://sageloja.infinityfreeapp.com/sage_loja/");
	$config['dbname'] = 'epiz_28242450_loja';
	$config['host'] = 'sql103.epizy.com';
	$config['dbuser'] = 'epiz_28242450';
	$config['dbpass'] = '55g0BkrPhDaGe';
}

//CONFIGURAÇÃO DE LINGUAGEM
$config['default_lang']='pt-br';
//CEP USADO PELOS CORREIOS PARA CALCULAR FRETE
$config['cep_origem'] = '97573560';

// DADOS PAGSEGURO
$config['pagseguro_email'] = 'nairacharnoski@gmail.com';
\PagSeguro\Library::initialize(); //INCIA MÓDULO
\PagSeguro\Library::cmsVersion()->setName("SageLoja")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("SageLoja")->setRelease("1.0.0");
//configurações
\PagSeguro\Configuration\Configure::setEnvironment('sandbox'); //SE É PRODUÇÃO OU NÃO
\PagSeguro\Configuration\Configure::setAccountCredentials('nairacharnoski@gmail.com','7AA6BE10A1764C8EB0AF63A0995D3BCB'); //usuario e senha
\PagSeguro\Configuration\Configure::setCharset('UTF-8'); 
\PagSeguro\Configuration\Configure::setlOG(true,'pagseguro.log'); //LOG DO PAGSEGURO

$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>