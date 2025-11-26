<?php
require_once "api/dao/ClienteDAO.php";
require_once "api/model/Cliente.php";
require_once __DIR__ . '/../utils/MeuTokenJWT.php';


use Firebase\JWT\MeuTokenJWT;

class LoginControl
{
    public function login(stdClass $stdLogin): never
    {
        $dao = new ClienteDAO();
        $cliente = new Cliente();

        $cliente->setNome($stdLogin->Cliente->Nome);
        $cliente->setEmail($stdLogin->Cliente->Email);
        $cliente->setSenha(md5($stdLogin->Cliente->Senha));
        $user = $dao->logar($cliente->getNome(), $cliente->getEmail(), $cliente->getSenha());

        $logado = [];
        if (isset($user['senha']))
        {
            $logado['id'] = $user['id'];
            $logado['nome'] = $user['nome'];
            $logado['email'] = $user['email'];
        }
        else 
        {
            $logado = $user;
        }

        if (empty($logado)) 
        {
            (new Response(
                success: false,
                message: 'Usuário e senha inválidos',
                httpCode: 401
            ))->send();
        } 
        else 
        {
            $claims = new stdClass();
            $claims->nome = $logado['nome'];
            $claims->email = $logado['email'];
            $claims->id = $logado['id'];
            $meuToken = new MeuTokenJWT ();
            $token = $meuToken->gerarToken($claims);

            (new Response(
                success: true,
                message: 'Usuário e senha validados',
                data: [
                    'token' => $token,
                    'cliente' => $logado
                ],
                httpCode: 200
            ))->send();
        }
        exit();
    }
}