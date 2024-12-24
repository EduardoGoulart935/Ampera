<?php
    require_once(ROOT_PATH . 'model/conexao.php');

    if (!isset($_SESSION['id_perfil'])) {
        die("Usuário não está logado. Faça o login novamente.");
    }

    $id_perfil = $_SESSION['id_perfil'];
    $sql = "SELECT p.contato, p.email, e.estado, e.cidade
    FROM perfil p
    JOIN endereco e ON p.id_endereco = e.id
    WHERE id_usuarios = :id_perfil";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_perfil', $id_perfil);
    $stmt->execute();
    $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($perfil))
    {
        @$contato = htmlspecialchars($perfil['contato']);
        @$email = htmlspecialchars($perfil['email']);
        @$estado = htmlspecialchars($perfil['estado']);
        @$cidade = htmlspecialchars($perfil['cidade']);
    }
   
    $exibirModal = isset($_SESSION['OfertaCriada']) && $_SESSION['OfertaCriada'];
    if ($exibirModal) {
        unset($_SESSION['OfertaCriada']);
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ampera - Criar Oferta</title>
    <link rel="stylesheet" href="/Ampera/view/CSS/criar_oferta.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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

        /* Encapsulando os estilos para a modal de oferta */
        #ofertaCriadaModalOferta .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }

        .modal-backdrop {
            position: relative;
            top: 0;
            left: 0;
            width: 200vw;
            height: 150vh;
            background-color: rgba(0, 0, 0, 0.0);
            z-index: 1050;
        }

        #ofertaCriadaModalOferta .modal-content {
            border-radius: 10px;
            border: 2px solid #28a745;
            /* Borda verde */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        #ofertaCriadaModalOferta .modal-header {
            background-color: #28a745;
            color: white;
            /* Texto branco */
            border-bottom: 1px solid #ddd;
        }

        #ofertaCriadaModalOferta .modal-header .btn-close {
            background-color: transparent;
        }

        #ofertaCriadaModalOferta .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }

        #ofertaCriadaModalOferta .modal-footer {
            display: flex;
            justify-content: center;
            padding: 15px;
        }

        #ofertaCriadaModalOferta .modal-footer .btn {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        #ofertaCriadaModalOferta .modal-footer .btn:hover {
            background-color: #218838;
        }
    </style>

</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="ofertaCriadaModalOferta" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    A sua oferta foi criada com sucesso!
                </div>
            </div>
        </div>
    </div>

    <div class="negrito">
        <div class="container">
            <div class="section">
                <h2>Detalhes</h2>
                <form action="controller/cadastrar_ofertas.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nome" placeholder="Nome da sua Oferta" required>
                    <textarea name="descricao" rows="5" cols="30" placeholder="Digite sua descrição"></textarea>
                    Categoria:
                    <select name="categoria" required>
                        <option value="Tecnologia">Tecnologia</option>
                        <option value="Moda e Vestuário">Moda e Vestuário</option>
                        <option value="Beleza e Cuidados Pessoais">Beleza e Cuidados Pessoais</option>
                        <option value="Casa e Decoração">Casa e Decoração</option>
                        <option value="Esportes e Lazer">Esportes e Lazer</option>
                        <option value="Alimentos e Bebidas">Alimentos e Bebidas</option>
                        <option value="Automóveis e Acessórios">Automóveis e Acessórios</option>
                        <option value="Serviços">Serviços</option>
                        <option value="Brinquedos e Jogos">Brinquedos e Jogos</option>
                        <option value="Livros, Filmes e Música">Livros, Filmes e Música</option>
                        <option value="Animais e Acessórios">Animais e Acessórios</option>
                        <option value="Saúde e Bem-estar">Saúde e Bem-estar</option>
                        <option value="Eletrônicos e Eletrodomésticos">Eletrônicos e Eletrodomésticos</option>
                        <option value="Artigos Infantis">Artigos Infantis</option>
                    </select>
                    <br>
                    Status:
                    <select name="status" required>
                        <option value="A">Ativo</option>
                        <option value="I">Inativo</option>
                    </select>
                    Estado:
                    <input type="text" name="estado" placeholder="Estado" value="<?= $estado ?>" required>
                    Cidade:

                    <input type="text" name="cidade" placeholder="Cidade" value="<?= $cidade ?>" required>

            </div>
            <div class="section">
                <h2>Foto</h2>
                <div class="upload-box" id="uploadBox">
                    <img id="preview" src="/Ampera/imagens/upload.png" name="nome_foto" alt="Miniatura" class="placeholder">
                    <p>Fazer upload de miniatura</p>
                    <button type="button" id="uploadBtn">Procurar</button>
                    <input type="file" name="nome_foto" accept="image/*" id="uploadInput" required>
                    <p>ou arraste os arquivos até aqui</p>
                </div>
                <div class="contato">
                    <h2>Contato</h2>
                    <input type="text" name="contato" id="contato" value="<?= $contato ?>" required>
                    <input type="email" name="email" value="<?= $email ?>" required>
                    <button class="create-offer" type="submit">Criar oferta</button>
                </div>
            </div>

            </form>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#contato').mask('(00) 00000-0000');
        });

        document.getElementById('uploadInput').onchange = function(evt) {
            const files = evt.target.files;
            if (files.length) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            }
        };

        document.getElementById('uploadBtn').onclick = function() {
            document.getElementById('uploadInput').click();
        };

            <?php if ($exibirModal): ?>
                var modal = new bootstrap.Modal(document.getElementById('ofertaCriadaModalOferta'));
                modal.show();
                <?php endif; ?>
    </script>
</body>

</html>