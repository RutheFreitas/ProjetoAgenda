// /public/usuarios.php
<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Usuario.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nivel'] != 'admin') {
    header('Location: login.php');
    exit();
}

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $usuario->criarUsuario($_POST['usuario'], $_POST['nome'], $_POST['senha'], $_POST['nivel']);
    } elseif (isset($_POST['update'])) {
        $usuario->editarUsuario($_POST['id'], $_POST['usuario'], $_POST['nome'], $_POST['nivel']);
    } elseif (isset($_POST['delete'])) {
        $usuario->deletarUsuario($_POST['id']);
    }
}

$usuarios = $usuario->listarUsuarios();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <h2>Usuários</h2>
        <form method="POST" class="mb-3">
            <input type="hidden" name="id" value="">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="usuario" placeholder="Usuário" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="nome" placeholder="Nome" required>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                </div>
                <div class="col">
                    <select class="form-control" name="nivel" required>
                        <option value="admin">Admin</option>
                        <option value="usuario">Usuário</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" name="create" class="btn btn-success">Adicionar</button>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Nome</th>
                    <th>Nível</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->usuario ?></td>
                        <td><?= $user->nome ?></td>
                        <td><?= $user->nivel ?></td>
                        <td><?= $user->createdAt ?></td>
                        <td><?= $user->updatedAt ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <input type="hidden" name="usuario" value="<?= $user->usuario ?>">
                                <input type="hidden" name="nome" value="<?= $user->nome ?>">
                                <input type="hidden" name="nivel" value="<?= $user->nivel ?>">
                                <button type="submit" name="update" class="btn btn-warning">Editar</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Deletar</button>
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
