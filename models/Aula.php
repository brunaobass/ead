<?php

class Aula extends Model{
    public function where($campo, $condicao, $valores, $tabela = "aulas") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'aulas') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    public function insert($campo, $valor_campo, $tabela = 'aulas') {
        $id_aula = parent::insert($campo, $valor_campo, $tabela); 
        
        return $id_aula;
    }
    public function delete($condicao, $valor_condicao, $tabela = 'aulas') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }

    public function getAula($id){
        $campo = ['*'];
        $condicao = ['id'];
        $valores = [$id];
        
        $aula = $this->where($campo, $condicao, $valores);
        if(count($aula) > 0){
            $aula = $aula[0];
            
            if($aula['tipo'] == 1){
                $video = new Video();
                $aula['tipo_nome'] = 'video';
                $aula['video'] = $video->getVideoAula($id);
            }
            else if($aula['tipo'] == 2){
                $questionario = new Questionario();
                $aula['tipo_nome'] = 'questionario';
                $aula['questionario'] = $questionario->getQuestionarioAula('id_aula',$id);
            }
        }
        if(!empty($_SESSION['logado'])){
            $aula['finalizada'] = $this->verificaAulaAssistida($id);
        }
        
        return $aula;
    }

    public function getAulasModulo($id_modulo){
        $campo = ['*'];
        $condicao = ['id_modulo'];
        $valores = [$id_modulo];
        $a= new Aula();
        $aulas = $this->where($campo, $condicao, $valores);
        foreach ($aulas as $aula_chave => $aula){
            $dados_aula = $a->getAula($aula['id']);
            //if($dados_aula['tipo']==)
            $aulas[$aula_chave] = $dados_aula;          
        }
        
        return $aulas;
    }
    
    public function getCursoAula($id){
        $campo = ['id_curso'];
        $condicao = ['id'];
        $valores = [$id];
        
        $curso = $this->where($campo, $condicao, $valores);
        
        return $curso[0]['id_curso'];
    }
    public function marcarAssistido($id){
        $campo = ['id_aluno','id_aula'];
        $valor_campo = [$_SESSION['logado'],$id];
        
        $this->insert($campo, $valor_campo, 'historico');
    }
    public function desmarcarAssistido($id){
        $condicoes = ['id_aluno','id_aula'];
        $valores = [$_SESSION['logado'],$id];
        
        $this->delete($condicoes, $valores, 'historico');
    }
    public function verificaAulaAssistida($id_aula){
        $resultado = $this->where(
                ['id'],
                ['id_aula','id_aluno'],
                [$id_aula,$_SESSION['logado']],
                'historico'
            );
        
        if(count($resultado) > 0){
            return true;
        }
        
        return false;
    }
    public function addAula($id_curso, $nome, $id_modulo,$tipo){
        $ordem = $this->getOrdem($id_modulo);
        
        $campos = ['id_modulo','id_curso','tipo','ordem'];
        $valores_campos = [$id_modulo,$id_curso,$tipo,$ordem];
        $id_aula = $this->insert($campos, $valores_campos);
        
        if($tipo == 1){
            $tabela = 'videos';
            
        }
        else if($tipo == 2){
            $tabela = 'questionarios';
        }
    
        $campos = ['id_aula','nome'];
        $valores_campos = [$id_aula,$nome];
        $this->insert($campos, $valores_campos,$tabela);
    }
    public function excluir($id,$tipo){
        
        if($tipo == 1){
            $this->delete(['id_aula'], [$id],'videos');
        }
        else if($tipo == 2){
            $questionario = new Questionario();
            $questionario->excluir($id);
        }
        else{
            $_SESSION['erro'] = 'Tipo de aula inválido!';
            header('Location:'.BASE_URL);
            exit;
        }
        
        $this->delete(['id'], [$id]);
    }
    
    private function getOrdem($id_modulo){
        $sql = 'SELECT ordem FROM aulas WHERE id_modulo = :id_modulo ORDER BY ordem DESC LIMIT 1';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_modulo',$id_modulo);
        
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $resultado = $sql->fetch();
            $ordem = $resultado['ordem']++;
            return $ordem;
        }
        
        return 1;
    }
}