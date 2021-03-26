<?php
class homeController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $dados = array(); //ESSE AQUI É QUE EU MANDO OS DADOS PARA AS VIEWs
        $products = new Products();
        $categories = New Categories();
        $_filters = New Filters();
        
        $filters= array();
        //VERIFICO SE MANDO FILTRO POR GET, SE ENVIO MANDA PRO ARRAY
        if (!empty($_GET['filter']) && is_array($_GET['filter'])){
            $filters=$_GET['filter'];
        }

        $inicioPaginacao = 0;
        $qtdePorPagina = 3;
        $paginaAtual = 1;

        //FAZ A PAGINAÇÃO 
        if (!empty($_GET['p'])){
            $paginaAtual = $_GET['p'];
        }
        $inicioPaginacao = ($paginaAtual * $qtdePorPagina) - $qtdePorPagina;

        //PRODUTOS
        $dados['list'] = $products->getList($inicioPaginacao,$qtdePorPagina,$filters); 
        //SE NÃO PASSAR OS FILTROS, ELE TRAZ TODOS
        $dados['totalItens'] = $products->getTotal($filters);

        // FAÇO ESSA DIVISÃO PRA SABER QNTAS PÁGINAS VOU TER
        $dados['nroDePaginas'] = ceil($dados['totalItens']/$qtdePorPagina);
        $dados['paginaAtual'] = $paginaAtual;

        // CATEGORIAS
        $dados['categories'] = $categories->getList();

        // TODOS OS FILTROS
        $dados['filters'] = $_filters->getFilters($filters); 
        // FILTROS SELECIONADOS
        $dados['filters_selected'] = $filters;

        $this->loadTemplate('home', $dados);
    }

}