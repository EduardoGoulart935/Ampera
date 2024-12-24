<?php
require_once(ROOT_PATH . 'model/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $novaSenha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if (empty($token) || empty($novaSenha) || empty($confirmarSenha)) {
        die('Todos os campos são obrigatórios.');
    }

    if ($novaSenha !== $confirmarSenha) {
        die('As senhas não coincidem.');
    }

    try {
        $stmt = $pdo->prepare("SELECT email FROM tokens_recuperacao WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $email = $stmt->fetchColumn();

            $hashSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email");
            $stmt->bindParam(':senha', $hashSenha);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt = $pdo->prepare("DELETE FROM tokens_recuperacao WHERE token = :token");
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            echo 'Senha redefinida com sucesso.';
            Header("Location: /Ampera/login");
        } else {
            die('Token inválido.');
        }
    } catch (PDOException $e) {
        die('Erro ao redefinir senha: ' . $e->getMessage());
    }
}
?>
