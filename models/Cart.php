<?php 
class Cart extends model {

    public function getList(){
        $produtos = new Products();
        $array = array();
        $carrinho = array();

        if (isset($_SESSION['carrinho'])){
            $carrinho = $_SESSION['carrinho'];
        }
        

        foreach($carrinho as $id_pro => $qtde){

            $pro = $produtos->pegaInfo($id_pro);

            $array[]=array(
                'id' => $id_pro,
                'name' => $pro['name'],
                'qtde' => $qtde,
                'price' => $pro['price'],
                'imagem' => $pro['image'],
                'peso' => $pro['peso'],
                'largura'=> $pro['largura'],
                'altura'=>$pro['altura'],
                'copmrimento'=> $pro['comprimento'],
                'diametro'=>$pro['diametro']
            );
        }

        return $array;
    } //FIM getList

    public function getSubTotal(){
        $carrinho = $this->getList();
        $subTotal = 0;

        foreach($carrinho as $item){
            $subTotal += (floatval($item['price']) * intval($item['qtde']));
        }

        return $subTotal;

    } //FIM  getSubtotal


    public function calculaFrete($rCep){
        $array = array(
            'price' => 0,
            'date' => '',
        );

        global $config;
        $carrinho = $this->getList(); //PEGO O CARRINHO

        $nVlPeso = 0;
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlValorDeclarado = 0;


        //PEGO OS DADOS DO PRODUTO PRA FAZER AS SOMAS
        foreach ($carrinho as $item_carrinho) {
            $nVlPeso += floatval($item_carrinho['peso']);
            $nVlComprimento += floatval($item_carrinho['copmrimento']);
            $nVlAltura += floatval($item_carrinho['altura']);
            $nVlLargura += floatval($item_carrinho['largura']);
            $nVlDiametro += floatval($item_carrinho['diametro']);
            $nVlValorDeclarado += floatval($item_carrinho['price'] * $item_carrinho['qtde']);
        }

        //consistencia para o correio
        //ESSE VALOR NÃO PODE PASSAR DE 200, senão o correio não envia 
        $soma = $nVlComprimento + $nVlAltura + $nVlLargura; 
        if ($soma > 200){
            $nVlComprimento = 66;
            $nVlAltura = 66;
            $nVlLargura = 66;
        }

        //DIAMETRO NÃO PODE PASSAR DE 91
        if ($nVlDiametro > 90){
            $nVlDiametro = 90;
        }

        //PESO NÃO PODE PASSAR DE 40KG
        if ($nVlPeso > 40 ){
            $nVlPeso= 40;
        }
        //FIM DAS CONSISTENCIAS

        $data = array(
			'nCdServico' => '40010',
			'sCepOrigem' => $config['cep_origem'],
			'sCepDestino' => $rCep,
			'nVlPeso' => $nVlPeso,
			'nCdFormato' => '1',
			'nVlComprimento' => $nVlComprimento,
			'nVlAltura' => $nVlAltura,
			'nVlLargura' => $nVlLargura,
			'nVlDiametro' => $nVlDiametro,
			'sCdMaoPropria' => 'N',
			'nVlValorDeclarado' => $nVlValorDeclarado,
			'sCdAvisoRecebimento' => 'N',
			'StrRetorno' => 'xml'
		);

		$url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
		$data = http_build_query($data);

		$ch = curl_init($url.'?'.$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$r = curl_exec($ch);
		$r = simplexml_load_string($r);

		$array['price'] = current($r->cServico->Valor);
		$array['date'] = current($r->cServico->PrazoEntrega);

        return $array;

    } // FIM CALCULAFRETE

   
}
?>