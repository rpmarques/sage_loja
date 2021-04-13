<?php
class pagsegurotransparenteController extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $products = new Products();
        $carrinho = new Cart();

        $dados=$store->getTemplateData();
        $carrinho = $carrinho->getList();
        $total = 0;

        foreach ($carrinho as $item) {
            $total += (floatval($item['price']) * intval($item['qtde']));
        }
        if (!empty($_SESSION['price'])){
            $shipping = $_SESSION['shipping'];
            if (isset($shipping['price'])){
                $frete=floatval(str_replace(',','.',$shipping['price']));
            }else{
                $frete = 0;
            }
            $total+=$frete;
        }
        $dados['total'] = number_format($total,2);


        //CRIAR SESSÃO PAGAMENTO PAGSEGURO
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            $dados['sessionCode'] = $sessionCode->getResult();
        } catch (Exception $e) {
            echo "ERRO:".$e->getMessage();
            exit;
        }

        $this->loadTemplate('cart_pagsegurotransparente', $dados);
    } //FIM index

    public function checkout(){

        $users = new Users(); 
        $carrinho = new Cart();
        $vendas = new Purchases();

        $id = addslashes($_POST['id']);
        $nome = addslashes($_POST['name']);
        $email= addslashes($_POST['email']);
        $senha= addslashes($_POST['senha']);
        $cep= addslashes($_POST['cep']);
        $rua= addslashes($_POST['rua']);
        $numero= addslashes($_POST['numero']);
        $copmlemento= addslashes($_POST['complemento']);
        $bairro= addslashes($_POST['bairro']);
        $cidade= addslashes($_POST['cidade']);
        $estado= addslashes($_POST['estado']);
        $nro_cartao= addslashes($_POST['nro_cartao']);
        $cpf_cartao= addslashes($_POST['cpf']);
        $titular_cartao= addslashes($_POST['titular_cartao']);
        $nro_cvv= addslashes($_POST['nro_cvv']);
        $validade_mes= addslashes($_POST['validade_mes']);
        $validade_ano= addslashes($_POST['validade_ano']);
        $cartaoToken= addslashes($_POST['cartaoToken']);
        $parcelas= explode(";",$_POST['parc']);
        $telefone = addslashes($_POST['telefone']);

        //VERIFICA SE TEM LOGIN
        if($users->verificaEmail($email)){
            $user_id = $users->valida($email, $senha);
            if(empty($user_id)){
                $array = array('error'=>true,'msg'=>'Email ou senha errados');
                echo json_encode($array);
                exit;

            } //FIM if(!empty($user_id)){

        } else{//FIM if($users->verificaEmail($email)){
            $user_id = $users->criaUser($email,$senha);
        } //FIM else if($users->verificaEmail($email)){

        $carrinho = $carrinho->getList();
        $total = 0;

        foreach ($carrinho as $item) {
            $total += (floatval($item['price']) * intval($item['qtde']));
        }
        if (!empty($_SESSION['price'])){
            $shipping = $_SESSION['shipping'];
            if (isset($shipping['price'])){
                $frete=floatval(str_replace(',','.',$shipping['price']));
            }else{
                $frete = 0;
            }
            $total+=$frete;
        }

        // SALVO A VENDA E OS ITENS NO BANCO
        
        $id_venda = $vendas->criaVenda($user_id,$total,'pagseguro_t');
        foreach ($carrinho as $item) {
            $vendas->addItem($id_venda,$item['id'],$item['qtde'],$item['price']);
        }

        global $config;
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail($config['pagseguro_email']);
        $creditCard->setReference($id_venda);
        $creditCard->setCurrency("BRL");

        //ADICIONA PRODUTOS NO PAGSEGURO
        foreach ($carrinho as $item) {
            $creditCard->addItems()->withParameters(
                $item['id'],
                $item['name'],
                intval($item['qtde']),
                floatval($item['price'])
            );            
        }
        //dados do cliente
        $creditCard->setSender()->setName($nome);
        $creditCard->setSender()->setEmail($email);
        //TELEFONE TENH QUE SEPARAR DDD DO RESTO
        $ddd = substr($telefone,0,2);
        $telefone = substr($telefone,2);
        $creditCard->setSender()->setPhone()->withParameters($ddd,$telefone);
        $creditCard->setSender()->setDocument()->withParameters("CPF",$cpf_cartao);

        $creditCard->setSender()->setHash($id);
        $ip = $_SERVER['REMOTE_ADDR'];
        if (strlen($ip)){
            $ip = '127.0.0.1';
        }
        $creditCard->setSender()->setIp($ip);
        $creditCard->setShipping()->setAddress()->withParameters(
            $rua,
            $numero,
            $bairro,
            $cep,
            $cidade,
            $estado,
            'BRA',
            $copmlemento
        );
        $creditCard->setBilling()->setAddress()->withParameters(
            $rua,
            $numero,
            $bairro,
            $cep,
            $cidade,
            $estado,
            'BRA',
            $copmlemento
        );

        $creditCard->setToken($cartaoToken);
        //0 = QTDE DE PARCELAS
        //1 = VALOR
        //2 = SE TEM JUROS OU NÃO

        //$creditCard->setInstallment()->withParameters($parcelas[0],$parcelas[1],$parcelas[2]);
        $creditCard->setInstallment()->withParameters($parcelas[0],$parcelas[1]);
        $creditCard->setHolder()->setName($titular_cartao);
        $creditCard->setHolder()->setDocument()->withParameters("CPF",$cpf_cartao);

        $creditCard->setMode('DEFAULT');
        //BASE_URL + 'pagsegurotransparente/obrigado'
        //PÁGINA DE NOTIFICAÇÃO, NÃO DA PRA SER LOCALHOST
        $creditCard->setNotificationUrl(BASE_URL.'pagsegurotransparente/notificacao');

        //SETEI DADOS E AGORA VOU MANDAR PRO PAGSEGURO
        try {
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            echo json_encode($result);
            exit;
        } catch (Exception $e) {
            echo json_encode(array('error'=>true,'msg'=>$e->getMessage()));
            exit;
        }
    } //FIM checkout

    public function obrigado(){
        unset($_SESSION['carrinho']);
        $store = new Store();
        $dados=$store->getTemplateData();

        $this->loadtemplate('pagseguro_obrigado',$dados);

    }// FiM function obrigado

    public function notificacao(){
        $vendas = new Purchases();       
        try {
            //VERFICO SE PAGSEGURO FEZ O ENVIO DO POST
            //SE ENVIOU , ME RETORNA ALGUNS DADOS
            if(\PagSeguro\Helpers\Xhr::hasPost()){
                $retorno = \PagSeguro\Services\Transactions\Notification::check(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );
                $ref = $retorno->getReference();
                $status = $retorno->getStatus();
                /*
                1->AGUARDANDO PAGAMENTO
                2->EM ANÁLISE
                3->PAGA
                4->DISPONÍVEL
                5->EM DISPUTA
                6->DEVOLVIDA
                7->CANCELADA
                8->DEBITADO
                9->RETENÇÃO TEMPORÁRIA
                */


                switch ($status) {
                    case '1': // AGUARDANDO PAGAMENTO
                        # code...
                        break;
                    case '2': //EM ANÁLISE
                        # code...
                        break;
                    case '3': //PAGA
                        $vendas->aprovaVenda($ref);
                        break;
                    case '4': //DISPONÍVEL
                        break;
                    case '5': //EM DISPUTA
                        break;                    
                    case '6': //DEVOLVIDA
                        break;
                    case '7': //CANCELADA
                        $vendas->cancelaVenda($ref);
                        break;                        
                    case '8': //DEBITADO
                        break;
                    case '9': //RETENÇÃO TEMPORÁRIA
                        break;

                    default:
                        # code...
                        break;
                }                
            }
        } catch (Exception $e) {
            //throw $th;
        }

    } //FIM function notificacao()


}