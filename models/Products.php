<?php 
class Products extends model {

    //TRAZ O PRODUTOS
    // rInicioPaginacao = PONTO INICIAL DA PAGINAÇÃO
    // $rQtdePorPagina = AQUI É QTDE DE ITENS QUE VAMOS MOSTRAR POR PÁGINA
    // $rFiltros FILTROS PRA FAZER O WHERE
    public function getList($rInicioPaginacao = 0, $rQtdePorPagina = 3, $rFiltros = array()){

        $array = array();
        $where = $this->montaWhere($rFiltros);
            
        $sql =" SELECT products.*,brands.name AS nome_marca,categories.name AS nome_categoria ";
        $sql .="  FROM products ";
        $sql .=" LEFT JOIN brands ON products.id_brand=brands.id ";
        $sql .=" LEFT JOIN categories ON products.id_category=categories.id ";
        $sql .=" WHERE ".implode(' AND ',$where)."  ";
        $sql .="LIMIT $rInicioPaginacao,$rQtdePorPagina";               

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
        $where = $this->montaWhere($rFiltros);

        $sql = "SELECT MAX(price) AS price FROM products WHERE ".implode(' AND ',$where);

        $sql = $this->db->prepare($sql);

        $this->bindWhere($rFiltros, $sql);
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

/* ########################################################
METODOS PRIVADOS, SÓ PODEM SER CHAMADOS AQUI DENTDO DO MODEL
######################################################## */


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

        //FILTRO DE OPÇÕES
        if (!empty($rFiltros['options'])){
            $where[] = "products.id IN (SELECT id_product FROM  products_options 
                WHERE products_options.p_value IN('".implode("','",$rFiltros['options'])."'))";
        }

        return $where;

    } //FIM montaWhere

    //MÉTODO PARA PREENCHER O WHERE
    // o & FAZ COM QUE O PHP ALTERE A VARIAVEL LA EM CIMA, ONDE EU ESTOU USANDO ELA
    private function bindWhere($rFiltros, &$rSql){

        if (!empty($rFiltros['category'])){
            $rSql->bindValue(":id_category",intval($rFiltros['category']));
        } 
    } // FIM bindWhere
}
?>