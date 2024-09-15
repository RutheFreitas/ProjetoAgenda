<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Usuario.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nivel'] != 'admin') {
    header('Location: login.php');
    exit();
}

$usuario_email = $_SESSION['usuario_email'];
$usuario_nome = $_SESSION['usuario_nome'];
$usuario_nivel = $_SESSION['usuario_nivel'];

$usuario = new Usuario();

$editMode = false;
$editUser = null;
// Lógica de processamento de formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $usuario->criarUsuario($_POST['usuario'], $_POST['email'], $_POST['senha'], $_POST['nivel']);
    } elseif (isset($_POST['update1']) || isset($_POST['update2'])) {
        // Verifica se a senha foi enviada no formulário
        $senha = isset($_POST['senha']) && !empty($_POST['senha']) ? $_POST['senha'] : null;
        $usuario->editarUsuario($_POST['id'], $_POST['usuario'], $_POST['email'], $senha, $_POST['nivel']);
        if (isset($_POST['update2'])) {
            header('Location: usuarios.php');
            exit();
        }
    } elseif (isset($_POST['delete'])) {
        $usuario->deletarUsuario($_POST['id']);
    }
}

$usuarios = $usuario->listarUsuarios();

// Verifica se há um usuário para editar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update1'])) {
    $editMode = true;
    $editUser = (object) [
        'id' => $_POST['id'],
        'usuario' => $_POST['usuario'],
        'email' => $_POST['email'],
        'nivel' => $_POST['nivel']
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Usuários</title>
    <link href="usuarios.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">    
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <h2 class="btn btn-danger fs-3">Usuários</h2>
        <form method="POST" class="mb-3">
            <input type="hidden" name="id" value="<?= $editMode ? $editUser->id : '' ?>">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="usuario" placeholder="Usuário" value="<?= $editMode ? $editUser->usuario : '' ?>" required>
                    <label class="input-label">Usuário</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="email" placeholder="email" value="<?= $editMode ? $editUser->email : '' ?>" required>
                    <label class="input-label">Email</label>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="senha" placeholder="Senha" <?= $editMode ? '' : 'required' ?>>
                    <label class="input-label">Senha</label>
                </div>
                <div class="col">
                    <select class="form-control" name="nivel" required>
                        <option value="admin" <?= $editMode && $editUser->nivel == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="usuario" <?= $editMode && $editUser->nivel == 'usuario' ? 'selected' : '' ?>>Usuário</option>
                    </select>
                    <label class="input-label">Nível</label>
                </div>
                <div class="col">
                    <?php if ($editMode): ?>
                        <button type="submit" name="update2" class="btn btn-warning">Atualizar</button>
                    <?php else: ?>
                        <button type="submit" name="create" class="btn btn-success">Adicionar</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <table class="table compact-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>email</th>
                    <th>Nível</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user): ?>
                    <tr>
                        <td class="idTh"><?= $user->id ?></td>
                        <td><?= $user->usuario ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->nivel ?></td>
                        <td class="acaoTh">
                            <!-- Botão Editar que carrega os dados no formulário -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <input type="hidden" name="usuario" value="<?= $user->usuario ?>">
                                <input type="hidden" name="email" value="<?= $user->email ?>">
                                <input type="hidden" name="nivel" value="<?= $user->nivel ?>">
                                <button class="btn btn-edit" name="update1">
                                        <i class="fas fa-edit"></i>
                                </button>
                            </form>
                            <!-- Botão Deletar -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <button class="btn btn-trash" name="delete">
                                        <i class="fas fa-trash"></i>
                                </button>                                    
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
