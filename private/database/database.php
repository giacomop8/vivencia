<?php

class Database {

    private $conexao;

    public function __construct() {
        $user = "root";
        $senha = "";
        $dbName = 'db_vivencia';
        $dsn = "mysql:host=localhost";

        try {
            $this->conexao = new PDO($dsn, $user, $senha, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $this->criarDataBase($dbName);
            $this->useDatabase($dbName);
        } catch (PDOException $e) {
            Security::log('Falha na conexão: ' . $e->getMessage());
            throw new Exception("Falha na conexão com o banco de dados");
        }
    }

    public function getConexao() {
        return $this->conexao;
    }

    private function criarDataBase($dbName) {
        $query = "CREATE DATABASE IF NOT EXISTS $dbName";

        try {
            $this->conexao->exec($query);
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar base de dados: " . $e->getMessage());
        }
    }

    private function useDatabase($dbName) {
        try {
            $this->conexao->exec("USE $dbName");
        } catch (PDOException $e) {
            throw new Exception("Erro ao selecionar base de dados: " . $e->getMessage());
        }
    }

    public function verifyDatabase($dbName) {
        $query = "SHOW DATABASES LIKE :databaseName";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':databaseName', $dbName);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return (count($result) > 0);
    }
}

new Database();