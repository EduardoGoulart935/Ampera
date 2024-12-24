<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../model/conexao.php';

use App\Google\GoogleAuth;

if (isset($_GET['code'])) {
    try {
        $googleAuth = new GoogleAuth();
        $userInfo = $googleAuth->authenticate($_GET['code']);

        // Dados do Google retornados
        $nome       = $userInfo['givenName']    ?? '';
        $sobrenome  = $userInfo['familyName']   ?? '';
        $email      = $userInfo['email']        ?? '';
        $avatar     = $userInfo['picture']      ?? '';

        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $stmt = $pdo->prepare("
                INSERT INTO usuarios (nome, sobrenome, email, avatar) 
                VALUES (:nome, :sobrenome, :email, :avatar)
            ");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':sobrenome', $sobrenome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->execute();

            $idUsuario = $pdo->lastInsertId();
        } else {

            $idUsuario = $usuario['id'];
            $stmt = $pdo->prepare("
                UPDATE usuarios SET avatar = :avatar WHERE id = :id
            ");
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':id', $idUsuario);
            $stmt->execute();
        }

        $stmt = $pdo->prepare("SELECT id FROM perfil WHERE id_usuarios = :id_usuarios");
        $stmt->bindParam(':id_usuarios', $idUsuario);
        $stmt->execute();
        $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$perfil) {
            $stmt = $pdo->prepare("
                INSERT INTO perfil (nome, sobrenome, email, avatar, id_usuarios)
                VALUES (:nome, :sobrenome, :email, :avatar, :id_usuarios)
            ");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':sobrenome', $sobrenome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':id_usuarios', $idUsuario);
            $stmt->execute();

            $idPerfil = $pdo->lastInsertId();
        } else {
            $idPerfil = $perfil['id'];
        }

        $_SESSION['autenticado'] = true;
        $_SESSION['GoogleON'] = true;
        $_SESSION['id_usuario'] = $idUsuario;
        $_SESSION['id_perfil'] = $idPerfil;
        $_SESSION['nome'] = $nome;
        $_SESSION['sobrenome'] = $sobrenome;
        $_SESSION['email'] = $email;
        $_SESSION['avatar'] = $avatar;

        header("Location: /Ampera/menu");
        exit();
    } catch (Exception $e) {
        echo 'Erro ao autenticar com o Google: ' . $e->getMessage();
        header("Location: /Ampera/login");
        exit();
    }
} else {
    header("Location: /Ampera/login");
    exit();
}
