<?php
$exibirModal = isset($_SESSION['mensagemLogado']) && $_SESSION['mensagemLogado'];
if ($exibirModal) {
    unset($_SESSION['mensagemLogado']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - Ampera</title>
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/index.css">
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/menu.css">
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
        #mensagemLogado .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }

        #mensagemLogado .modal-content {
            border-radius: 10px;
            border: 2px solid #28da52;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        #mensagemLogado .modal-header {
            background-color: #28da52;
            color: white;
            border-bottom: 1px solid #ddd;
        }

        #mensagemLogado .modal-header .btn-close {
            background-color: transparent;
        }

        #mensagemLogado .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }



        #mensagemPedidos .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }

        #mensagemPedidos .modal-content {
            border-radius: 10px;
            border: 2px solid #28da52;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        #mensagemPedidos .modal-header {
            background-color: #28da52;
            color: black;
            border-bottom: 1px solid #ddd;
        }

        #mensagemPedidos .modal-header .btn-close {
            background-color: transparent;
        }

        #mensagemPedidos .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }


        #mensagemProprioPedidos .modal-dialog {
            max-width: 520px;
            margin: 30px auto;
        }

        #mensagemProprioPedidos .modal-content {
            border-radius: 10px;
            border: 2px solid #eaff00;
            /* Borda verde */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
        }

        #mensagemProprioPedidos .modal-header {
            background-color: #eaff00;
            color: black;
            border-bottom: 1px solid #ddd;
        }

        #mensagemProprioPedidos .modal-header .btn-close {
            background-color: transparent;
        }

        #mensagemProprioPedidos .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }
    </style>

</head>

<body class="menu-page">

    <!-- Modal Logado -->
    <div class="modal fade" id="mensagemLogado" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ofertaCriadaModalLabel">Você logou, Seja Bem Vindo!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    <!-- Modal Pedido -->
    <div class="modal fade" id="mensagemPedidos" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ofertaCriadaModalLabel">Solicitação feita!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pedido Erro Próprio Pedido-->
    <div class="modal fade" id="mensagemProprioPedidos" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ofertaCriadaModalLabel">Você não pode fazer Solicitação na própria oferta!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <h1 class="titulo-home">Ofertas Disponíveis</h1>
    <p class="subtitulo-home">Explore as ofertas disponíveis e solicite os itens que você precisa de forma simples e rápida.</p>
    <br>
    <div id="ofertas-container">


    </div>


    <br><br><br><br>
</body>
<script>
    function criarCardOferta(oferta) {
        const card = document.createElement('div');
        card.classList.add('oferta-card');
        card.innerHTML = `
                    <div class="image">
                        <img src="/Ampera/imagens/${oferta.nome_foto}" alt="Imagem da oferta">
                    </div>
                    <div class="info">
                        <h2>${oferta.nome}</h2>
                        <p class="description">${oferta.descricao}</p>
                        <div class="details">
                        <br>
                            <p> 
                            <strong>Nome:</strong> <span class="unavailable">${oferta.nome_usu}</span><br>
                            <strong>Categoria:</strong> <span class="unavailable">${oferta.categoria}</span><br>
                            <strong>Contato:</strong> <span class="unavailable">${oferta.contato}</span><br>
                            <strong>Endereço:</strong> <span class="unavailable">${oferta.estado} - ${oferta.cidade}</span><br>
                            <strong>Email:</strong> <span class="unavailable">${oferta.email}</span>
                            </p>
                        </div>
                        <a href="#" class="button" onclick="FazerSolicitacao(${oferta.id})">Fazer Solicitação</a>
                    </div>
                `;

        document.getElementById('ofertas-container').appendChild(card);
    }

    fetch('/Ampera/controller/cards_menu.php')
        .then(response => response.json())
        .then(ofertas => {
            console.log(ofertas);
            ofertas.forEach(oferta => {
                criarCardOferta(oferta);
            });
        })
        .catch(error => console.error('Erro ao carregar ofertas:', error));

    function FazerSolicitacao(id_oferta) {
        const dados = {
            id_oferta: id_oferta
        };

        fetch('/Ampera/controller/fazer_solicitacao.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                const modalPedidos = new bootstrap.Modal(document.getElementById('mensagemPedidos'));
                const modalProprioPedidos = new bootstrap.Modal(document.getElementById('mensagemProprioPedidos'));
                if (data.success) {
                    console.log(document.getElementById('mensagemPedidos'));
                    modalPedidos.show();
                    
                } else {
                    console.log(document.getElementById('mensagemProprioPedidos'))
                    modalProprioPedidos.show();
                }
            })
            .catch(error => {
                console.error('Erro ao fazer solicitação:', error);
                const modalPedidos = new bootstrap.Modal(document.getElementById('mensagemPedidos'));
                document.querySelector('#mensagemPedidos .modal-title').textContent = "Erro inesperado";
                document.querySelector('#mensagemPedidos .modal-body').textContent = "Ocorreu um erro inesperado. Por favor, tente novamente.";
                modalPedidos.show();
            });
    }

    function mostrarNotificacoes() {
        fetch('/Ampera/controller/notificacoes.php')
            .then(response => response.json())
            .then(notificacoes => {
                const notificationList = document.getElementById('notification-list');
                notificationList.innerHTML = '';
                notificacoes.forEach(notificacao => {
                    const item = document.createElement('div');
                    item.innerHTML = `
                                <p><strong>${notificacao.solicitante_nome}</strong> solicitou sua oferta: <strong>${notificacao.oferta_nome}</strong> em ${new Date(notificacao.data_hora).toLocaleString()}</p>
                            `;
                    notificationList.appendChild(item);
                });
                document.getElementById('notification-count').innerText = notificacoes.length;
                notificationList.style.display = 'block';
            })
            .catch(error => console.error('Erro ao carregar notificações:', error));
    }

    function atualizarContadorNotificacoes() {
        fetch('/Ampera/controller/notificacoes.php')
            .then(response => response.json())
            .then(notificacoes => {
                document.getElementById('notification-count').innerText = notificacoes.length;
            })
            .catch(error => console.error('Erro ao carregar notificações:', error));
    }

    setInterval(atualizarContadorNotificacoes, 60000); // Atualiza a cada 60 segundos

    <?php if ($exibirModal): ?>
        var modal = new bootstrap.Modal(document.getElementById('mensagemLogado'));
        modal.show();
    <?php endif; ?>
</script>

</html>