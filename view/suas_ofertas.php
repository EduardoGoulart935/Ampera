<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suas Ofertas - Ampera</title>
    <link rel="stylesheet" href="/Ampera/view/CSS/suas_ofertas.css">

    <style>
        .modalos {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modalos.show {
            display: block;
            opacity: 1;
        }

        .modal-contente {
            background-color: #f0f8ff;
            margin: 5% auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 600px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            color: #004080;
            float: right;
            font-size: 24px;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .close:hover,
        .close:focus {
            color: #002060;
            text-decoration: none;
        }

        .modal-contente input[type="text"],
        .modal-contente input[type="email"],
        .modal-contente input[type="password"],
        .modal-contente input[type="number"],
        .modal-contente input[type="date"],
        .modal-contente select,
        .modal-contente textarea {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0 16px 0;
            border: 1px solid #b0c4de;
            border-radius: 5px;
            background-color: #f9fcff;
            font-size: 16px;
            color: #004080;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .modal-contente input[type="text"]:focus,
        .modal-contente input[type="email"]:focus,
        .modal-contente input[type="password"]:focus,
        .modal-contente input[type="number"]:focus,
        .modal-contente input[type="date"]:focus,
        .modal-contente select:focus,
        .modal-contente textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        .modal-contente .divider {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        .modal-contente .button-group {
            display: flex;
            gap: 10px;
        }

        .modal-contente .save-button {
            width: 100%;
            padding: 12px 0;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal-contente .save-button:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        .modal-contente .cancel-button {
            width: 100%;
            padding: 12px 0;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal-contente .cancel-button:hover {
            background-color: #c82333;
            transform: scale(1.02);
        }

        .modal-contente label[for="imagem_oferta"] {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #004080;
        }

        .modal-contente input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #cddff3;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
        }

        .custom-file-upload:hover {
            background-color: #2705ffb4;
            transform: scale(1.02);
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="titulo-ofertas">Suas Ofertas</h1>
        <p class="subtitulo-ofertas">Gerencie e atualize com facilidade todas as informações importantes das suas ofertas.</p>
        <br>
        <div id="ofertas-container"></div>
    </div>

    <div id="editarModal" class="modalos">
        <div class="modal-contente">
            <span class="close" onclick="fecharModalEdit()">&times;</span>
            <h2>Editar Oferta</h2>
            <div class="divider"></div>
            <form id="formEditarOferta" enctype="multipart/form-data">
                <input type="hidden" id="id_oferta">

                <label for="imagem_oferta" class="custom-file-upload">Escolher Imagem</label>
                <input type="file" id="imagem_oferta" accept="image/*">


                <label for="nome">Nome da Oferta:</label>
                <input type="text" id="nome_oferta" required><br>
                Status:
                <select name="status" id="status" required>
                    <option value="A">Ativo</option>
                    <option value="I">Inativo</option>
                </select>
                <br>
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao_oferta" required><br>

                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria_oferta" required>
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
                <label for="contato">Contato:</label>
                <input type="text" id="contato_oferta" required><br>
                <label for="estado">Estado:</label>
                <input type="text" id="estado" required><br>
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" required><br><br>

                <div class="button-group">
                    <button type="button" class="cancel-button" onclick="fecharModalEdit()">Cancelar</button>
                    <button type="button" class="save-button" onclick="salvarEdicao()">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="confirmarExclusaoModal" class="modalos">
        <div class="modal-contente">
            <span class="close" onclick="fecharModal('confirmarExclusaoModal')">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Você tem certeza de que deseja excluir esta oferta?</p>
            <div class="button-group">
                <button class="cancel-button" onclick="fecharModal('confirmarExclusaoModal')">Cancelar</button>
                <button class="save-button" onclick="confirmarExclusao()">Excluir</button>
            </div>
        </div>
    </div>

    <div id="sucessoExclusaoModal" class="modalos">
        <div class="modal-contente">
            <span class="close" onclick="fecharModal('sucessoExclusaoModal')">&times;</span>
            <h2>Sucesso</h2>
            <p>Oferta excluída com sucesso!</p>
            <button class="save-button" onclick="fecharModal('sucessoExclusaoModal')">OK</button>
        </div>
    </div>


</body>
<script>
    function criarCardOferta(oferta) {
        const card = document.createElement('div');
        card.classList.add('oferta-card');

        card.innerHTML = `
                <div class="image">
                    <img src="/Ampera/imagens/${oferta.nome_foto}" alt="${oferta.nome}">
                </div>
                <div class="info">
                    <h2>${oferta.nome}</h2>
                    <p>${oferta.descricao}</p>
                    <p><strong>Categoria:</strong> ${oferta.categoria}</p>
                    <p><strong>Contato:</strong> ${oferta.contato}</p>
                    <strong>Endereço:</strong> <span class="">${oferta.estado} - ${oferta.cidade}</span>
                    <p><strong>Email:</strong> ${oferta.email}</p>
                    <div class="buttons">
                        <button class="edit-button" onclick="abrirModal(${oferta.id}, '${oferta.nome}', 
                        '${oferta.status}', '${oferta.descricao}', '${oferta.categoria}', '${oferta.contato}', '${oferta.estado}','${oferta.cidade}')">Editar</button>
                        <button class="delete-button" onclick="excluirOferta(${oferta.id})">Excluir</button>
                    </div>
                </div>
            `;
        document.getElementById('ofertas-container').appendChild(card);
    }

    function abrirModal(id, nome, status, descricao, categoria, contato, estado, cidade, mensagem = null) {
        if (id !== null) document.getElementById('id_oferta').value = id;
        if (nome !== null) document.getElementById('nome_oferta').value = nome;
        if (descricao !== null) document.getElementById('descricao_oferta').value = descricao;
        if (categoria !== null) document.getElementById('categoria_oferta').value = categoria;
        if (contato !== null) document.getElementById('contato_oferta').value = contato;
        if (estado !== null) document.getElementById('estado').value = estado;
        if (cidade !== null) document.getElementById('cidade').value = cidade;

        if (mensagem) {
            const mensagemDiv = document.createElement('div');
            mensagemDiv.textContent = mensagem;
            mensagemDiv.style.color = 'green';
            mensagemDiv.style.marginBottom = '10px';
            document.querySelector('.modal-contente').prepend(mensagemDiv);

            setTimeout(() => mensagemDiv.remove(), 3000);
        }

        document.getElementById('editarModal').style.display = 'block';
    }

    function fecharModalEdit() {
        const modal = document.getElementById('editarModal');
        modal.style.display = 'none';
        modal.classList.remove('show');
        location.reload();
    }
    window.onclick = function(event) {
        const modal = document.getElementById('editarModal');
        if (event.target === modal) {
            fecharModalEdit();
        }
    };

    function salvarEdicao() {
        const id = document.getElementById('id_oferta').value;
        const nome = document.getElementById('nome_oferta').value;
        const descricao = document.getElementById('descricao_oferta').value;
        const categoria = document.getElementById('categoria_oferta').value;
        const contato = document.getElementById('contato_oferta').value;
        const status = document.getElementById('status').value;
        const estado = document.getElementById('estado').value;
        const cidade = document.getElementById('cidade').value;
        const imagem = document.getElementById('imagem_oferta').files[0];

        const formData = new FormData();
        formData.append('id_oferta', id);
        formData.append('nome', nome);
        formData.append('status', status);
        formData.append('descricao', descricao);
        formData.append('categoria', categoria);
        formData.append('contato', contato);
        formData.append('estado', estado);
        formData.append('cidade', cidade);
        if (imagem) {
            formData.append('imagem', imagem);
        }


        fetch('/Ampera/controller/editar_oferta.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    abrirModal(id, nome, status, descricao, categoria, contato, estado, cidade, "Oferta editada com sucesso!");
                } else {
                    abrirModal(id, nome, status, descricao, categoria, contato, estado, cidade, "Erro ao editar oferta.");
                }
            })
            .catch(error => {
                console.error('Erro ao editar oferta:', error);
                abrirModal(null, null, null, null, null, null, null, null, "Erro inesperado. Tente novamente.");
            });
    }

    let ofertaParaExcluir = null;

    function excluirOferta(id) {
        ofertaParaExcluir = id;
        document.getElementById('confirmarExclusaoModal').classList.add('show');
    }

    function confirmarExclusao() {
        if (!ofertaParaExcluir) return;

        fetch('/Ampera/controller/excluir_oferta.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_oferta: ofertaParaExcluir
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fecharModal('confirmarExclusaoModal');
                    document.getElementById('sucessoExclusaoModal').classList.add('show');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert('Erro ao excluir oferta: ' + (data.message || 'Desconhecido'));
                }
            })
            .catch(error => console.error('Erro ao excluir oferta:', error));
    }

    function fecharModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        ofertaParaExcluir = null;
    }

    fetch('/Ampera/controller/cards_suasOfertas.php')
        .then(response => response.json())
        .then(ofertas => {
            ofertas.forEach(oferta => criarCardOferta(oferta));
        })
        .catch(error => console.error('Erro ao carregar ofertas:', error));

    window.onclick = function(event) {
        if (event.target == document.getElementById('editarModal')) {
            fecharModal();
        }
    }
</script>

</html>