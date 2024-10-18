<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - Ampera</title>
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/index.css">
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/menu.css">
</head>

<body>

    <div id="ofertas-container">
    </div>

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
                        <p> 
                        <span class="unavailable">${oferta.id_perfil}</span><br><br>
                        <span class="unavailable">Id: ${oferta.id}</span><br><br>
                        <span class="unavailable">${oferta.categoria}</span><br><br>
                        <span class="unavailable">${oferta.contato}</span><br><br>
                        <span class="unavailable">${oferta.email}</span>
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
            const dados = { id_oferta: id_oferta };

            fetch('/Ampera/controller/fazer_solicitacao.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Solicitação realizada com sucesso!');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro ao fazer solicitação:', error);
                });
        }

        function mostrarNotificacoes() {
            fetch('/Ampera/controller/notificacoes.php')
                .then(response => response.json())
                .then(notificacoes => {
                    const notificationList = document.getElementById('notification-list');
                    notificationList.innerHTML = ''; // Limpa a lista de notificações
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
    </script>

</body>

</html>
