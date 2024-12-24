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
    <div class="main-container">
        <header>
            <br>
            <h1 class="titulo-notificacoes">Notificações</h1>
            <p class="subtitulo-notificacoes">Aqui você encontra todas as notificações importantes relacionadas às suas ofertas.</p>
            <br>
        </header>
        <div id="notificacoes-container"></div>
    </div>
    <script>
        function criarCardNotificacao(notificacao) {
            const card = document.createElement('div');
            card.classList.add('notificacao-card');
            card.innerHTML = `
                <div class="info">
                    <h2>🔔 Notificação</h2>
                    <br>
                    <div class="details">
                        <p><strong>Solicitante:</strong> ${notificacao.solicitante_nome}</p>
                        <p><strong>Contato:</strong> ${notificacao.contato}</p>
                        <p><strong>Oferta:</strong> ${notificacao.oferta_nome}</p>
                        <p><strong>Email:</strong> ${notificacao.email}</p>
                        <p><strong>Data:</strong> ${new Date(notificacao.data_hora).toLocaleDateString()}</p>
                    </div>
                </div>
            `;
            document.getElementById('notificacoes-container').appendChild(card);
        }

        fetch('/Ampera/controller/notificacoes.php')
            .then(response => response.json())
            .then(notificacoes => {
                notificacoes.forEach(notificacao => criarCardNotificacao(notificacao));
            })
            .catch(error => console.error('Erro ao carregar notificações:', error));
    </script>
    <br><br><br><br><br>
</body>

</html>