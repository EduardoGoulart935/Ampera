<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ROOT_PATH . 'vendor/autoload.php';
require_once(ROOT_PATH . 'model/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    try {

        $consult = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $consult->bindParam(':email', $email);
        $consult->execute();

        if ($consult->rowCount() > 0) {
            $token = bin2hex(random_bytes(32));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $consult = $pdo->prepare("INSERT INTO tokens_recuperacao (email, token, expira_em) VALUES (:email, :token, :expira)");
            $consult->bindParam(':email', $email);
            $consult->bindParam(':token', $token);
            $consult->bindParam(':expira', $expira);
            $consult->execute();

            $link = "http://localhost/Ampera/redefinir-senha/$token";
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'eduardogoulart935@gmail.com';
                $mail->Password = 'hgnb jbwf cgog kmal'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configurações do e-mail
                $mail->setFrom('eduardogoulart935@gmail.com', 'Eduardo');
                $mail->addAddress($email, 'Usuário');
                $mail->Subject = 'Recuperacao de Senha';
                $mail->Body = "Olá, \n\nClique no link abaixo para redefinir sua senha:\n$link\n\nEste link é válido por 1 hora.";
                $mail->isHTML(false);

                $mail->send();
                echo '
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f9;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                        }
                        .container {
                            max-width: 600px;
                            background-color: #ffffff;
                            border-radius: 15px;
                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                            text-align: center;
                            padding: 30px;
                            animation: fadeIn 0.5s ease-in-out;
                        }
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(-20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        .success-title {
                            font-size: 28px;
                            font-weight: bold;
                            color: #5cff82;
                            margin-bottom: 10px;
                        }
                        .success-message {
                            font-size: 16px;
                            color: #555555;
                            margin-bottom: 20px;
                        }
                        .close-button {
                            padding: 12px 30px;
                            font-size: 16px;
                            font-weight: bold;
                            background-color: #007BFF;
                            color: white;
                            border: none;
                            border-radius: 25px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            text-decoration: none;
                        }
                        .close-button:hover {
                            background-color: #0056b3;
                            box-shadow: 0 8px 15px rgba(0, 86, 179, 0.3);
                            transform: translateY(-3px);
                        }
                        .close-button:active {
                            transform: translateY(1px);
                            box-shadow: 0 5px 10px rgba(0, 86, 179, 0.2);
                        }
                    </style>
                    <div class="container">
                        <div class="success-title">E-mail enviado com sucesso!</div>
                        <div class="success-message">
                            Um link para redefinir sua senha foi enviado para o e-mail informado.<br>
                            Verifique sua caixa de entrada ou a pasta de spam.
                        </div>
                        <button class="close-button" onclick="window.close()">Fechar</button>
                    </div>
                ';

                if ($mail->send()) {
                    $_SESSION['emailEnviado'] = true;
                }
            } catch (Exception $e) {
                echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
            }
        } else {
            echo '
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f9;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                        }
                        .container {
                            max-width: 600px;
                            background-color: #ffffff;
                            border-radius: 15px;
                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                            text-align: center;
                            padding: 30px;
                            animation: fadeIn 0.5s ease-in-out;
                        }
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(-20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        .error-title {
                            font-size: 28px;
                            font-weight: bold;
                            color: #f8141f;
                            margin-bottom: 10px;
                        }
                        .error-message {
                            font-size: 16px;
                            color: #555555;
                            margin-bottom: 20px;
                        }
                        .back-button {
                            padding: 12px 30px;
                            font-size: 16px;
                            font-weight: bold;
                            background-color: #007BFF;
                            color: white;
                            border: none;
                            border-radius: 25px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            text-decoration: none;
                        }
                        .back-button:hover {
                            background-color: #0056b3;
                            box-shadow: 0 8px 15px rgba(0, 86, 179, 0.3);
                            transform: translateY(-3px);
                        }
                        .back-button:active {
                            transform: translateY(1px);
                            box-shadow: 0 5px 10px rgba(0, 86, 179, 0.2);
                        }
                    </style>
                    <div class="container">
                        <div class="error-title">E-mail não existente!</div>
                        <div class="error-message">
                            Certifique-se de que o e-mail inserido esteja 
                            cadastrado no Sistema
                        </div>
                        <a href="javascript:history.back()" class="back-button">Voltar</a>
                    </div>
                ';
        }
    } catch (PDOException $e) {
        echo "Erro ao processar a solicitação: " . $e->getMessage();
    }
}
