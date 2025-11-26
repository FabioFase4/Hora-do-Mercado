<?php
require_once "Router.php"; // https://github.com/bramus/router
require_once "api/http/Response.php";
require_once "api/utils/Logger.php";  

require_once "api/control/ClienteControl.php"; 
require_once "api/middleware/ClienteMiddleware.php";

require_once "api/control/LoginControl.php";

/**
 * Classe [Roteador]
 * 
 * Esta classe faz parte de uma API REST didática desenvolvida com o objetivo de
 * ensinar, de forma simples e prática, os principais conceitos da arquitetura REST
 * e do padrão de projeto MVC (Model-View-Controller).
 *
 * A API realiza o CRUD completo (Create, Read, Update, Delete) das tabelas `cargo` e `funcionario`,
 * sendo ideal para estudantes e desenvolvedores que estão começando com PHP moderno e boas práticas de organização.
 *
 * A construção passo a passo desta API está disponível gratuitamente na playlist do YouTube:
 * https://www.youtube.com/playlist?list=PLpdOJd7P4_HsiLH8b5uyFAaaox4r547qe
 *
 * @author      Hélio Esperidião
 * @copyright   Copyright (c) 2025 Hélio Esperidião
 * @license     GPL (GNU General Public License)
 * @website http://helioesperidiao.com
 * @github https://github.com/helioesperidiao
 * @linkedin https://www.linkedin.com/in/helioesperidiao/
 * @youtube https://www.youtube.com/c/HélioEsperidião
 * 
 */
class Roteador
{

    public function __construct(private Router $router = new Router())
    {
        $this->router = new Router();
        $this->setupHeaders();
        $this->setupClienteRoutes();
        $this->setupEstoqueRoutes();
        $this->setupLoginRoutes();
        $this->setup404Route();
        
        
    }

    private function setup404Route(): void
    {
        $this->router->set404(function (): void {
            header('Content-Type: application/json');
            (new Response(
                success: false,
                message: "Rota não encontrada",
                error: [
                    'code' => 'routing_error', 
                    'message' => 'Rota não mapeada' 
                ],
                httpCode: 404 
            ))->send();

        });
    }

    private function setupLoginRoutes (): void 
    {
        $this->router->post (pattern: "/loginCliente", fn: function (): never {
            try 
            {
                $middle = new ClienteMiddleware();
                $requestBody = file_get_contents(filename: "php://input");
                $std = $middle->stringJsonToStdClass($requestBody);
                $middle
                    ->isValidNome ($std->Cliente->Nome)
                    ->isValidEmail ($std->Cliente->Email)
                    ->isValidSenha ($std->Cliente->Senha);

                $LoginControl = new LoginControl();
                $LoginControl->login($std);
            }
            catch (Throwable $throwable) 
            {
                $this->sendErrorResponse(
                    throwable: $throwable,
                    message: 'Erro ao efetuar login'
                );
            }
            exit();
        });
    }

    private function setupClienteRoutes (): void
    {
        $this->router->get (pattern: "/", fn: function () {
            echo "";
        });
        $this->router->get (pattern: "/user", fn: function (): never {
            $control = new ClienteControl();
            $control->index();
            exit();
        });

        $this->router->get (pattern: "/user/(\d+)", fn: function ($Id): never
        {
            $control = new ClienteControl();
            $middle = new ClienteMiddleware();
            try 
            { 
                $middle->isValidId($Id);
                $control->show($Id);
                exit();
            } 
            catch (Throwable $throwable) 
            {
                $this->sendErrorResponse(
                    throwable: $throwable, 
                    message: 'Erro na seleção de dados' 
                );
                exit();
            }
            
        });

        $this->router->post (pattern: "/user", fn: function (): never {
            $control = new ClienteControl();
            $middle = new ClienteMiddleware();
            try 
            {
                $requestBody = file_get_contents(filename: "php://input");
                $std = $middle->stringJsonToStdClass($requestBody);
                $middle
                    ->isValidNome ($std->Cliente->Nome)
                    ->isValidEmail ($std->Cliente->Email)
                    ->isValidSenha ($std->Cliente->Senha)
                    ->hasNotByNome ($std->Cliente->Nome)
                    ->hasNotByEmail ($std->Cliente->Email)
                    ->hasNotBySenha ($std->Cliente->Senha);
                
                $control->store($std);
            }
            catch (Throwable $throwable) 
            {
                $this->sendErrorResponse(
                    throwable: $throwable, 
                    message: 'Erro ao inserir um novo cliente' 
                );
            }
            exit();
        });

        $this->router->put (pattern: "/user/(\d+)", fn: function ($Id): never {
            $control = new ClienteControl();
            $middle = new ClienteMiddleware();
            try 
            {
                $requestBody = file_get_contents(filename: "php://input");
                $std = $middle->stringJsonToStdClass($requestBody);
                $std->Cliente->Id = $Id;
                $middle
                    ->hasNotByNome ($std->Cliente->Nome)
                    ->hasNotByEmail ($std->Cliente->Email)
                    ->hasNotBySenha ($std->Cliente->Senha);
                
                $control->edit($std);
            }
            catch (Throwable $throwable) 
            {
                $this->sendErrorResponse(
                    throwable: $throwable, 
                    message: 'Erro ao atualizar um novo cliente' 
                ); 
            }
            exit();
        });

        $this->router->delete (pattern: "/user/(\d+)", fn: function ($Id): never {
            $control = new ClienteControl();
            $middle = new ClienteMiddleware();

            try 
            {
                $middle->isValidId($Id);
                $control->destroy($Id);
            }
            catch (Throwable $throwable) 
            {
                $this->sendErrorResponse(
                    throwable: $throwable, 
                    message: 'Erro ao excluir um cliente' 
                ); 
            }
            exit();
        });
    }

    private function setupEstoqueRoutes (): void 
    {

    }

    
    private function setupHeaders(): void
    {
        header(header: 'Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header(header: 'Access-Control-Allow-Origin: *');
        header(header: 'Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    private function sendErrorResponse(Throwable $throwable, string $message): never
    {
        Logger::Log(throwable: $throwable);

        (new Response(
            success: false,
            message: $message,
            error: [
                'code' => $throwable->getCode(),  
                'message' => $throwable->getMessage() 
            ],
            httpCode: 500  
        ))->send();

        
    }

    public function start(): void
    {
        $this->router->run();
    }
}