<?php
require_once(ROOT_PATH . 'model/conexao.php');

if (!isset($_SESSION['id_perfil'])) {
    die("Usuário não está logado. Faça o login novamente.");
}
$id_usuarios = $_SESSION['id_perfil'];

$sql = "SELECT p.nome, p.email, p.contato, p.cpf_cnpj, p.data_nasc, p.avatar, 
               e.cep, e.estado, e.cidade, e.bairro, e.rua, e.pais
        FROM perfil p
        LEFT JOIN endereco e ON p.id_endereco = e.id
        WHERE p.id_usuarios = :id_usuarios";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(':id_usuarios', $id_usuarios);
$consulta->execute();
$perfil = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$perfil) {
    die("Perfil não encontrado.");
}

$exibirModal = isset($_SESSION['mensagemAtualizado']) && $_SESSION['mensagemAtualizado'];
if ($exibirModal) {
    unset($_SESSION['mensagemAtualizado']);
}

$exibirModalGoogle = isset($_SESSION['GoogleON']) && $_SESSION['GoogleON'];
if ($exibirModal) {
    unset($_SESSION['GoogleON']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="/Ampera/view/CSS/perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <style>
        .modal-backdrop {
            position: relative;
            top: 0;
            left: 0;
            width: 200vw;
            height: 150vh;
            background-color: rgba(0, 0, 0, 0.0);
            z-index: 1050;
        }

        #perfilAtualizado .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }

        #perfilAtualizado .modal-content {
            border-radius: 10px;
            border: 2px solid #28da52;
            /* Borda verde */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        #perfilAtualizado .modal-header {
            background-color: #28da52;
            color: white;
            border-bottom: 1px solid #ddd;
        }

        #perfilAtualizado .modal-header .btn-close {
            background-color: transparent;
        }

        #perfilAtualizado .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }



        #perfilGoogle .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }

        #perfilGoogle .modal-content {
            border-radius: 10px;
            border: 2px solid #28da52;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        #perfilGoogle .modal-header {
            background-color: #28da52;
            color: black;
            border-bottom: 1px solid #ddd;
        }

        #perfilGoogle .modal-header .btn-close {
            background-color: transparent;
        }

        #perfilGoogle .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }
    </style>
    <script>
        function triggerUpload() {
            document.getElementById('uploadImage').click();
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function preventSubmit(e) {
            const isGoogleAuth = <?= isset($_SESSION['GoogleON']) ? 'true' : 'false' ?>;
            if (isGoogleAuth) {
                e.preventDefault();
                const container = document.createElement('div');
                container.innerHTML = `
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f9;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                        }
                        .container {
                            max-width: 600px;
                            background-color: #ffffff;
                            border-radius: 15px;
                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                            text-align: center;
                            padding: 30px;
                            animation: fadeIn 0.5s ease-in-out;
                        }
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(-20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        .error-title {
                            font-size: 28px;
                            font-weight: bold;
                            color: #f8141f;
                            margin-bottom: 10px;
                        }
                        .error-message {
                            font-size: 16px;
                            color: #555555;
                            margin-bottom: 20px;
                        }
                        .back-button {
                            padding: 12px 30px;
                            font-size: 16px;
                            font-weight: bold;
                            background-color: #007BFF;
                            color: white;
                            border: none;
                            border-radius: 25px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            text-decoration: none;
                        }
                        .back-button:hover {
                            background-color: #0056b3;
                            box-shadow: 0 8px 15px rgba(0, 86, 179, 0.3);
                            transform: translateY(-3px);
                        }
                        .back-button:active {
                            transform: translateY(1px);
                            box-shadow: 0 5px 10px rgba(0, 86, 179, 0.2);
                        }
                    </style>
                    <div class="container">
                        <div class="error-title">Alterações não permitidas!</div>
                        <div class="error-message">
                            Você está autenticado via Google e, portanto, não pode alterar as informações do perfil.
                        </div>
                        <a href="javascript:history.back()" class="back-button">Voltar</a>
                    </div>
                `;
                document.body.innerHTML = '';
                document.body.appendChild(container);
            }
        }
    </script>
</head>

<body>

    <div class="modal fade" id="perfilAtualizado" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    O perfil foi atualizado com Sucesso!
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="perfilGoogle" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    O perfil não pode ser atualizado!
                </div>
            </div>
        </div>
    </div>

        
    <form action="controller/atualizar_usuario.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="section profile-image-section">
                <img id="profileImage" src="/Ampera/imagens/<?= $perfil['avatar'] ?>" alt="Imagem do Perfil">
                <div class="profile-actions">
                    <button type="button" class="atualizar" name="avatar" onclick="triggerUpload()">Atualizar imagem de perfil</button>
                    <input type="file" id="uploadImage" name="avatar" accept="image/*" style="display: none;" onchange="previewImage(event)" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                    <p>A imagem deve estar em JPG, JPEG ou PNG, e não pode ter mais de 10 MB.</p>
                </div>
            </div>

            <div class="section">
                <h2>Localização</h2>
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" value="<?= htmlspecialchars($perfil['cep']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="estado">Estado</label>
                <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($perfil['estado']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($perfil['cidade']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($perfil['bairro']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="rua">Rua</label>
                <input type="text" id="rua" name="rua" value="<?= htmlspecialchars($perfil['rua']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="pais">País</label>
                <input type="text" id="pais" name="pais" value="<?= htmlspecialchars($perfil['pais']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
            </div>


            <div class="section">
                <h2>Configurações de perfil</h2>
                <p>Alterar detalhes de identificação da sua conta</p>
                <br>
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($perfil['nome']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($perfil['email']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="contato">Contato</label>
                <input type="text" id="contato" name="contato" value="<?= htmlspecialchars($perfil['contato']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <label for="cpf_cnpj">CPF/CNPJ</label>
                <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="<?= htmlspecialchars($perfil['cpf_cnpj']) ?>" <?php if (isset($_SESSION['GoogleON'])) { ?> disabled <?php } ?>>
                <button class="save-changes" type="submit">Salvar alterações</button>
            </div>
        </div>
    </form>
    <br><br><br>
</body>
<script>
    <?php if ($exibirModal): ?>
        var modal = new bootstrap.Modal(document.getElementById('perfilAtualizado'));
        modal.show();
    <?php endif; ?>

    <?php if ($exibirModal): ?>
        var modal = new bootstrap.Modal(document.getElementById('GoogleON'));
        modal.show();
    <?php endif; ?>
</script>

</html>