<?php
require_once('../model/conexao.php');
session_start();

if (!isset($_SESSION['id_perfil'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

$sql = "SELECT id, nome, status, descricao, categoria, contato, email, estado, cidade, nome_foto, id_perfil
 FROM ofertas WHERE (status = 'I' OR status = 'A') AND id_perfil = :id_perfil";
$query = $pdo->prepare($sql);
$query->bindParam(':id_perfil', $_SESSION['id_perfil'], PDO::PARAM_INT);
$query->execute();
$Ofertas = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($Ofertas);
?>