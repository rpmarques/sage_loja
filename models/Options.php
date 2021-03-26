<?php
class Options extends model{
    public function getName($rId){
        $sql = "SELECT name FROM  options WHERE id=:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $rId);
        $sql->execute();

        if ($sql->rowCount()> 0 ){
            $sql = $sql->fetch();
            return $sql['name'];
        }
    }// FIM getName
}