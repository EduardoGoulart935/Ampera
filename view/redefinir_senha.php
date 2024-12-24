<?php
require_once(ROOT_PATH . 'model/conexao.php');

if (!isset($token) || empty($token)) {
    die('Token não fornecido.');
}

try {
    $stmt = $pdo->prepare("SELECT email, expira_em FROM tokens_recuperacao WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o token expirou
        if (strtotime($tokenData['expira_em']) < time()) {
            die('O link de redefinição de senha expirou. Solicite um novo link.');
        }
        echo '
        <!DOCTYPE html>
        

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="initial-scale=1, width=device-width">
            <link rel="stylesheet" href="/Ampera/view/CSS/cadastro.css" />
        </head>

        <body>
             <div class="register-container">
                <h1>Redefinir Senha</h1>
                <form action="/Ampera/alterar_senha" method="POST">
                    <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">

                    <div class="floating-label-container">
                        <input type="password" name="senha" placeholder=" " required/>
                        <label for="senha">Nova Senha</label>
                    </div>
                    <div class="floating-label-container">
                        <input type="password" name="confirmar_senha" placeholder=" " required/>
                        <label for="senha">Confirme a Senha</label>
                    </div>

                   <button class="register-btn" name="registrarText" type="submit">Redefinir</button>
                </form>
            </div>
        </body>
        </html>
        ';
    } else {
        die('Token inválido.');
    }
} catch (PDOException $e) {
    die('Erro ao verificar o token: ' . $e->getMessage());
}
