<?php
require_once __DIR__."../../database/database.php";
require_once __DIR__."../../model/Cliente.php";

class ClienteDAO
{
    public function readAll (): array
    {
        $resultados = [];
        $query = "Select * From Clientes;";
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

    public function readByName (string $nome): array 
    {
        $resultados = [];
        $query = "Select * From Clientes Where Nome = :Nome";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":Nome", $nome, PDO::PARAM_STR);
        $statement->execute();
        $objStd = $statement->fetch(mode: PDO::FETCH_OBJ);
        if (!$objStd) 
        {
            return [];
        }
        $cliente = new Cliente();
        $cliente
            ->setId ($objStd->Id)
            ->setNome ($objStd->Nome)
            ->setEmail ($objStd->Email);
        return $cliente->JsonSerialize();
    }

    public function readByEmail (string $email)
    {
        $resultados = [];
        $query = "Select * From Clientes Where Email = :Email";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":Email", $email, PDO::PARAM_STR);
        $statement->execute();
        $objStd = $statement->fetch(mode: PDO::FETCH_OBJ);
        if (!$objStd) 
        {
            return [];
        }
        $cliente = new Cliente();
        $cliente
            ->setId ($objStd->Id)
            ->setNome ($objStd->Nome)
            ->setEmail ($objStd->Email);
        return $cliente;
    }

    public function readBySenha (string $senha)
    {
        $resultados = [];
        $query = "Select * From Clientes Where Senha = :Senha";
        $statement = Database::getConnection()->prepare($query);
        $statement->bindValue (":Senha", md5($senha), PDO::PARAM_STR);
        $statement->execute();
        $objStd = $statement->fetch(mode: PDO::FETCH_OBJ);

        if (!$objStd) 
        {
            return [];
        }
        $cliente = new Cliente();
        $cliente
            ->setId ($objStd->Id)
            ->setNome ($objStd->Nome)
            ->setEmail ($objStd->Email);
        return $cliente;
    }

    public function readById (int $id): array 
    {
        $resultados = [];
        $query = "Select * From Clientes Where Id = :Id;";
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

    public function logar (string $nome, string $email, string $senha): array
    {
        $resultados = [];
        $query = "Select * From Clientes Where Nome = :Nome And Senha = :Senha And Email = :Email";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":Nome", $nome, PDO::PARAM_STR);
        $statement->bindValue (":Senha", $senha, PDO::PARAM_STR);
        $statement->bindValue (":Email", $email, PDO::PARAM_STR);
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
        return $resultados[0];
    }

    public function create (Cliente $cliente): Cliente
    {
        $query = 'INSERT INTO Clientes (Nome, Email, Senha) VALUES (:Nome, :Email, :Senha)';
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue(':Nome', $cliente->getNome(), PDO::PARAM_STR);
        $statement->bindValue(':Email', $cliente->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':Senha', $cliente->getSenha(), PDO::PARAM_STR);
        $statement->execute();
        $cliente->setId((int) Database::getConnection()->lastInsertId());
        return $cliente;
    }

    public function update(Cliente $cliente): bool
    {
        $lista = [];
        $statement = Database::getConnection();
        if ($cliente->getNome() != "")
        {
            $lista[] = "Nome = :Nome";
        }
        if ($cliente->getEmail() != "")
        {
            $lista[] = "Email = :Email";
        }
        if ($cliente->getSenha() != "")
        {
            $lista[] = "Senha = :Senha";
        }
        if (empty($lista)) 
        {
            return false;
        }

        $query = "UPDATE Clientes SET " . implode(", ", $lista) . " WHERE Id = :Id";
        $statement = $statement->prepare($query);

        if (in_array("Nome = :Nome", $lista)) 
        {
            $statement->bindValue(':Nome', $cliente->getNome(), PDO::PARAM_STR);
        }
        if (in_array("Email = :Email", $lista)) 
        {
            $statement->bindValue(':Email', $cliente->getEmail(), PDO::PARAM_STR);
        }
        if (in_array("Senha = :Senha", $lista)) 
        {
            $statement->bindValue(':Senha', $cliente->getSenha(), PDO::PARAM_STR);
        }

        $statement->bindValue(':Id', $cliente->getId(), PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount() > 0;
    }

    public function delete (int $id): bool 
    {
        $query = "Delete From Clientes Where Id = :Id";
        $statement = Database::getConnection()->prepare(query: $query);
        $statement->bindValue (":Id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount() > 0;
    }
}
?>