<?php 
class Purchases extends model {
                   
    public function criaVenda($user_id,$total,$tipo){
        $sql = "INSERT INTO purchases (id_user,total_amount,payment_type,payment_status) 
                    VALUE (:id_user,:total_amount,:payment_type,1); ";
        $sql = $this->db->prepare($sql);
            $sql->bindValue(":id_user",$user_id);
            $sql->bindValue(":total_amount",$total);
            $sql->bindValue(":payment_type",$tipo);
            $sql->execute();
            
            return $this->db->lastInsertId();
    } //function valida

    public function addItem($id_venda,$item_id,$item_qtde,$item_price){
        $sql="INSERT INTO  purchases_products
            (id_purchase,id_product,quantity,price) 
            VALUE (:id_purchase,:id_product,:quantity,:price);";

        $sql= $this->db->prepare($sql);
        $sql->bindValue(":id_purchase",$id_venda);
        $sql->bindValue(":id_product",$item_id);
        $sql->bindValue(":quantity",$item_qtde);
        $sql->bindValue(":price",$item_price);
        $sql->execute();

    } //FIM addItem

    public function aprovaVenda($rID){
        $sql = "UPDATE purchases set payment_status = :status WHERE id=:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":status",'3');
        $sql->bindValue(":id",$rID);
        $sql->execute();
    }

    public function cancelaVenda($rID){
        $sql = "UPDATE purchases set payment_status = :status WHERE id=:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":status",'7');
        $sql->bindValue(":id",$rID);
        $sql->execute();
    }
}
