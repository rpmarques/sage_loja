<?php 
class Rates extends model {

    public function getRates($rID,$rQtde){
        $array = array();

        $sql =" SELECT rates.*, users.name AS nome_user FROM rates 
        LEFT JOIN users ON rates.id_user=users.id
         WHERE id_product = :id ORDER BY date_rated DESC LIMIT ".intval($rQtde);
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$rID);
        $sql->execute();

        if ($sql->rowCount() > 0 ){
            $array = $sql->fetchAll();
        } // fim ($sql->rowCount()>0 )

        return $array;
    } //FIM getList

}
?>