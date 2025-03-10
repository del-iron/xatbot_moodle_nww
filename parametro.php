<?php
class paramentros {
    // Definições de constantes
    const WELCOME_MESSAGE = "Olá, eu sou Toinha! Como posso te ajudar hoje? Antes de começarmos, qual é o seu nome?";
    const DEFAULT_USER_NAME = "Usuário";

    // Credenciais do banco de dados
    private static $dbHost = 'localhost';
    private static $dbName = 'chatbot';
    private static $dbUser = 'root';
    private static $dbPass = '';
    private static $dbCharset = 'utf8mb4';

    // Método para obter a conexão com o banco de dados
    public static function getPDO() {
        $dsn = "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=" . self::$dbCharset;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            return new PDO($dsn, self::$dbUser, self::$dbPass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Função para enviar resposta e encerrar o script
    public static function send_response($response) {
        echo $response;
        exit;
    }
}
?>