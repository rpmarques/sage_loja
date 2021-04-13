<?php
//controller traz as coisas e diz pra onde vai devolver
// pra qual view ele vai devolver
class productController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    //FAÇO ISSO PQ SE O CARA DIGITAR SÓ /id NÃO VAI DAR ERRO...
    public function index(){
        header("Location:".BASE_URL);
    }

    public function open($rId){
        $store = new Store();
        $dados = $store->getTemplateData();            
        $products = new Products();

        //PEGA O PRODUTO
        $produto = $products->pegaProduto($rId);
     
        if(count($produto) > 0){
            //PRODUTO
            $dados['produto'] = $produto;
            //PRODUTO IMAGENS
            $dados['produto_imagens'] = $products->getImagesByProductsId($rId);
            //PEGAR OPÇÕES DO PRODUTO
            $dados['produto_opcao'] = $products->getOptionsByProductsId($rId);
            //TRAZ AS AVALIAÇÕES DO PRODUTOS
            $dados['produto_avaliacao'] = $products->pegaAvaliacoes($rId, 5);            
            
            $this->loadTemplate('product', $dados);
        }else{
            header("Location:".BASE_URL);
        }
        

    }
}