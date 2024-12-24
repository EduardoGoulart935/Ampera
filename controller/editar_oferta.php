<?php
session_start();
require_once("../model/conexao.php");

if (!isset($_SESSION['id_perfil'])) {
    die("Usuário não está logado. Faça o login novamente.");
}

$id_perfil = $_SESSION['id_perfil'];

$dados = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_oferta = $_POST['id_oferta'];
    $nome = $_POST['nome'];
    $status = $_POST['status'] ?? null;
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $contato = $_POST['contato'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem = $_FILES['imagem'];
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $novoNome = uniqid() . '.' . $extensao;
        $caminhoUpload = "../imagens/" . $novoNome;

        if (move_uploaded_file($imagem['tmp_name'], $caminhoUpload)) {
            $sql = "UPDATE ofertas 
                    SET nome = :nome, status = :status, descricao = :descricao, categoria = :categoria, 
                        contato = :contato, estado = :estado, cidade = :cidade, nome_foto = :nome_foto
                    WHERE id = :id_oferta AND id_perfil = :id_perfil";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome_foto', $novoNome);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao salvar a imagem.']);
            exit();
        }
    } else {
        $sql = "UPDATE ofertas 
                SET nome = :nome, status = :status, descricao = :descricao, categoria = :categoria, 
                    contato = :contato, estado = :estado, cidade = :cidade
                WHERE id = :id_oferta AND id_perfil = :id_perfil";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':contato', $contato);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':id_oferta', $id_oferta, PDO::PARAM_INT);
    $stmt->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Falha ao editar oferta.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}
