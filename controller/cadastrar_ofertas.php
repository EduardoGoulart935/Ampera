<?php
require_once('../model/conexao.php');

session_start();

$id_perfil = $_SESSION['id_perfil'];
var_dump($id_perfil);
$nome       = $_POST["nome"];
$descricao  = $_POST["descricao"];
$categoria  = $_POST["categoria"];
$contato    = $_POST["contato"];
$email      = $_POST["email"];
$status     = $_POST["status"];
$estado     = $_POST['estado'];
$cidade      = $_POST['cidade'];

if (isset($_FILES['nome_foto']) && $_FILES['nome_foto']['error'] == UPLOAD_ERR_OK) {
  
    $uploadDir = '../imagens/';
    $uploadFile = $uploadDir . basename($_FILES['nome_foto']['name']);

    if (move_uploaded_file($_FILES['nome_foto']['tmp_name'], $uploadFile)) {
        $nome_foto = $_FILES['nome_foto']['name'];
    } else {
        die("Erro ao fazer upload da foto.");
    }
} else {
    die("Nenhuma foto enviada.");
}

$sql = "INSERT INTO ofertas (nome, descricao, categoria, contato, email, estado, cidade, status, nome_foto, id_perfil) 
        VALUES (:nome, :descricao, :categoria, :contato, :email, :estado, :cidade, :status, :nome_foto, :id_perfil);";

$ins = $pdo->prepare($sql);
if ($ins === false) {
    die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
}

$ins->bindParam(':nome', $nome);
$ins->bindParam(':descricao', $descricao);
$ins->bindParam(':categoria', $categoria);
$ins->bindParam(':contato', $contato);
$ins->bindParam(':email', $email);
$ins->bindParam(':estado', $estado);
$ins->bindParam(':cidade', $cidade);
$ins->bindParam(':status', $status);
$ins->bindParam(':nome_foto', $nome_foto);
$ins->bindParam(':id_perfil', $id_perfil);

if ($ins->execute()) {
    $_SESSION['OfertaCriada'] = true;
    header("Location: /Ampera/criar-oferta");
    exit;
} else {
    echo "Erro: " . implode(", ", $ins->errorInfo());
}
