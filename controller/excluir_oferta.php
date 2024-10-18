<?php
session_start();
require_once('../model/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id_oferta']) && is_numeric($data['id_oferta'])) {
        $id_oferta = $data['id_oferta'];

        try {
            $sql = "DELETE FROM ofertas WHERE id = :id_oferta";
            $excluir = $pdo->prepare($sql);

            $excluir->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);

            if ($excluir->execute()) {
                echo json_encode(['success' => true, 'message' => 'Oferta excluída com sucesso.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir oferta.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID da oferta inválido ou não fornecido.']);
    }
} else {
    http_response_code(405); 
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
