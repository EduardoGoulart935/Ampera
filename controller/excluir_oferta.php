<?php
require_once('../model/conexao.php');

session_start(); 
if (!isset($_SESSION['id_perfil'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents("php://input"), true);
    $id_oferta = $dados['id_oferta'] ?? null;

    if (!empty($id_oferta) && is_numeric($id_oferta)) {
        try {
            // Inicia a transação
            $pdo->beginTransaction();

            // Exclui os pedidos relacionados à oferta
            $sqlPedidos = "DELETE FROM pedidos WHERE id_ofertas = :id_oferta";
            $stmtPedidos = $pdo->prepare($sqlPedidos);
            $stmtPedidos->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
            $stmtPedidos->execute();

            // Exclui as notificações relacionadas à oferta
            $sqlNotificacoes = "DELETE FROM notificacoes WHERE id_oferta = :id_oferta";
            $stmtNotificacoes = $pdo->prepare($sqlNotificacoes);
            $stmtNotificacoes->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
            $stmtNotificacoes->execute();

            // Exclui a oferta
            $sqlOferta = "DELETE FROM ofertas WHERE id = :id_oferta AND id_perfil = :id_perfil";
            $stmtOferta = $pdo->prepare($sqlOferta);
            $stmtOferta->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
            $stmtOferta->bindParam(':id_perfil', $_SESSION['id_perfil'], PDO::PARAM_INT);
            $stmtOferta->execute();

            // Confirma a transação
            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Reverte a transação em caso de erro
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir oferta: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID inválido.']);
    }
}
