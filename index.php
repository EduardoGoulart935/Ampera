<?php
session_start();

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Ampera/');

$url = explode("/", $_SERVER['REQUEST_URI']);

function validaLogin(){
   if (!isset($_SESSION['id_perfil'])) {
        include 'view/login.php';
        exit();
    } 
}
if(isset($_SESSION['id_perfil'])){
    require_once(ROOT_PATH . 'view/header.php');
}


if ($url[1] != "Ampera") {
    validaLogin(); 
    include 'view/login.php';
    exit; 
}

if (!isset($url[2])) {
    validaLogin();
    include 'view/login.php'; 
    exit;
}

if (count($url) > 5){
    if (!empty($url[5])){
        include 'view/erro404.php'; 
        exit;    
    }
}

// Chamadas das rotas
switch ($url[2]) {
    case 'autenticar':
       include './controller/autenticar.php';
       break;
    case 'login':
        include 'view/login.php'; 
        break;
        case 'sobre':
            include 'view/sobre.php'; 
            break;
    case 'menu':
        validaLogin();
        include 'view/menu.php';
        break;
        case 'notificacao':
            validaLogin();
            include 'view/notificacao.php';
            break;
    case 'cadastro':
        include 'view/cadastro.php';
        break;
    case 'cadastro1':
        if (isset($_SESSION['cadastro_completo'])) {
            include 'view/cadastro1.php';
        } else {
            header("Location: Ampera/cadastro"); 
            exit();
        }
        break;
    case 'perfil':
        validaLogin();
        include 'view/perfil.php';
        break;
    case 'suas_ofertas':
        validaLogin();
        include 'view/suas_ofertas.php';
        break;
    case 'criar-oferta':
        validaLogin();
        include 'view/criar_oferta.php';
        break;
    case 'logout':
        include './controller/logout.php';
        break;
    default:
        validaLogin();
        include 'view/login.php'; 
        break;
}

if(isset($_SESSION['id_perfil'])){
    require_once(ROOT_PATH . 'view/footer.php');
}


?>
