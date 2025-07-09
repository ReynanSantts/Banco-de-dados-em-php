<?php

// Configurações de uso

// Exemplos de uso em outras classes = use Model/
namespace Model;

// Importação para conexão do banco de dados
use PDO;
use PDOException;

// Buscando dados de configuração de Banco de Dados
require_once __DIR__ ."../..Config/configuration.php";

class Connection {
    private  static $stmt;

    // Conexão com o banco de dados
    public static function getInstance(){
        // Criar uma nova conexao somente se ela não existir
        try{
             if(empty((self::$stmt))){
            self::$stmt = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT.";dbname=".DB_NAME. '',DB_USER, DB_PASSWORD);
        }
        } catch(PDOException $error ) {
            die("Erro ao estabelecer conexão ". $error->getMessage());
        }
        return self::$stmt;
    }
}
?>