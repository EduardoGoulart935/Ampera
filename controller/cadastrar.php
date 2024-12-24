    <?php
    require_once("../model/conexao.php");
    session_start();

    try {
        $login = $_POST["login"] ?? null;
        $nome = $_POST["nome"] ?? null;
        $sobrenome = $_POST["sobrenome"] ?? null;
        $email = $_POST["email"] ?? null;
        $contato = $_POST["contato"] ?? null;
        $cpf_cnpj = $_POST["cpf_cnpj"] ?? null;
        $data_nasc = $_POST["data_nasc"] ?? null;
        $senha = $_POST["senha"] ?? null;

        if (!$login || !$nome || !$email || !$senha) {
            throw new Exception("Campos obrigatórios não preenchidos.");
        }

        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        $pdo->beginTransaction();

        $sql2 = "INSERT INTO usuarios (login, nome, sobrenome, email, senha) VALUES (:login, :nome, :sobrenome, :email, :senha)";
        $ins2 = $pdo->prepare($sql2);
        $ins2->bindParam(':login', $login);
        $ins2->bindParam(':nome', $nome);
        $ins2->bindParam(':sobrenome', $sobrenome);
        $ins2->bindParam(':email', $email);
        $ins2->bindParam(':senha', $senhaHash);
        
        if (!$ins2->execute()) {
            throw new Exception("Erro ao inserir em 'usuarios': " . implode(", ", $ins2->errorInfo()));
        }

        $_SESSION['id_last_usuario'] = $pdo->lastInsertId();

        $sql = "INSERT INTO perfil (nome, sobrenome, email, contato, cpf_cnpj, data_nasc, id_endereco, id_usuarios, avatar) 
            VALUES (:nome, :sobrenome, :email, :contato, :cpf_cnpj, :data_nasc, null, :id_usuario, :avatar)";
        $ins = $pdo->prepare($sql);
        $ins->bindParam(':nome', $nome);
        $ins->bindParam(':sobrenome', $sobrenome);
        $ins->bindParam(':email', $email);
        $ins->bindParam(':contato', $contato);
        $ins->bindParam(':cpf_cnpj', $cpf_cnpj);
        $ins->bindParam(':data_nasc', $data_nasc);
        $ins->bindParam(':id_usuario', $_SESSION['id_last_usuario']);
        $avatarDefault = 'user.png';
        $ins->bindParam(':avatar', $avatarDefault);


        if (!$ins->execute()) {
            throw new Exception("Erro ao inserir em 'perfil': " . implode(", ", $ins->errorInfo()));
        }
        $pdo->commit();
        $_SESSION['id_perfil'] =  $_SESSION['id_last_usuario'];

        if (!$_SESSION['id_perfil']) {
            throw new Exception("Falha ao recuperar o ID do perfil.");
        }
        $_SESSION['cadastro_completo'] = true;

        header("Location: /Ampera/cadastro1");
        exit;
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        exit;
    }