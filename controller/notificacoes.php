<?php
session_start();

require_once("../model/conexao.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$id_perfil = $_SESSION['id_perfil'];

$sql = "SELECT n.*, o.nome AS oferta_nome, p.nome AS solicitante_nome, p.contato, p.email
        FROM notificacoes n
        JOIN ofertas o ON n.id_oferta = o.id
        JOIN perfil p ON n.id_perfil_solicitante = p.id
        WHERE n.id_perfil_recebedor = :id_perfil_recebedor AND n.visualizada = 'N'";
$query = $pdo->prepare($sql);
$query->bindParam(':id_perfil_recebedor', $id_perfil);
$query->execute();
$notificacoes = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($notificacoes);
