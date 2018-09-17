
<?php

class Matricula extends Model{
    
    protected $info;
    
    public function where($campo, $condicao, $valores, $tabela = "matriculas") {
        $resultado = parent::where($campo, $condicao, $valores, $tabela);
        return $resultado;
    }
    public function query($sql) {
        return parent::query($sql);
    }
    public function all($tabela = "matriculas") {
        $resultado = parent::all($tabela);
        return $resultado;
    }
    public function insert($campo, $valor_campo, $tabela = 'matriculas') {
        parent::insert($campo, $valor_campo, $tabela);
    }

    public function delete($condicao, $valor_condicao, $tabela = 'matriculas') {
        parent::delete($condicao, $valor_condicao, $tabela);
    }
    public function update($campo, $valor_campo, $condicao, $valor_condicao, $tabela = 'matriculas') {
        parent::update($campo, $valor_campo, $condicao, $valor_condicao, $tabela);
    }
    
    public function inscrever($id_curso){
        $this->insert(
                ['id_aluno','id_curso'],
                [$_SESSION['logado'],$id_curso]
            );
    }
    
}
