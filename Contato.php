
<?php
class Contato
{
    private $atributos;
    public function __construct()
    {
    }
    public function __set(string $atributo, $valor)
    {
        $this->atributos[$atributo] = $valor;
        return $this;
    }
    public function __get(string $atributo)
    {
        return $this->atributos[$atributo];
    }
    public function __isset($atributo)
    {
        return isset($this->atributos[$atributo]);
    }
    /**
     * Salvar o contato
     * @return boolean
     */
    public function save()
    {
        $colunas = $this->preparar($this->atributos);
        if (!isset($this->id)) {
            $query = "INSERT INTO tbl_contatos (".
                implode(', ', array_keys($colunas)).
                ") VALUES (".
                implode(', ', array_values($colunas)).");";
        } else {
            foreach ($colunas as $key => $value) {
                if ($key !== 'id') {
                    $definir[] = "{$key}={$value}";
                }
            }
            $query = "UPDATE tbl_contatos SET ".implode(', ', $definir)." WHERE id='{$this->id}';";
        }
        if ($conexao = Conexao::getInstance()) {
            $query = $conexao->prepare($query);            
            
            if ($query->execute()){
                $query->store_result();
                $t_rows = $query->num_rows;
                echo "<script>alert(\"Agenda Atualizada!\")</script>";
                return true;
            }
            
        }
        return false;
    }
    /**
     * Tornar valores aceitos para sintaxe SQL
     * @param type $dados
     * @return string
     */
    private function escapar($dados)
    {
        if (is_string($dados) & !empty($dados)) {
            return "'".addslashes($dados)."'";
        } elseif (is_bool($dados)) {
            return $dados ? 'TRUE' : 'FALSE';
        } elseif ($dados !== '') {
            return $dados;
        } else {
            return 'NULL';
        }
    }
    /**
     * Verifica se dados são próprios para ser salvos
     * @param array $dados
     * @return array
     */
    private function preparar($dados)
    {
        $resultado = array();
        foreach ($dados as $k => $v) {
            if (is_scalar($v)) {
                $resultado[$k] = $this->escapar($v);
            }
        }
        return $resultado;
    }
    /**
     * Retorna uma lista de contatos
     * @return array/boolean
     */
    public static function all()
    {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->query("SELECT * FROM tbl_contatos;");

        $result  = array();
        if ($stmt) {
            while ($rs = $stmt->fetch_object(Contato::class)) {
                $result[] = $rs;
            }
        }
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
    /**
     * Retornar o número de linhas
     * @return int/boolean
     */
    public static function count()
    {
        $conexao = Conexao::getInstance();
        $query   = $conexao->query("SELECT id FROM tbl_contatos;");
        $count   = $query->num_rows;
        if ($count) {
            return $count;
        }
        return false;
    }

    /**
     * Retornar os dados para o grafico
     * @return array
     */
    public static function chart()
    {
        $conexao = Conexao::getInstance();
        $query   = $conexao->query("SELECT id FROM tbl_contatos;");
        $count['total']   = $query->num_rows;
        $query1   = $conexao->query("SELECT nome FROM tbl_contatos WHERE nome LIKE 'a%';");
        if($query1){$count['a'] = $query1->num_rows;}else{$count['a'] = 0;}
        $query2   = $conexao->query("SELECT nome FROM tbl_contatos WHERE nome LIKE 'b%';");
        if($query2){$count['b'] = $query2->num_rows;}else{$count['b'] = 0;}
        $query3   = $conexao->query("SELECT nome FROM tbl_contatos WHERE nome LIKE 'c%';");
        if($query3){$count['c'] = $query3->num_rows;}else{$count['c'] = 0;}
        $query4   = $conexao->query("SELECT nome FROM tbl_contatos WHERE nome LIKE 'd%';");
        if($query4){$count['d'] = $query4->num_rows;}else{$count['d'] = 0;}

        if ($count) {
            return $count;
        }
        return false;
    }
    /**
     * Encontra um recurso pelo id
     * @param type $id
     * @return type
     */
    public static function find($id)
    {
        $conexao = Conexao::getInstance();
        $stmt    = $conexao->query("SELECT * FROM tbl_contatos WHERE id='{$id}';");        
        $resultado = $stmt->fetch_object(Contato::class);
        if ($resultado) {                    
            return $resultado;
        }
        return false;
    }
    /**
     * Destruir um recurso
     * @param type $id
     * @return boolean
     */
    public static function destroy($id)
    {
        $conexao = Conexao::getInstance();
        $query = $conexao->prepare("DELETE FROM tbl_contatos WHERE id='{$id}';");
        if ($query->execute()){
            return true;
        }
        return false;
    }
}