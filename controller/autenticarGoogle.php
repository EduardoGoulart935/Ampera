<?php

require_once ROOT_PATH . 'app/Google/GoogleAuth.php';

use App\Google\GoogleAuth;

// Instancia a classe de autenticação
$googleAuth = new GoogleAuth();

header('Location: ' . $googleAuth->getLoginUrl());
exit();