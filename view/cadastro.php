<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="/Ampera/view/CSS/cadastro.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body>
    <div class="register-container">
        <h1>Registre-se</h1>

        <div class="already-have-account">
            Já tem uma conta? <a href="login" name="faaLoginText">Faça Login</a>
        </div>

        <br><br>
        <form action="controller/cadastrar.php" method="POST" class="form_register" id="Formulario">
            <div class="floating-label-container">
                <input type="text" name="login" placeholder=" " required />
                <label for="login">Login</label>
            </div>
            <div class="floating-label-container">
                <input type="text" name="nome" placeholder=" " required />
                <label for="nome">Nome</label>
            </div>
            <div class="floating-label-container">
                <input type="text" name="sobrenome" placeholder=" " />
                <label for="sobrenome">Sobrenome</label>
            </div>
            <div class="floating-label-container">
                <input type="email" name="email" placeholder=" " required />
                <label for="email">Email</label>
            </div>
            <div class="floating-label-container">
                <input type="text" name="contato" id="contato" placeholder=" " required />
                <label for="contato">Contato</label>
            </div>
            <div class="floating-label-container">
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" placeholder=" " required />
                <label for="cpf_cnpj">CPF/CNPJ</label>
            </div>
            <div class="floating-label-container">
                <input type="date" name="data_nasc" id="data_nasc" placeholder=" " required />
                <label for="data_nascimento">Data de Nascimento</label>
                <small id="data_nasc_error" style="color: red; display: none;">Insira uma data válida</small>
            </div>
            <div class="floating-label-container">
                <input type="password" name="senha" placeholder=" " required />
                <label for="senha">Senha</label>
            </div>

            <br>
            <button class="register-btn" name="registrarText" type="submit">Registrar</button>
        </form>

        <div class="divider">ou</div>
        <button class="google-btn"><img src="/Ampera/imagens/google.png" class="google">Continuar com o Google</button>
        <br>
        <div class="terms">
            Ao se registrar, você concorda com nossos Termos de Uso e reconhece que leu nossa Política de Privacidade.
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Máscara para o campo de contato
            $('#contato').mask('(00) 00000-0000');

            // Máscara dinâmica para CPF ou CNPJ
            $('#cpf_cnpj').on('input', function () {
                var cpfCnpjVal = $(this).val().replace(/\D/g, '');

                if (cpfCnpjVal.length > 11) {
                    $(this).mask('00.000.000/0000-00', { reverse: true });
                } else {
                    $(this).mask('000.000.000-00', { reverse: true });
                }
            });

            $('#Formulario').on('submit', function (e) {
                var dataNasc = $('#data_nasc').val();
                var dataAtual = new Date();
                var dataNascimento = new Date(dataNasc);

                // Verifica se a data é válida e a idade está no intervalo permitido (0-120 anos)
                if (!dataNasc || dataNascimento > dataAtual || (dataAtual.getFullYear() - dataNascimento.getFullYear()) > 120) {
                    e.preventDefault();
                    $('#data_nasc_error').show();
                } else {
                    $('#data_nasc_error').hide();
                }
            });
        });
    </script>
</body>

</html>
