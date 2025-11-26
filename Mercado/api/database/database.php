<?php
require_once "api/utils/Logger.php";
/*require_once "api/src/http/Response.php";
require_once "api/src/utils/Logger.php";*/
/**
 * Classe [Database]
 * Classe responsável por gerenciar a conexão com o banco de dados MySQL/MariaDB.
 * 
 * Implementa o padrão Singleton para garantir uma única conexão PDO durante todo o ciclo
 * de vida da aplicação. Configurações de conexão são definidas como constantes de classe.
 *
 * Padrões e características:
 * - Singleton: Garante apenas uma instância de conexão
 * - Configuração centralizada: Parâmetros de conexão em constantes
 * - Conexão lazy: Só estabelece conexão quando necessária
 * - Segurança: Propriedades privadas para evitar acesso indevido
 *
 * HOST: Endereço do servidor de banco de dados (localhost)
 * USER Nome de usuário para autenticação
 * PASSWORD Senha para autenticação
 * DATABASE Nome do banco de dados padrão
 * PORT Porta de conexão do MySQL (padrão 3306)
 * CHARACTER_SET Charset utilizado (utf8mb4 para suporte completo a Unicode)
 * CONNECTION Instância única da conexão PDO (Singleton)
 
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
 */

class Database
{
    private const HOST = '127.0.0.1';
    private const USER = 'root';
    private const PASSWORD = '';
    private const DATABASE = 'Banco4';
    private const PORT = 3306;
    private const CHARACTER_SET = 'utf8mb4';
    private static ?PDO $CONNECTION = null;

    public static function getConnection(): PDO|null
    {
        if (Database::$CONNECTION === null) 
        {
            Database::connect();
        }

        return Database::$CONNECTION;
    }

    private static function connect(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            Database::HOST,
            Database::PORT,
            Database::DATABASE,
            Database::CHARACTER_SET
        );

        Database::$CONNECTION = new PDO(
            dsn: $dsn,                        
            username: Database::USER,          
            password: Database::PASSWORD,      
            options: 
            [                         
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ 
            ]
        );

        return Database::$CONNECTION;
    }
}