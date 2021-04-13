<?php 
class Store extends model {

    public function getTemplateData(){
        $dados = array();
        $dados['filters']['slidermax'] = '0';

        $products = new Products();
        $categories = new Categories();
        $carrinho  = new Cart();

        // CATEGORIAS
        $dados['categories'] = $categories->getList();
        // Produtos em Destaque EM BAIXO DOS FILTROS LATERAIS
        $dados['widget_destaque1'] = $products->getList(0,5,array('featured'=>'1'),true);
        // Produtos em Destaque rodape
        $dados['widget_destaque2'] = $products->getList(0,3,array('featured'=>'1'),true);
        // Produtos em PROMOÇÃO
        $dados['widget_promocao'] = $products->getList(0,3,array('sale'=>'1'),true);
        // Produtos em MELHORES
        $dados['widget_melhores'] = $products->getList(0,3,array('toprated'=>'1'),false);

        // TOTAL DE ITENS
        // if (isset($_SESSION['carrinho'])){
        //     $dados['carrinho_qt'] =count($_SESSION['carrinho']);
        // }else{
        //     $dados['carrinho_qt'] = 0;
        // }

        //TOTOAL DE PRODUTOS 
        // echo '<pre>';
        //     var_dump($_SESSION['carrinho']);
        if (isset($_SESSION['carrinho'])){
            $qtde = 0;
            foreach($_SESSION['carrinho'] as $qtde_carrinho){
                $qtde += intval($qtde_carrinho);
            }            
            $dados['carrinho_qt'] = $qtde;
        }else{
            $dados['carrinho_qt'] = 0;
        }

        $dados['carrinho_subtotal'] = $carrinho->getSubTotal();;
        
        return $dados;
    }
}
?>