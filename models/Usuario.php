<?php

class Usuario extends Model{
    
    protected $info;
    
    public function where($campo, $condicao, $valores, $tabela = "usuarios") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function query($sql) {
        return parent::query($sql);
    }
    public function all($tabela = "usuarios") {
        $resultado = parent::all($tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'usuarios') {
        parent::insert($campo, $valor_campo, $tabela);
    }

    public function delete($condicao, $valor_condicao, $tabela = 'usuarios') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'usuarios') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function logado(){
        if (isset($_SESSION['logado']) && !empty($_SESSION['logado'])) {
            return true;
        }

        return false;
    }

    public function existeEmail($email){
        $sql = "SELECT email FROM usuarios WHERE email = :email";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email",$email);

        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }
    public function existeUsername($username){
        $sql = "SELECT username FROM usuarios WHERE username = :username";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":username",$username);

        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }

    public function inserirUsuario($nome,$username,$email,$nivel,$senha,$imagem){
            $sql = "INSERT INTO usuarios (nome,username,email,nivel,senha,imagem,status) "
                    . "VALUES (:nome,:username,:email,:nivel,:senha,:imagem,0)";

            $sql = $this->db->prepare($sql);

            $sql->bindValue(":nome",$nome);
            $sql->bindValue(":username",$username);
            $sql->bindValue(":email",$email);
            $sql->bindValue(":nivel",$nivel);
            $sql->bindValue(":senha",$senha);
            $sql->bindValue(":imagem",$imagem);

            $sql->execute();

            $id = $this->db->lastInsertId();
            return $id;

    }

    public function fazerLogin($email,$senha){
        $sql = "SELECT id,senha FROM usuarios WHERE email = :email";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":email",$email);


        $sql->execute();

        if($sql->rowCount() >0){
            $resultado = $sql->fetch();
            
            if(password_verify($senha, $resultado['senha'])){

                $_SESSION['logado'] = $resultado['id'];
                return true;
            }
        }
        $_SESSION['erro'] = 'Email e/ou senha incorretos';
        return false;

    }

    public function setUsuario($id){
        if(isset($id)){
            $sql = 'SELECT * FROM usuarios WHERE id = "'.$id.'"';
            $sql = $this->db->query($sql);
            
            if($sql->rowCount() > 0){
                $this->info = $sql->fetch();           
            }
        }
    }
    
    public function confirmaCadastro($link){

        $result = array();
        $sql = "SELECT id FROM usuarios WHERE MD5(id) = '$link'";
        $query = $this->db->query($sql);
        if($query->rowCount()>0){
            $result = $query->fetch();
            $id = $result['id'];

            $this->update(
                    ['status','data_modificacao'], 
                    [1, date('Y-m-d H:i:s')],
                    ['id'], 
                    [$id]
                );
            
            return $id;
        }
        
    }
    
    public function atualizarPerfil($id,$nome,$username,$senha,$imagem){
        $this->update(
                ['nome','username','senha','imagem','data_modificacao'],
                [$nome,$username,$senha,$imagem,date('Y-m-d H:i:s')], 
                ['id'],
                [$id]
            );
        $_SESSION['success'] = 'Dados alterados com sucesso';
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
    
    public function salva_foto($foto){
        $tipos = ['image/jpg','image/png','image/jpeg'];
        $nome = md5(time(). rand(0, 9999)).'.jpg';

        if(in_array($foto['type'], $tipos)){
            move_uploaded_file($foto['tmp_name'],'assets/images/usuarios/'.$nome);
            return $nome;
        }

        return false;
    }
    
    public function getNivel($id){
        $nivel = $this->where(
                ['nivel'], 
                ['id'],
                [$id]);
        
        return $nivel[0]['nivel'];
    }
}
