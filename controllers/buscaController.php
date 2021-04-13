<?php
class buscaController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        //$dados = array(); //ESSE AQUI É QUE EU MANDO OS DADOS PARA AS VIEWs
        $dados = $store->getTemplateData();
        $products = new Products();
        $categories = New Categories();
        $_filters = New Filters();

        //o $_GET['s'] VEM LA DO TEMPLATE, É A PROPRIEDADE NAME DO CAMPO
        if (!empty($_GET['s'])){
            
            $textoBusca = $_GET['s']; //TEXTO PROCURADO
            $category = $_GET['category']; //CATEGORIA PROCURADA
        
            $filters= array();
            
            //VERIFICO SE MANDO FILTRO POR GET, SE ENVIO MANDA PRO ARRAY
            //AQUI PASSO OS GET DE FILTROS PRA MONTAR OS FILTROS
            if (!empty($_GET['filter']) && is_array($_GET['filter'])){
                $filters=$_GET['filter'];
            }
            
            $filters['category'] = $category;
            $filters['textoBusca'] = $textoBusca;

            //FIM FILTROS
    
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
    
            // TODOS OS FILTROS
            $dados['filters'] = $_filters->getFilters($filters); 
            // FILTROS SELECIONADOS
            $dados['filters_selected'] = $filters;

            //TEXTO DO PROCURAR
            $dados['textoBusca'] = $textoBusca;
            $dados['category'] = $category;

            $dados['sidebar'] = true;
                
            $this->loadTemplate('busca', $dados);

        }else{
            header("Location:".BASE_URL);
        }
        
    }

}