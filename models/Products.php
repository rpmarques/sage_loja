<?php 

//MODEL FAZ AS CONSULTAS NO BANCO
class Products extends model {

    //TRAZ O PRODUTOS
    // rInicioPaginacao = PONTO INICIAL DA PAGINAÇÃO
    // $rQtdePorPagina = AQUI É QTDE DE ITENS QUE VAMOS MOSTRAR POR PÁGINA
    // $rFiltros FILTROS PRA FAZER O WHERE
    
    //TRAZ TODOS OS PRODUTOS
    public function getList($rInicioPaginacao = 0, $rQtdePorPagina = 3, $rFiltros = array(), $rAleatorio=false){

        $array = array();
        
        $aleatorio = "";
        if ($rAleatorio==true){
            $aleatorio=" ORDER BY RAND() ";
        }

        if (!empty($rFiltros['toprated'])){
            $aleatorio=" ORDER By rating DESC ";
        }

        $where = $this->montaWhere($rFiltros);
            
        $sql =" SELECT products.*,brands.name AS nome_marca,categories.name AS nome_categoria ";
        $sql .="  FROM products ";
        $sql .=" LEFT JOIN brands ON products.id_brand=brands.id ";
        $sql .=" LEFT JOIN categories ON products.id_category=categories.id ";
        $sql .=" WHERE ".implode(' AND ',$where)."  ";
        $sql .= $aleatorio;
        $sql .=" LIMIT $rInicioPaginacao,$rQtdePorPagina ";               

        $sql = $this->db->prepare($sql);        
        
        $this->bindWhere($rFiltros, $sql);  
        $sql->execute();
        if ($sql->rowCount() > 0 ){
            $array = $sql->fetchAll();
            foreach($array as $chave => $item){
                $array[$chave]['images'] = $this->getImagesByProductsId($item['id']);
            }

        } // fim ($sql->rowCount()>0 )
    
        return $array;

    } //FIM getList

    //TRAZ UM PRODUTO BUSCANDO PELO ID
    public function pegaProduto($rID) {
        $array = array();

        if (!empty($rID)){
            $sql =" SELECT products.*,brands.name AS nome_marca,categories.name AS nome_categoria ";
            $sql .="  FROM products ";
            $sql .=" LEFT JOIN brands ON products.id_brand=brands.id ";
            $sql .=" LEFT JOIN categories ON products.id_category=categories.id ";
            $sql .= " WHERE products.id=:id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id",$rID);
            $sql->execute();

            if ($sql->rowCount() > 0){
                $array = $sql->fetch();
            }


        }
        return $array;
    } //FIM pegaProduto

    public function pegaInfo($rID){
        $sql ="SELECT * FROM products WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$rID);
        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetch();
            // PEGO O PRIMEIRO DO ARRAY DE IMAGENS, JÁ QUE O 
            // getImagesByProductsId ME DEVOLVE UM ARRAY
            $images = current($this->getImagesByProductsId($rID));
            $array['image'] = $images['url'];
        }

        return $array;

    } //fim pegaInfo

    //OPÇÕES DOS PRODUTOS BUSCANDO PELO ID
    public function getOptionsByProductsId($rID){
        $options = array();

        //PEGO AS OPÇÕES LA DOS PRODUTOS
        $sql = "SELECT  options FROM products WHERE id=:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$rID);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $options = $sql->fetch();
            $options = $options['options'];
            //PEGO O CADASTRO DAS OPÇÕES LA DOS PRODUTOS
            $sql = "SELECT * FROM options WHERE id IN ($options) ";
            $sql = $this->db->query($sql);
            $options = $sql->fetchAll();

            //AGORA PEGO OS VALORES DAS OPÇÕES
            $sql ="SELECT * FROM products_options WHERE id_product = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id",$rID);
            $sql->execute();
            $options_valores = array();
            if ($sql->rowCount() > 0){
                foreach($sql->fetchAll() as $op_item){
                    $options_valores[$op_item['id_option']] = $op_item['p_value'];
                }
            }
            
            
            //JUNTO VALORES, E NOMES NO MESMO ARRAY PRA DEVOLVER
            foreach($options as $chave =>$op_item){
                if (isset($options[$chave]['id'])){
                    $options[$chave]['value'] = $options_valores[$op_item['id']];
                }else{
                    $options[$chave]['value'] = '';
                }
            }
        }

        return $options;
    }
    // PEGA AS IMAGENS DOS PRODUTOS
    public function getImagesByProductsId($rID){
        $array = array();

        $sql = "SELECT url FROM products_images WHERE TRIM(id_product)= :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",intval($rID));
        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }

        return $array;

    } //FIM getImagesByProductsId

    //PEGA AS AVALIAÇÕES DOS PRODUTOS
    public function pegaAvaliacoes($rID,$rQtde){
        $array = array();

        $rates = New Rates();
        $array = $rates->getRates($rID,$rQtde);

        return $array;
    }

    //DEVOLVE O TOTAL DE PRODUTOS
    public function getTotal($rFiltros = array()){

        $where = $this->montaWhere($rFiltros);

        $sql = "SELECT COUNT(*) as totalProdutos FROM products WHERE ".implode(' AND ',$where);

        $sql = $this->db->prepare($sql);        
                
        $this->bindWhere($rFiltros, $sql);
        $sql->execute();

        $sql = $sql->fetch();

        return $sql['totalProdutos'];

    } //FIM getTotal()

    public function getListOfBrands($rFiltros = array()){
        $array = array();
        $where = $this->montaWhere($rFiltros);

        $sql = "SELECT id_brand,COUNT(id) AS cont_marcas FROM products 
        WHERE ".implode(' AND ',$where)."  GROUP BY id_brand";

        $sql = $this->db->prepare($sql);

        $this->bindWhere($rFiltros, $sql);

        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        
        return $array;

    }

    public function pegaMaiorPreco($rFiltros = array()){
        // $where = $this->montaWhere($rFiltros);

        $sql = "SELECT MAX(price) AS price FROM products ";

        $sql = $this->db->prepare($sql);

        // $this->bindWhere($rFiltros, $sql);
        $sql->execute();

        if ($sql->rowCount() > 0 ){
            $sql = $sql->fetch();

            return $sql['price'];
        }else{
            return '0';
        }

    } //FIM pegaMaiorPreco

    public function pegaMenorPreco($rFiltros = array()){
        $where = $this->montaWhere($rFiltros);

        $sql = "SELECT MIN(price) AS price FROM products WHERE ".implode(' AND ',$where);

        $sql = $this->db->prepare($sql);

        $this->bindWhere($rFiltros, $sql);
        $sql->execute();

        if ($sql->rowCount() > 0 ){
            $sql = $sql->fetch();

            return $sql['price'];
        }else{
            return '0';
        }

    } //FIM pegaMenorPreco

    public function pegaListaEstrelas($rFiltros = array()){
        $array = array();
        $where = $this->montaWhere($rFiltros);

        $sql = "SELECT rating,COUNT(id) AS cont_estrelas FROM products 
        WHERE ".implode(' AND ',$where)."  GROUP BY rating";

        $sql = $this->db->prepare($sql);

        $this->bindWhere($rFiltros, $sql);

        $sql->execute();

        if ($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    } //FIM pegaListaEstrelas

    public function contaProdutosPromocao($rFiltros = array()){
        $where = $this->montaWhere($rFiltros);
        $where[] = 'sale = "1"';

        $sql = "SELECT COUNT(sale) AS cont_sale FROM products WHERE ".implode(' AND ',$where);

        $sql = $this->db->prepare($sql);

        $this->bindWhere($rFiltros, $sql);
        $sql->execute();

        if ($sql->rowCount() > 0 ){
            $sql = $sql->fetch();

            return $sql['cont_sale'];
        }else{
            return '0';
        }
    }//FIM contaProdutosPromocao

    public function pegaOpcoes($rFiltros = array()){
        $groups = array(); // é o id_option
        $ids = array(); // aqui é o id dos produtos

        $where = $this->montaWhere($rFiltros);
        $sql = "SELECT id,options FROM products WHERE ".implode(' AND ',$where);
        $sql = $this->db->prepare($sql);

        $this->bindWhere($rFiltros, $sql);

        $sql->execute();

        if ($sql->rowCount() > 0 ){
            foreach ($sql->fetchAll() as $produto){
                $ops = explode(",",$produto['options']);
                $ids[]=$produto['id'];

                //MONTO UM ARRAY DAS OPÇÕES SEM REPETIÇÕES
                foreach($ops as $op){
                    if (!in_array($op,$groups)){
                        $groups[]=$op;
                    }
                }
            }
        }//FIM ($sql->rowCount() > 0

        
        $options = $this->pegaConteudoOpcoes($groups,$ids);

        return $options;

    } //FIM pegaOpcoes

    public function pegaConteudoOpcoes($rGroups,$rIds){
        $array = array();
        $options = new Options();
        //monto array com o nome das opções
        foreach($rGroups as $op){
            $array[$op]=array(
                'name'=>$options->getName($op), //NOME DA OPÇÃO
                'options' =>array() //OPÇÕES
            );
        }

        //montar array com o conteúdo de cada opção
        $sql="SELECT p_value, id_option, COUNT(id_option) AS cont FROM products_options 
        WHERE id_option IN ('".implode("','",$rGroups)."') AND id_product IN ('".implode("','",$rIds)."') 
        GROUP BY p_value ORDER BY id_option";
        
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $ops ){
                $array[$ops['id_option']]['options'][] = array(
                    'id'   =>$ops['id_option'],
                    'value'=>$ops['p_value'],
                    'count'=>$ops['cont']);
            }
        }

        return $array;

    }//FIM pegaConteudoOpcoes($groups,$ids)

/*
################################################################
# METODOS PRIVADOS, SÓ PODEM SER CHAMADOS AQUI DENTDO DO MODEL #
################################################################ 
*/

    //MÉTODO PRIVADO PARA CRIAR O WHERE 
    private function montaWhere($rFiltros){               
        $where = array('
            1=1'
        );
        //CATEGORIAS, como é só uma vai direto pro array WHERE
        if (!empty($rFiltros['category'])){
            $where[] = "id_category = :id_category";
        }

        //MARCAS
        if (!empty($rFiltros['brand'])){
            $where[] = " id_brand IN ('".implode("','",$rFiltros['brand'])."')";
        }
       
        //ESTRELAS
        if (!empty($rFiltros['filter_star'])){
            $where[] = " rating IN ('".implode("','",$rFiltros['filter_star'])."')";
        }

        //FILTRO SE PRODUTO ESTA MARCADO COMO PROMOÇÃO
        if (!empty($rFiltros['sale'])){
            $where[]=" sale='1' ";
        }

        if (!empty($rFiltros['featured'])){
            $where[]=" featured='1' ";
        }

        //FILTRO DE OPÇÕES
        if (!empty($rFiltros['options'])){
            $where[] = "products.id IN (SELECT id_product FROM  products_options 
                WHERE products_options.p_value IN('".implode("','",$rFiltros['options'])."'))";
        }

        //FILTRO DE PREÇOS
        if (!empty($rFiltros['slider0'])){
            $where[]=" price >=:slider0 " ;
        }

        if (!empty($rFiltros['slider1'])){
            $where[]=" price <=:slider1 " ;
        }

        if (!empty($rFiltros['textoBusca'])){
            $where[]="products.name LIKE :textoBusca";
        }

        return $where;

    } //FIM montaWhere

    //MÉTODO PARA PREENCHER O WHERE
    // o & FAZ COM QUE O PHP ALTERE A VARIAVEL LA EM CIMA, ONDE EU ESTOU USANDO ELA
    private function bindWhere($rFiltros, &$rSql){

        if (!empty($rFiltros['category'])){
            $rSql->bindValue(":id_category",intval($rFiltros['category']));
        } 

        //FILTRO DE PREÇOS
        if (!empty($rFiltros['slider0'])){
            $rSql->bindValue(":slider0",intval($rFiltros['slider0']));
        }
        if (!empty($rFiltros['slider1'])){
            $rSql->bindValue(":slider1",intval($rFiltros['slider1']));
        }

        //BUSCA O TERMO APENAS NO CAMPO NOME DO PRODUTO, PODEMOS MELHORAR ISSO
        if (!empty($rFiltros['textoBusca'])){
            $rSql->bindValue(':textoBusca','%'.$rFiltros['textoBusca'].'%');
        }

    } // FIM bindWhere
}
?>