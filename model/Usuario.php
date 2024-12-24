<?php

require_once 'conexao.php';

class Usuario 
{
    private $pdo;

    public function __construct() 
    {
        global $pdo; // Usa a conexão global definida em `conexao.php`
        $this->pdo = $pdo;
    }

    public function salvarUsuarioGoogle($dados) 
    {
        $sql = "INSERT INTO usuarios (nome, sobrenome, email, avatar) 
                VALUES (:nome, :sobrenome, :email, :avatar)
                ON DUPLICATE KEY UPDATE avatar = :avatar";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute
        ([
            ':nome'      => $dados['nome'],
            ':sobrenome' => $dados['sobrenome'],
            ':email'     => $dados['email'],
            ':avatar'    => $dados['avatar']
        ]);
    }
}
