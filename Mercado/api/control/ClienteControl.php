<?php
require_once 'api/dao/ClienteDAO.php';
require_once "api/http/Response.php";
require_once "api/utils/Logger.php";

class ClienteControl
{
    public function index (): never
    {
        $dao = new ClienteDAO();
        $clientes = $dao->readAll ();

        (new Response(
            success: true,
            message: 'Dados selecionados com sucesso',
            data: ['clientes' => $clientes],
            httpCode: 200
        ))->send();
        exit();
    }

    public function show (int $Id): never 
    {
        $dao = new ClienteDAO();
        $cliente = $dao->readById ($Id);
  
        if ($cliente)
        {
            (new Response(
                success: true,
                message: 'Cliente encontrado com sucesso',
                data: ['clientes' => $cliente], 
                httpCode: 200  
            ))->send();
        }
        else 
        {
            (new Response(
                success: false,
                message: 'Cliente não encontrado',
                httpCode: 404
            ))->send();
        }
    }

    public function store (stdClass $std): never 
    {
        $dao = new ClienteDAO();
        $cliente = new Cliente();
        $cliente
            ->setNome ($std->Cliente->Nome)
            ->setEmail ($std->Cliente->Email)
            ->setSenha (md5($std->Cliente->Senha));
        $novo = $dao->create($cliente);

        (new Response(
            success: true,
            message: 'Cliente cadastrado com sucesso',
            data: ['clientes' => $novo],
            httpCode: 200
        ))->send();
    }

    public function edit(stdClass $std): never
    {
        $dao = new ClienteDAO();
        $nome = $std->Cliente->Nome;
        $email = $std->Cliente->Email;
        $senha = $std->Cliente->Senha;
        $cliente = new Cliente();

        $cliente->setId ($std->Cliente->Id);
        if (isset($nome))
        {
            $cliente->setNome ($nome);
        }
        if (isset($email))
        {
            $cliente->setEmail ($email);
        }
        if (isset($senha))
        {
            $cliente->setSenha ($senha);
        }

        if ($dao->update($cliente) == true) 
        {
            (new Response(
                success: true,
                message: "Atualizado com sucesso",
                data: ['clientes' => $cliente],
                httpCode: 200
            ))->send();
        } 
        else 
        {
            (new Response(
                success: false,
                message: "Não foi possível atualizar o cliente.",
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Não é possível atualizar para um cliente que já existe',
                ],
                httpCode: 400
            ))->send();
        }
        exit();
    }

    public function destroy (int $Id): never
    {
        $dao = new ClienteDAO();

        if ($dao->delete($Id) == true) 
        {
            (new Response(
                success: true,
                message: "Cliente excluído com Sucesso",
                httpCode: 200
            ))->send();
            exit();
        } 
        else 
        {
            (new Response(
                success: false,
                message: 'Não foi possível excluir o cliente',
                error: [
                    'cod' => 'delete_error',
                    'message' => 'O cliente não pode ser excluído'
                ],
                httpCode: 400
            ))->send();
            exit();
        }
    }
}
?>