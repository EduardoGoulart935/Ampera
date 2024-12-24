<?php
require_once('../model/conexao.php');
session_start();

if (!isset($_SESSION['id_perfil'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$idPedido = $data['id_pedido'] ?? null;

if (!$idPedido) {
    echo json_encode(['success' => false, 'error' => 'ID do pedido não especificado']);
    exit();
}

$sql = "DELETE FROM pedidos WHERE id = :id AND id_perfil_pedido = :id_perfil";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $idPedido, PDO::PARAM_INT);
$query->bindParam(':id_perfil', $_SESSION['id_perfil'], PDO::PARAM_INT);

try {
    $query->execute();
    if ($query->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Pedido não encontrado ou não pertence a este perfil']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro ao processar o cancelamento: ' . $e->getMessage()]);
}
