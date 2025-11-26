<?php
require_once __DIR__."../../database/database.php";
require_once __DIR__."../../model/Produto.php";

class ProdutoDAO
{
    public function readAll (): array
    {
        $resultados = [];
        $query = "Select * From Produtos;";
        $statement = Database::getConnection()->query(query: $query);
        while ($linha = $statement->fetch(mode: PDO::FETCH_OBJ)) 
        {
            $cliente = new Cliente();
            $cliente
                ->setId ($linha->Id)
                ->setNome ($linha->Nome)
                ->setEmail ($linha->Email);
            $resultados[] = $cliente->JsonSerialize();
        }
        return $resultados;
    }

    public function readById (int $id): array 
    {
        $resultados = [];
        $query = "Select * From Produtos Where Id = :Id;";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":Id", $id, PDO::PARAM_INT);
        $statement->execute();
        $linha = $statement->fetch(mode: PDO::FETCH_OBJ);

        if (!$linha)
        {
            return [];
        }
        else
        {
            $cliente = new Cliente();
            $cliente
                ->setId ($linha->Id)
                ->setNome ($linha->Nome)
                ->setEmail ($linha->Email);
            $resultados[] = $cliente->JsonSerialize();
        }
        return $resultados;
    }
}
?>