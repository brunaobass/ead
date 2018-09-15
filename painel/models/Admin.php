<?php

class Admin extends Model{
    
    private $info;
    
    public function where($campo, $condicao, $valores, $tabela = "admin") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function logado(){
        if (isset($_SESSION['lgadmin']) && !empty($_SESSION['lgadmin'])) {
            return true;
        }

        return false;
    }

    public function existeAdmin($email){
        $sql = "SELECT email FROM admin WHERE email = :email";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email",$email);

        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }

    public function inserirAdmin($nome,$email,$senha){
            $sql = "INSERT INTO admin (nome,email,senha) VALUES (:nome,:email,:senha)";

            $sql = $this->db->prepare($sql);

            $sql->bindValue(":nome",$nome);
            $sql->bindValue(":email",$email);
            $sql->bindValue(":senha",$senha);

            $sql->execute();

            $id = $this->db->lastInsertId();
            return $id;

    }

    public function fazerLogin($email,$senha){
        $sql = "SELECT id,senha FROM admin WHERE email = :email";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":email",$email);


        $sql->execute();

        if($sql->rowCount() >0){
            $resultado = $sql->fetch();
            if(password_verify($senha, $resultado['senha'])){
                $_SESSION['lgadmin'] = $resultado['id'];

                return true;
            }
        }

        return false;

    }

    public function setAdmin($id){
        if(isset($id)){
            $sql = 'SELECT * FROM admin WHERE id = "'.$id.'"';
            $sql = $this->db->query($sql);
            
            if($sql->rowCount() > 0){
                $this->info = $sql->fetch();           
            }
        }
    }

    public function getNome(){
        return $this->info['nome'];
    }
    public function getID(){
        return $this->info['id'];
    }
    public function getInfo(){
        return $this->info;
    }
    
}
