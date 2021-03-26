<?php
class categoriesController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        header("Location:".BASE_URL);
    } //FOM index()

    //O $ID VEM POR GET
    public function enter($rId){
        $dados = array();
        $categories = new Categories();
        $products = new Products();
        $_filters = New Filters();
        // ESSE VAI RECEBER OS FILTROS
        $filters= array();

        //SE NÃO TIVER CATEGORIA VAI PRA PÁGINA INICIAS
        $dados['category_name'] = $categories->getCategoryName($rId);        
        if (!empty($dados['category_name'])){

            $inicioPaginacao = 0;
            $qtdePorPagina = 3;
            $paginaAtual = 1;
            //FAZ A PAGINAÇÃO 
            if (!empty($_GET['p'])){
                $paginaAtual = $_GET['p'];
            }
            $inicioPaginacao = ($paginaAtual * $qtdePorPagina) - $qtdePorPagina;

            // filtros
            $filtros = array('category'=>$rId);            

            // DADOS PARA MONTAR A VIEW
            $dados['category_filter'] = $categories->getCategoryTree($rId);
            $dados['categories'] = $categories->getList(); 
            $dados['list'] = $products->getList($inicioPaginacao,$qtdePorPagina,$filtros); 
            $dados['totalItens'] = $products->getTotal($filtros);
            // FAÇO ESSA DIVISÃO PRA SABER QNTAS PÁGINAS VOU TER
            $dados['nroDePaginas'] = ceil($dados['totalItens']/$qtdePorPagina);
            $dados['paginaAtual'] = $paginaAtual;

            $dados['id_category'] = $rId;

            // FILTROS
            $dados['filters'] = $_filters->getFilters($filters);

            $this->loadTemplate('categories',$dados);
        }else{
            header("Location:".BASE_URL);
        }        //FIM (!empty($dados['category_name'])){
    } //FIM enter()

}