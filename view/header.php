<?php
@session_start();
require_once(ROOT_PATH . 'model/conexao.php');

$id = $_SESSION['id_perfil'];
$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
    $login = $res[0]['login'];
}

$cons = $pdo->query("SELECT foto_perfil FROM perfil WHERE id = '$id'");
$resp = $cons->fetchAll(PDO::FETCH_ASSOC);

if ($total_reg > 0) {
    $foto_perfil = $resp[0]['foto_perfil'] ? $resp[0]['foto_perfil'] : 'user.png'; // Usa uma imagem padrão se não houver foto de perfil
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
</head>

<body>

    <nav>
        <div class="logo">
            <img src="/Ampera/imagens/logo.png" alt="Ampera Logo">
        </div>
        <div class="user">
            <div class="menu">
                <a href="notificacao">Notificação</a>
                <a href="suas_ofertas">Suas Ofertas</a>
                <a href="ofertas">Ofertas</a>
                <a href="sobre">Sobre</a>
                <a href="criar-oferta">Crie sua Oferta</a>
                <a href="perfil">Perfil</a>
                <span><?php echo $login ?></span>
            </div>
            <a href="/Ampera/logout"><img src="/Ampera/imagens/<?= $foto_perfil ?>" alt="User Avatar"></a>
        </div>
    </nav>