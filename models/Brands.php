<?php 
class Brands extends model {
    //TODAS AS MARCAS
    public function getList(){

        $array = array();

        $sql ="SELECT * from brands ";
        $sql = $this->db->query($sql);

        if ($sql->rowCount()>0 ){
            $array = $sql->fetchAll();

        } // fim ($sql->rowCount()>0 )
    
        return $array;

    } //FIM getList
}
?>