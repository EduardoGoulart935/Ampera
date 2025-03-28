<?php
session_start();
require_once("../model/conexao.php");

if (!isset($_SESSION['id_perfil'])) {
    die("Usuário não está logado. Faça o login novamente.");
}

$id_usuarios = $_SESSION['id_perfil'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contato = $_POST['contato'];
    $cpf_cnpj = $_POST['cpf_cnpj'];

    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $pais = $_POST['pais'];

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $extensao = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $tamanho_maximo = 10 * 1024 * 1024; // 10MB
        $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
    
        if (in_array(strtolower($extensao), $extensoes_permitidas) && $_FILES['avatar']['size'] <= $tamanho_maximo) {
            $nome_arquivo = uniqid() . '.' . $extensao;
            $destino = $_SERVER['DOCUMENT_ROOT'] . '/Ampera/imagens/' . $nome_arquivo; 
    
            echo "Destino do arquivo: " . $destino . "<br>";
            var_dump($_FILES['avatar']);
    
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destino)) {
                // Atualiza a imagem no banco de dados
                $sql_foto = "UPDATE perfil SET avatar = :avatar WHERE id_usuarios = :id_usuarios";
                $stmt_foto = $pdo->prepare($sql_foto);
                $stmt_foto->bindParam(':avatar', $nome_arquivo);
                $stmt_foto->bindParam(':id_usuarios', $id_usuarios);
                if (!$stmt_foto->execute()) {
                    var_dump($stmt_foto->errorInfo());
                    exit;
                }
    
                if ($stmt_foto->execute()) {
                    echo "Foto de perfil atualizada com sucesso!";
                } else {
                    echo "Erro ao atualizar a foto de perfil.";
                    exit;
                }
            }
        }
    }

    $sql_perfil = "UPDATE perfil SET nome = :nome, email = :email, contato = :contato, cpf_cnpj = :cpf_cnpj WHERE id_usuarios = :id_usuarios";
    $stmt = $pdo->prepare($sql_perfil);
    $stmt->bindParam(':nome', $usuario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contato', $contato);
    $stmt->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt->bindParam(':id_usuarios', $id_usuarios);

    $sql_endereco = "UPDATE endereco SET cep = :cep, estado = :estado, cidade = :cidade, bairro = :bairro, rua = :rua, pais = :pais WHERE id = (SELECT id_endereco FROM perfil WHERE id_usuarios = :id_usuarios)";
    $stmt2 = $pdo->prepare($sql_endereco);
    $stmt2->bindParam(':cep', $cep);
    $stmt2->bindParam(':estado', $estado);
    $stmt2->bindParam(':cidade', $cidade);
    $stmt2->bindParam(':bairro', $bairro);
    $stmt2->bindParam(':rua', $rua);
    $stmt2->bindParam(':pais', $pais);
    $stmt2->bindParam(':id_usuarios', $id_usuarios);

    if ($stmt->execute() && $stmt2->execute()) {
        $_SESSION['mensagemAtualizado'] = true;
        header('Location: ../perfil');
        exit;
    } else {
        $_SESSION['mensagemErro'] = true;
        exit;
    }
}
