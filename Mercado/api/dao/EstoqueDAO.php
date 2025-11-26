<?php
require_once __DIR__."../../database/database.php";
require_once __DIR__."../../model/Estoque.php";

class ProdutoDAO
{
    public function readAll (): array
    {
        $resultados = [];
        $query = "Select * From Estoque;";
        $statement = Database::getConnection()->query(query: $query);
        while ($linha = $statement->fetch(mode: PDO::FETCH_OBJ)) 
        {
            $produto = new Produto();
            $produto
                ->setId ($linha->Id)
                ->setNome ($linha->Nome)
                ->setEmail ($linha->Email);
            $resultados[] = $produto>JsonSerialize();
        }
        return $resultados;
    }

    public function readById (int $id): array 
    {
        $resultados = [];
        $query = "Select * From Estoque Where Id = :Id;";
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
            $produto = new Produto();
            $produto
                ->setId ($linha->Id)
                ->setNome ($linha->Nome)
                ->setDescricao($linha->Descricao)
                ->setPreco($linha->Preco)
                ->setDataLote($linha->DataLote)
                ->setDataValidade($linha->DataValidade)
                ->setQuantidade($linha->Quantidade);
            $resultados[] = $produto->JsonSerialize();
        }
        return $resultados;
    }

    public function readAllByIdCliente (string $idCliente): array
    {
        $resultados = [];
        $query = "Select * From Estoque Where Id_Cliente = :IdCliente";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":IdCliente", $idCliente, PDO::PARAM_INT);
        $statement->execute();
        
        while ($linha = $statement->fetch(mode: PDO::FETCH_OBJ))
        {
            $produto = new Produto();
            $produto
                ->setId ($linha->Id)
                ->setNome ($linha->Nome)
                ->setDescricao($linha->Descricao)
                ->setPreco($linha->Preco)
                ->setDataLote($linha->DataLote)
                ->setDataValidade($linha->DataValidade)
                ->setQuantidade($linha->Quantidade);
            $resultados[] = $produto->JsonSerialize();
        }
        return $resultados;
    }

    public function readByIdClienteIdProduto (int $idCliente, int $idProduto): array
    {
        $resultados = [];
        $query = "Select * From Estoque Where Id_Cliente = :IdCliente And Id_Produto = IdProduto;";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":IdCliente", $nome, PDO::PARAM_INT);
        $statement->bindValue (":IdProduto", $nome, PDO::PARAM_INT);
        $statement->execute();
        $linha = $statement->fetch(mode: PDO::FETCH_OBJ);

        if (!$linha)
        {
            return [];
        }
        else
        {
            $produto = new Produto();
            $produto
                ->setId ($linha->Id)
                ->setNome ($linha->Nome)
                ->setDescricao($linha->Descricao)
                ->setPreco($linha->Preco)
                ->setDataLote($linha->DataLote)
                ->setDataValidade($linha->DataValidade)
                ->setQuantidade($linha->Quantidade);
            $resultados[] = $produto->JsonSerialize();
        }
        return $resultados;
    }
}
?>