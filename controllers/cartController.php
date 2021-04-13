<?php
class cartController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $products = new Products();
        $carrinho = new Cart();
        $cep = '';
        $shipping = array();

        //aqui faz o cálculo do frete
        if (isset($_POST['cep'])){
            $cep = intval($_POST['cep']);
            $shipping = $carrinho->calculaFrete($cep);
            $_SESSION['frete_carrinho'] = $shipping;
        }

        if(!empty($_SESSION['frete_carrinho'])){
            $shipping= $_SESSION['frete_carrinho'];
        }

        if (!isset($_SESSION['carrinho']) || ( isset($_SESSION['carrinho']) && count($_SESSION['carrinho'])==0 )){
            header("Location:".BASE_URL);
            exit;
        }

        $dados=$store->getTemplateData();

        //COISAS DO FRETE
        $dados['shipping']=$shipping;


        $dados['itens_carrinho'] = $carrinho->getList();
        $this->loadTemplate('cart', $dados);
    } //FIM index

    public  function add() {
        if (!empty($_POST['id_produto'])){
            $id = intval($_POST['id_produto']);
            $qtde = intval($_POST['qtde_produto']);

            //CASO NÃO TENHA SESSÃO DO CARRINHO, CRIA
            if (!isset($_SESSION['carrinho'])){
                $_SESSION['carrinho'] = array();
            }

            if (isset($_SESSION['carrinho'][$id])){
                $_SESSION['carrinho'][$id] +=$qtde;
            }else{
                $_SESSION['carrinho'][$id] =$qtde;
            }            
        }
        
        //posso ter 3 páginas para ir
        //header("Location: ".BASE_URL); //PÁGINA INICIAL
        //header("Location: ".BASE_URL."product/open/".$id); //PÁGINA DO PRODUTO
        header("Location: ".BASE_URL."cart"); //PÁGINA DO CARRINHO
    } //FIM add

    public function del($rId_pro){
        if (!empty($rId_pro)){
            unset($_SESSION['carrinho'][$rId_pro]);
        }
        header("Location: ".BASE_URL."cart"); //PÁGINA DO CARRINHO
        exit;

    } //FIM del()

    public function addQtde($rId_pro){

    } //FIM addQtde()

    public function pagamento() {

        if (!empty($_POST['tipo_pagamento'])){
            $tipo_pagamento = $_POST['tipo_pagamento'];
            switch ($tipo_pagamento) {
                case 'pagseguro_transparente':
                    header("Location: ".BASE_URL."pagsegurotransparente"); 
                    exit;
                    break;
            } //FIM switch
        }

        header("Location: ".BASE_URL."cart"); 
        exit;
        

    } // FIM pagamento

}