<?php
require_once(ROOT_PATH . 'model/conexao.php');
session_start();

$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

try {
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
    $query->bindValue(":login", $login);
    $query->execute();

    $res = $query->fetch(PDO::FETCH_ASSOC);

    if ($res && password_verify($senha, $res['senha'])) {
        // Login bem-sucedido
        $_SESSION['login'] = $res['login'];
        $_SESSION['id'] = $res['id'];
        $_SESSION['autenticado'] = true;
        $_SESSION['mensagemLogado'] = true;

        $query_perfil = $pdo->prepare("SELECT id FROM perfil WHERE id_usuarios = :id_usuario");
        $query_perfil->bindValue(":id_usuario", $_SESSION['id']);
        $query_perfil->execute();

        $res_perfil = $query_perfil->fetch(PDO::FETCH_ASSOC);
        if ($res_perfil) {
            $_SESSION['id_perfil'] = $res_perfil['id'];
        }
        header("Location: /Ampera/menu");
        exit();
    } else {
        $_SESSION['erro_login'] = "Usuário ou senha inválidos.";
        header("Location: /Ampera/login");
        exit();
    }
} catch (PDOException $e) {
    echo "Erro ao tentar autenticar: " . $e->getMessage();
    exit();
}
