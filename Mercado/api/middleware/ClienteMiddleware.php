<?php
require_once "api/http/Response.php";

class ClienteMiddleware
{
    public function stringJsonToStdClass($requestBody): stdClass
    {
        $stdCliente = json_decode(json: $requestBody);

        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            (new Response(
                success: false,
                message: 'Cargo inválido',
                error: [
                    'code' => 'validation_error',
                    'mesagem' => 'Json inválido',
                ],
                httpCode: 400
            ))->send();
            exit();
        } 
        else if (!isset($stdCliente->Cliente)) 
        {  
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'mesagem' => 'Não foi enviado o objeto Cliente',
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        else if (!isset($stdCliente->Cliente->Nome)) 
        {  
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'mesagem' => 'Não foi enviado o nome do Cliente',
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        else if (!isset($stdCliente->Cliente->Email)) 
        {  
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'mesagem' => 'Não foi enviado o email do Cliente',
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        else if (!isset($stdCliente->Cliente->Senha)) 
        {  
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'mesagem' => 'Não foi enviada a senha do Cliente',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        $cliente = new Cliente();
        $cliente->setNome ($stdCliente->Cliente->Nome);
        return $stdCliente;
    }

    public function isValidNome (string $nome)
    {
        if (!isset($nome)) 
        {
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'message' => 'O Cliente não foi enviado'
                ],
                httpCode: 400
            ))->send();
            exit();
        } 
        else if (strlen(string: $nome) < 3) 
        {
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'message' => 'Credenciais inválidas
                    '
                ],
                httpCode: 400
            ))->send();
            exit(); 
        }
        //O nome do Cliente precisa de pelo menos 3 caracteres
        return $this;
    }

    public function isValidId (?int $id)
    {
        if (!isset($id)) 
        {
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'message' => 'O Cliente não foi enviado'
                ],
                httpCode: 400
            ))->send();
            exit();
        } 
        else if ($id < 1) 
        {
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'message' => 'O Id deve ser maior que 0'
                ],
                httpCode: 400
            ))->send();
            exit(); 
        }
        return $this;
    }

    public function hasNotById (int $Id): self
    {
        $dao = new ClienteDAO();
        $clientes = $dao->readById ($id);
        if (!empty($clientes))
        {
            (new Response(
                success: false,
                message: 'Cliente inválido',
                error: [
                    'code' => 'validation_error',
                    'message' => 'Este id Já foi Usado'
                ],
                httpCode: 400
            ))->send();
            exit(); 
        }
        return $this;
    }

    public function hasNotByNome (string $nome): self
    {
        $dao = new ClienteDAO();
        $clientes = $dao->readByName($nome);

        if (!empty($clientes))
        {
            (new Response(
                success: false,
                message: 'Nome já usado',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'O nome já foi usado',
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        return $this;
    }

    public function hasNotByEmail(string $email): self
    {
        $dao = new ClienteDAO();
        $clientes = $dao->readByEmail($email);

        if (!empty($clientes))
        {
            (new Response(
                success: false,
                message: 'E-mail já usado',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'O e-mail já foi usado',
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        return $this;
    }

    public function hasNotBySenha (string $senha): self
    {
        $dao = new ClienteDAO();
        $clientes = $dao->readBySenha($senha);

        if (!empty($clientes))
        {
            (new Response(
                success: false,
                message: 'Senha já usada',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'A senha já foi usada',
                ],
                httpCode: 400
            ))->send();
            exit();
        }
        return $this;
    }

    public function isvalidEmail (string $email): self
    {
        // Verifica se o e-mail tem um formato válido
        if (!isset($email)) {
            (new Response(
                success: false,
                message: 'E-mail inválido',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'O e-mail não foi enviado',
                ],
                httpCode: 400
            ))->send();

            exit(); // Interrompe a execução caso haja erro
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            (new Response(
                success: false,
                message: 'E-mail inválido',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();

            exit(); // Interrompe a execução caso haja erro
        }
        //O formato do e-mail é inválido

        // Se a validação passar, retorna o próprio objeto para permitir encadeamento
        return $this;
    }

    public function isvalidSenha (string $senha): self
    {
        // Verifica se a senha está vazia
        if (!isset($senha)) {
            (new Response(
                success: false,
                message: 'Senha inválida',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica o comprimento mínimo
        if (strlen($senha) < 8) {
            (new Response(
                success: false,
                message: 'Senha inválida',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos uma letra maiúscula
        if (!preg_match(pattern: '/[A-Z]/', subject: $senha)) {
            (new Response(
                success: false,
                message: 'Senha inválida',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos uma letra minúscula
        if (!preg_match('/[a-z]/', $senha)) {
            (new Response(
                success: false,
                message: 'Senha inválida',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos um número
        if (!preg_match('/[0-9]/', $senha)) {
            (new Response(
                success: false,
                message: 'Senha inválida',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        // Verifica se contém pelo menos um caractere especial
        if (!preg_match('/[\W_]/', $senha)) {
            (new Response(
                success: false,
                message: 'Senha inválida',
                error: [
                    'codigoError' => 'validation_error',
                    'message' => 'Credenciais Inválidas',
                ],
                httpCode: 400
            ))->send();
            exit();
        }

        /*
            A senha não pode estar vazia
            A senha deve ter no mínimo 8 caracteres
            A senha deve conter pelo menos uma letra maiúscula
            A senha deve conter pelo menos uma letra minúscula
            A senha deve conter pelo menos um número
            A senha deve conter pelo menos um caractere especial
        */
        return $this;
    }


}

?>