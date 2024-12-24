<?php
ob_start();
session_start();
require_once __DIR__ . '/vendor/autoload.php';

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Ampera/');

$url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$exibirHeaderFooter = isset($_SESSION['autenticado']) || isset($_SESSION['cadastro1_completo']);

if ($exibirHeaderFooter && !in_array($url[2] ?? '', ['cadastro', 'cadastro1', 'login', 'autenticar', 'redefinir_senha'])) {
    require_once(ROOT_PATH . 'view/header.php');
}

if ($url[1] !== "Ampera") {
    header("Location: /Ampera/login");
    exit();
}

// Switch para rotas
switch ($url[2] ?? 'login') 
{
    case 'redefinir-senha':
        if (!empty($url[3])) {
            $token = $url[3];
            include 'view/redefinir_senha.php';
        } else {
            include 'view/erro404.php';
        }
        break;
        
    case 'recuperar_senha':
        include 'view/recuperar_senha.php';
        break;

    case 'autenticarGoogle':
        include 'controller/autenticarGoogle.php';
        break;
    
    case 'autenticarGoogleCallback':
    include 'controller/autenticarGoogleCallback.php';
    break;

    case 'enviar_email':
        include 'controller/enviar_email.php';
        break;
        
    case 'alterar_senha':
        include 'controller/alterar_senha.php';
        break;

    case 'autenticar':
        include './controller/autenticar.php';
        break;

    case 'login':

        validaLogin();
        include 'view/login.php';
        break;

    case 'sobre':

        VerificaSessao();
        include 'view/sobre.php';
        break;

    case 'menu':
        
        VerificaSessao();
        include 'view/menu.php';
        break;

    case 'notificacao':
        
        VerificaSessao();
        include 'view/notificacao.php';
        break;

    case 'pedidos':
       
        VerificaSessao();
        include 'view/pedidos.php';
        break;

    case 'cadastro':
        include 'view/cadastro.php';
        break;

    case 'cadastro1':
        if (isset($_SESSION['cadastro_completo'])) 
        {
            include 'view/cadastro1.php';
        } 
        else
        {
            header("Location: /Ampera/cadastro");
            exit();
        }
        break;

    case 'perfil':
       
        VerificaSessao();
        include 'view/perfil.php';
        break;

    case 'suas_ofertas':
       
        VerificaSessao();
        include 'view/suas_ofertas.php';
        break;

    case 'criar-oferta':
       
        VerificaSessao();
        include 'view/criar_oferta.php';
        break;

    case 'logout':
        include './controller/logout.php';
        break;

    default:
        include 'view/erro404.php'; 
        exit();
}

// Inclui footer, se necessário
if ($exibirHeaderFooter && !in_array($url[2] ?? '', ['cadastro', 'cadastro1', 'login', 'autenticar', 'redefinir_senha'])) 
{
    require_once(ROOT_PATH . 'view/footer.php');
}
function validaLogin() {
    if (isset($_SESSION['autenticado'])) 
    {
        header("Location: /Ampera/menu");
        exit();
    }
}

function VerificaSessao() 
{
    if (!isset($_SESSION['id_perfil'])) 
    {
        header("Location: /Ampera/login");
        exit();
    }
}
ob_end_flush();