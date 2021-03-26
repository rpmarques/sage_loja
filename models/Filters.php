<?php 
class Filters extends model {
    
    public function getFilters($rFiltros){

        $brands = new Brands();
        $products = new Products();

        $array = array(
            'brands' =>array(),
            'slidermin' => 0, //TRAZ O VALOR MÍNIMO DO SLIDER
            'slidermax' => 1000, //TRAZ O VALOR MÁXIMO DO SLIDER
            'slider0' => 0,
            'slider1' => 0,
            'stars' => array(
                '0' =>0,
                '1' =>0,
                '2' =>0,
                '3' =>0,
                '4' =>0,
                '5' =>0
            ),
            'sale' =>0,
            'options' =>array()
        );

        //TODAS AS MARCAS    
        $array['brands'] = $brands->getList();
        
        //ADICIONO O TOTAL DE ITENS POR MARCA NO ARRAY QUE TEM AS MARCAS
        // MARCAS
        $brand_products = $products->getListOfBrands($rFiltros);
        foreach($array['brands'] as $marca_chave => $marca_item){            
            // O CONTADOR SEMPRA VAI COMEÇAR COM 0, 
            // PQ DAI MAIS PRA FRENTE EU CONSIGO FAZER QUE ELA
            // NÃO APAREEÇA CASO NÃO TENHA PRODUTO
            $array['brands'][$marca_chave]['count'] = 0;
            foreach($brand_products as $item_products){
                if ($item_products['id_brand'] == $marca_item['id']){
                    $array['brands'][$marca_chave]['count'] = $item_products['cont_marcas'];
                }
            }
            //SE A MARCA NÃO TIVER PRODUTO, NÃO MOSTRA
            if ($array['brands'][$marca_chave]['count'] == '0'){
                unset($array['brands'][$marca_chave]);
            }
        }
        //FIM FILTRO MARCAS

        // FILTRO DOS PREÇOS
        //SUBSTITUI O VALOR LA DO ARRAY PELO QUE VEM DA FUNÇÃO
        if (isset($rFiltros['slider0'])){
            $array['slider0']=$rFiltros['slider0'];
        }
        if (isset($rFiltros['slider1'])){
            $array['slider1'] = $rFiltros['slider1'];
        }

        //MAIOR PREÇO         
        $array['slidermax'] = $products->pegaMaiorPreco($rFiltros);
        if($array['slider1'] == 0){
            $array['slider1'] = $array['slidermax'];
        }
        //MENOR PREÇO 
        $array['slidermin'] = $products->pegaMenorPreco($rFiltros);

        //AVALIAÇÃO (estrelas)
        $star_products = $products->pegaListaEstrelas($rFiltros);
        foreach($array['stars'] as $star_chave => $star_item){
            foreach($star_products AS $item_products){
                if ($item_products['rating'] == $star_chave){
                    $array['stars'][$star_chave] = $item_products['cont_estrelas'];
                }
            }
        }

        //PROMOÇÕES
        $array['sale'] = $products->contaProdutosPromocao($rFiltros);

        //FILTRO DE OPÇÕES DINAMICAS
        $array['options'] = $products->pegaOpcoes($rFiltros);

        // echo '<pre>';
        // var_dump($array);
        return $array;

    } //FIM getFilters
}
?>