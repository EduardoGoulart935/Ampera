<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="/Ampera/view/CSS/login.css" />
</head>

<body>
    <div class="login-container">
        <h1>Recuperar Senha</h1>
        <br><br>
        <form action="/Ampera/enviar_email" method="POST">
            <div class="floating-label-container">
                <input type="email" name="email" placeholder=" " required/>
                <label for="email">Digite seu E-mail</label>
            </div>

            <br>
            <button class="login-btn" id="entrarText" type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>