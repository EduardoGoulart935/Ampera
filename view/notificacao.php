<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notificações - Ampera</title>
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/index.css">
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/menu.css">
    <link rel="stylesheet" type="text/css" href="/Ampera/view/CSS/notificacao.css">
</head>

<body>

    <div id="notificacoes-container">
    </div>

    <script>
        function criarCardNotificacao(notificacao) {
            const card = document.createElement('div');
            card.classList.add('notificacao-card');
            card.innerHTML = `
                <div class="info">
                    <h2>Notificação ID: ${notificacao.id}</h2>
                    <p class="description">Descrição: ${notificacao.descricao}</p>
                    <div class="details">
                        <p>
                            Visualizada: ${notificacao.visualizada ? 'Sim' : 'Não'}<br><br>
                            ID Recebedor: ${notificacao.id_perfil_recebedor}<br><br>
                            Solicitante: ${notificacao.solicitante_nome}<br><br>
                            Oferta: ${notificacao.oferta_nome}<br><br>
                        </p>
                    </div>
                </div>
            `;

            document.getElementById('notificacoes-container').appendChild(card);
        }

        fetch('/Ampera/controller/notificacoes.php')
            .then(response => response.json())
            .then(notificacoes => {
                console.log(notificacoes);
                notificacoes.forEach(notificacao => {
                    criarCardNotificacao(notificacao);
                });
            })
            .catch(error => console.error('Erro ao carregar notificações:', error));
    </script>
</body>
</html>
