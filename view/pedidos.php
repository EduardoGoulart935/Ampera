<?php

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seus Pedidos - Ampera</title>
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/pedidos.css">
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
        #mensagemCancelado .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }

        #mensagemCancelado .modal-content {
            border-radius: 10px;
            border: 2px solid #28da52;
            /* Borda verde */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        #mensagemCancelado .modal-header {
            background-color: #28da52;
            /* Fundo verde */
            color: white;
            /* Texto branco */
            border-bottom: 1px solid #ddd;
        }

        #mensagemCancelado .modal-header .btn-close {
            background-color: transparent;
        }

        #mensagemCancelado .modal-body {
            padding: 20px;
            text-align: center;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="modal fade" id="mensagemCancelado" tabindex="-1" aria-labelledby="ofertaCriadaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ofertaCriadaModalLabel">Pedido Cancelado!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <br>
        <h1 class="titulo-pedidos">Seus Pedidos</h1>
        <p class="subtitulo-pedidos">Consulte e gerencie os pedidos realizados por você.</p>
        <div class="section">
            <br>
            <div id="pedidos-ativos"></div>
        </div>
    </div>

    <script>
        /**
         * Cria um card para exibir o pedido.
         * @param {Object} pedido - Objeto contendo os detalhes do pedido.
         * @param {String} status - Status do pedido (ativo ou cancelado).
         */
        function criarCardPedido(pedido, status = "ativo") {
            const card = document.createElement('div');
            card.classList.add('pedido-card');
            if (status === "cancelado") {
                card.classList.add('cancelado');
            }

            card.innerHTML = `
                <div class="info">
                    <h2>Produto: ${pedido.nome}</h2>
                    <p>Data do Pedido: ${pedido.hora_data}</p>
                    <p>Descrição: ${pedido.descricao}</p>
                    <span class="status">${status === "ativo" ? 'Ativo' : 'Cancelado'}</span>
                    ${
                      status === "ativo"
                        ? `<button onclick="cancelarPedido('${pedido.id}')">Cancelar Pedido</button>`
                        : ''
                    }
                </div>
            `;

            document.getElementById('pedidos-ativos').appendChild(card);
        }
        function carregarPedidos() {
            fetch('/Ampera/controller/cards_pedidos.php')
                .then(response => {
                    if (!response.ok) throw new Error("Erro ao carregar pedidos.");
                    return response.json();
                })
                .then(pedidos => {
                    pedidos.forEach(pedido => {
                        const status = pedido.cancelado ? "cancelado" : "ativo";
                        criarCardPedido(pedido, status);
                    });
                })
                .catch(error => console.error('Erro ao carregar pedidos:', error));
        }

        function cancelarPedido(idPedido) {
            fetch('/Ampera/controller/cancelar_pedido.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id_pedido: idPedido
                    }),
                })
                .then(response => {
                    if (!response.ok) throw new Error("Erro na solicitação.");
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const modalPedidos = new bootstrap.Modal(document.getElementById('mensagemCancelado'));
                        console.log(document.getElementById('mensagemCancelado'));
                        modalPedidos.show();

                        const card = document.querySelector(
                            `.pedido-card button[onclick="cancelarPedido('${idPedido}')"]`
                        ).closest('.pedido-card');
                        card.classList.add('cancelado');
                        card.querySelector('.status').textContent = 'Cancelado';
                        card.querySelector('button').remove();
                    } else {
                        alert(data.error || 'Erro ao cancelar o pedido.');
                    }
                })
                .catch(error => console.error('Erro ao cancelar o pedido:', error));
        }

        carregarPedidos();
    </script>
</body>

</html>