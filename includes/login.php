<?php
session_start();

// Se já estiver logado, redireciona para a página principal
if (isset($_SESSION['usuario_id'])) {
    header('Location: produtos.php');
    exit;
}

include 'config.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];
    
    if (!empty($email) && !empty($senha)) {
        $sql = "SELECT id, nome, senha FROM usuarios WHERE email = '$email'";
        $resultado = $conexao->query($sql);
        
        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();
            
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                header('Location: produtos.php');
                exit;
            } else {
                $erro = 'Email ou senha incorretos.';
            }
        } else {
            $erro = 'Email ou senha incorretos.';
        }
    } else {
        $erro = 'Por favor, preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Login</h1>
            
            <?php if (!empty($erro)): ?>
                <div class="erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            
            <p class="link-registro">
                Não tem uma conta? <a href="registro.php">Registre-se aqui</a>
            </p>
        </div>
    </div>
</body>
</html>

