<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suas Ofertas - Ampera</title>
    <link rel="stylesheet" href="/Ampera/view/CSS/suas_ofertas.css">
</head>

<body>

    <div class="container">
        <h1>Suas Ofertas</h1>
        <div id="ofertas-container"></div>
    </div>

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
                    <p>ID: ${oferta.id}</p>
                    <p><strong>Categoria:</strong> ${oferta.categoria}</p>
                    <p><strong>Contato:</strong> ${oferta.contato}</p>
                    <p><strong>Email:</strong> ${oferta.email}</p>
                    <div class="buttons">
                        <button class="edit-button" onclick="editarOferta(${oferta.id})">Editar</button>
                        <button class="delete-button" onclick="excluirOferta(${oferta.id})">Excluir</button>
                    </div>
                </div>
            `;
            let id_oferta = document.getElementById('${oferta.id}');
            document.getElementById('ofertas-container').appendChild(card);
        }

        function editarOferta(id_oferta) {
            window.location.href = `/Ampera/view/editar_oferta.php/${id_oferta}`;
        }

        function excluirOferta(id_oferta) {
          
            if (confirm('Tem certeza que deseja excluir esta oferta?')) {
                fetch('/Ampera/controller/excluir_oferta.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id_oferta: id_oferta }) 
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Oferta excluída com sucesso!');
                        location.reload(); 
                    } else {
                        alert(data.message || 'Erro ao excluir oferta.');
                    }
                })
                .catch(error => console.error('Erro ao excluir oferta:', error));
            }
        }

        fetch('/Ampera/controller/cards_suasOfertas.php')
            .then(response => response.json())
            .then(ofertas => {
                ofertas.forEach(oferta => criarCardOferta(oferta));
            })
            .catch(error => console.error('Erro ao carregar ofertas:', error));
    </script>

</body>

</html>
