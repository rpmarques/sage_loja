<?php 
class Users extends model {
    
     public function verificaEmail($rEmail){
        $sql = "SELECT * FROM users WHERE email=:email";
        $sql = $this->db->prepare($sql);
            $sql->bindValue(":email",strtolower($rEmail));
            $sql->execute();
            if ($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
    } //function verificaEmail

    //RETORNA O ID DO USUARIO
    public function valida($rEmail,$rSenha){
        $user_id='';
        $sql = "SELECT * FROM users WHERE email=:email AND password=:senha ";
        $sql = $this->db->prepare($sql);
            $sql->bindValue(":email",strtolower($rEmail));
            $sql->bindValue(":senha",md5($rSenha));
            $sql->execute();
            if ($sql->rowCount() > 0){
                $sql = $sql->fetch();
                $user_id = $sql['id'];
            }
            return $user_id;
    } //function valida


    public function criaUser($rEmail,$rSenha){
        $sql = "INSERT INTO users (email,password) VALUES (:email,:senha) ";
        $sql = $this->db->prepare($sql);
            $sql->bindValue(":email",strtolower($rEmail));
            $sql->bindValue(":senha",md5($rSenha));
            $sql->execute();
            
            return $this->db->lastInsertId();
    } //function valida

    
}
?>