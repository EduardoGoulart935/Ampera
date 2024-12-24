<?php
require_once(ROOT_PATH . 'model/conexao.php');
@session_start();
if (!isset($_SESSION['id_perfil'])) {
    header("Location: /Ampera/login");
    exit;
}
$idPerfil = $_SESSION['id_perfil'];
$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$idPerfil'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
    $nome = $res[0]['nome'];
} else {
    $nome = "Usuário";
}
$cons = $pdo->query("SELECT avatar FROM perfil WHERE id_usuarios = '$idPerfil'");
$resp = $cons->fetchAll(PDO::FETCH_ASSOC);
$avatar = $resp[0]['avatar'] ?? 'user.png';
// Verifica se o avatar é uma URL externa (link)
if (filter_var($avatar, FILTER_VALIDATE_URL)) {
    $avatarUrl = $avatar;
} else {
    $avatarUrl = "/Ampera/imagens/$avatar";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - Ampera</title>
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/index.css">
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/menu.css">
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        /* Encapsulando os estilos para a modal do header */
        #exampleModal .modal-dialog {
            margin-left: auto;
            margin-right: 0;
            max-width: 25%;
            animation: slideIn 0.3s ease-out;
        }

        #exampleModal .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }
        .modal-backdrop {
            position: relative;
            top: 0;
            left: 0;
            width: 200vw;
            height: 150vh;
            background-color: rgba(0, 0, 0, 0.0);
            z-index: 1050;
        }

        #exampleModal .modal-header {
            border-bottom: 1px solid #ddd;
        }

        #exampleModal .modal-body a {
            display: block;
            padding: 10px 15px;
            color: #333;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 8px;
        }

        #exampleModal .modal-body a:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        #exampleModal .modal-footer a {
            color: #dc3545;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        #exampleModal .modal-footer a:hover {
            color: #bd2130;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            #exampleModal .modal-dialog {
                max-width: 80%;
            }
        }
    </style>

</head>

<body>
    <nav>
        <div class="logo">
            <img src="/Ampera/imagens/logo.png" alt="Ampera Logo">
        </div>
        <div class="user">
            <span><?php echo htmlspecialchars($nome); ?></span>
            <img src="<?= htmlspecialchars($avatarUrl); ?>" alt="User Avatar" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#exampleModal">
        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Opções</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="menu">🏠 Início</a>
                    <a href="criar-oferta">+ Crie sua Oferta</a>
                    <a href="notificacao">🔔 Notificação</a>
                    <a href="sobre">ℹ️ Sobre</a>
                    <hr>
                    <a href="perfil">👤 Perfil</a>
                    <a href="suas_ofertas">🏷️ Suas Ofertas</a>
                    <a href="pedidos">📦 Seus Pedidos</a>
                </div>
                <div class="modal-footer">
                    <a href="/Ampera/logout">🚪 Sair</a>
                </div>
            </div>
        </div>
    </div>