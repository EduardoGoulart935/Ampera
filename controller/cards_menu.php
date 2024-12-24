<?php
require_once('../model/conexao.php');
session_start();

if (!isset($_SESSION['id_perfil'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

$sql = "SELECT o.id, o.nome, o.descricao, o.categoria, o.contato, o.email, o.estado, o.cidade, o.status, o.nome_foto, o.id_perfil, p.nome AS nome_usu
FROM ofertas o 
JOIN perfil p ON o.id_perfil = p.id
WHERE status = 'A' #AND id_perfil = :id_perfil";
$query = $pdo->prepare($sql);
$query->bindParam(':id_perfil', $_SESSION['id_perfil'], PDO::PARAM_INT);
$query->execute();
$ofertas = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($ofertas);
?>