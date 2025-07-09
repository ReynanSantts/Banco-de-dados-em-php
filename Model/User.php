<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class User
{
    private $db;

    /**
     * Metodo que ira ser executado toda vez que
     * for criado de um objeto de classe -> USER
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    // Função de criar usuario
    public function registerUser($user_fullname, $email, $password)
    {
        try {
            // Inserção de dados na linguagem sql
            $sql = "INSERT INTO user (user_fullname, email, password, created_at) VALUES (:user_fullname, :email, :password , NOW())";

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            //Preparar o banco de dados para receber o comando acima
            $stmt = $this->db->prepare($sql);

            // Referenciar os dados passados pelo comando sql com os parametros da função
            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);

            // Executar tudo

            $stmt->execute();

        } catch (PDOException $error) {
            // Exibir mensagem de erro completo e parar a execução
            echo "Erro ao executar o comando: " . $error->getMessage();
            return false;
        }
    }
}

?>