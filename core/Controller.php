<?php
class controller {

	protected $db;
	protected $lang;

	public function __construct() {
		global $config;
		$this->lang = New Language(); //CARREGA O TRADUTO
	}
	
	//TRAZ OS DADOS PARA O TEMPLATE
	public function loadView($viewName, $viewData = array()) {
		extract($viewData); //EXTRAI O ARRAY PRA UMA VARIAVEL COM CADA REGSITRO
		include 'views/'.$viewName.'.php';
	}

	//ESSE AQUI CARREGA O TEMPLATE BASICO
	public function loadTemplate($viewName, $viewData = array()) {
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

}