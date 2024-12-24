<?php
require_once('../model/conexao.php');
session_start();

if (!isset($_SESSION['id_perfil'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

$sql = "SELECT pedidos.id, pedidos.hora_data, ofertas.nome, ofertas.descricao, ofertas.categoria, ofertas.contato, ofertas.email, ofertas.nome_foto
        FROM pedidos
        INNER JOIN ofertas ON pedidos.id_ofertas = ofertas.id
        WHERE pedidos.id_perfil_pedido = :id_perfil";
$query = $pdo->prepare($sql);
$query->bindParam(':id_perfil', $_SESSION['id_perfil'], PDO::PARAM_INT);
$query->execute();
$Pedidos = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($Pedidos);
?>
