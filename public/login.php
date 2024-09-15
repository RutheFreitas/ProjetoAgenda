<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Usuario.php';
$focus = 'email';
$email = '';
$senha = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = new Usuario();
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $auth = $usuario->autenticar($email, $senha);

    if ($auth) {
        $_SESSION['usuario_id'] = $auth->id;
        $_SESSION['usuario_nome'] = $auth->usuario;
        $_SESSION['usuario_email'] = $auth->email;
        $_SESSION['usuario_nivel'] = $auth->nivel;
        header('Location: contatos.php');
        exit();
    } else {
        if (empty($email)) {
            $focus = 'email';
        } elseif (empty($senha)) {
            $focus = 'senha';
        } else {
            $error = "Usuário ou senha inválidos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="login.css" rel="stylesheet">
</head>
<body>
    <div class="container login-container">
        <h2 class="text-center">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="email" class="form-control" id="usuario" name="email" value="<?php echo htmlspecialchars($email); ?>" required
                <?php if (isset($focus) && $focus == 'email') echo 'autofocus'; ?>>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" value="<?php echo htmlspecialchars($senha); ?>" required
                <?php if (isset($focus) && $focus == 'senha') echo 'autofocus'; ?>>
            </div>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</body>
</html>
