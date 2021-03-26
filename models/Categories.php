<?php 
class Categories extends model {

    public function getList(){
        $array = array();

        $sql =" SELECT * FROM categories ORDER BY sub DESC";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0 ){
            foreach($sql->fetchAll() as  $item){
                $item['subs'] = array();
                $array[$item['id']] = $item;
            }

            while ($this->aindaPrecisa($array)) {
                $this->organizaCategoria($array);
            }
        } // fim ($sql->rowCount()>0 )

        return $array;
    } //FIM getList

    public function getCategoryName($rId){
        $sql =" SELECT name  FROM categories WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id",intval($rId));
            $sql->execute();
            if ($sql->rowCount() > 0){
                $sql = $sql->fetch();
                return $sql['name'];
            }
    } //FIM getCategoriName()

    public function getCategoryTree($id){
        $array = array();

        $temFilho = true;
        while ($temFilho) {
            $sql =" SELECT * FROM categories WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id",intval($id));
            $sql->execute();
            if ($sql->rowCount() > 0){
                $sql = $sql->fetch();
                $array[] = $sql;

                
                if (!empty($sql['sub'])){
                    $id = $sql['sub'];
                }else{
                    $temFilho = false;
                }
                
            }
        }
        //INVERTE O ARRAY PRA MOSTRAR NA FORMA QUE EU PRECISO
        //CATEGORIA->SUB_SUB DA SUB->SUB DA SUB DA SUB
        $array = array_reverse($array);

        return $array;
    } //FIM getCategoryTree

    //PRIVADA PQ SÓ QUERO QUE FIQUE DENTRO DO MODEL
    //VERIFICO SE TEM ALGUMA SUBCATEGORIA
    private function aindaPrecisa($rArray){
        foreach($rArray as $item){
            if (!empty($item['sub'])){
                return true;
            }
        }
        return false;
    } //FIM aindaPrecisa

    // O & antes do array permite que ele edite o array que passei no parametro
    // PRIVATE PQ É SÓ PRA SER USADA AQUI DENTRO
    private function organizaCategoria(&$rArray){
        foreach($rArray as $id => $item){
            //PROCURO SE TEM ALGO NO CAMPO sub, SE TEM CRIO UM OUTRO ARRAY DENTRO DO SUBS
            //DAI APAGOO ORIGINAL E FINALIZO 
            if (isset($rArray[$item['sub']])){
                $rArray[$item['sub']]['subs'][$item['id']] = $item;
                unset($rArray[$id]);
                break; //PARA O CÓDIGO DA FUNCTION
            }
        }

    } //FIM organizaCategoria
}
?>