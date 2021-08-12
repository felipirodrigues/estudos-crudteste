<?php
class Contato{
    private $conexao;

    public function __construct(){
        $this->conexao = new PDO("mysql:dbname=estudos_crud;host=localhost","subdominio","123mudar");
    }


    // ###################
    //   Métodos do CRUD
    // ###################


    public function adicionar($nome, $email){
        if ($this->verificarEmail($email) == false){
            $insert = "INSERT INTO contatos (nome, email) VALUES (:nome, :email);";
            $preparada = $this->conexao->prepare($insert);
            $preparada->bindValue(":nome",$nome);
            $preparada->bindValue(":email",$email);
            $preparada->execute();

            echo "Contato adicionado </br>";
        }
        else{
            echo "Email já cadastrado </br>";
            return false;
        }
    }

    public function verNome($email){
        $select = "SELECT * FROM contatos WHERE email = :email";
        $preparada = $this->conexao->prepare($select);
        $preparada->bindValue(":email", $email);
        $preparada->execute();

        if ($preparada->rowCount() > 0){
            $resultado = $preparada->fetch();
            echo "O nome do dono deste email é: ".$resultado['email']."</br>";

        }
        else{
            echo "Este email não está cadastrado. </br>";
        }
    }

    public function verListaNomes(){
        $select = "SELECT * FROM contatos";
        $preparada = $this->conexao->prepare($select);
        $preparada->execute();

        if ($preparada->rowCount() > 0){
            $resultado = $preparada->fetchAll();
        ?>
            <table style="width: 400px;">
                <tr style = 'background-color: #ccc;'>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Email</td>
                </tr>
        <?php
            foreach ($resultado as $dados) {
                echo "<tr style = 'background-color: #eee;'>";
                    echo "<td>".$dados['id']."</td>";
                    echo "<td>".$dados['nome']."</td>";
                    echo "<td>".$dados['email']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "Lista vazia. </br>";
        }

    }
    // ##################
    // Métodos auxiliares
    // ##################

    private function verificarEmail($email){
        //receber o email, comparar o email com o banco, se existir algum retornar true, 
        //se não, retornar false
        $select = "SELECT * FROM contatos WHERE email = :email";
        $preparada = $this->conexao->prepare($select);
        $preparada->bindValue(":email", $email);
        $preparada->execute();

        if($preparada->rowCount()>0){
            return true;
        }
        else{
            return false;
        }


    }
}