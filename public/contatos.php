<?php
session_start();
require_once '../config/config.php';
require_once '../classes/Contato.php';

//if (!isset($_SESSION['usuario_id'])) {
if (!isset($_SESSION['usuario_email'])) {
    header('Location: login.php');
    exit();
}

//$email_usuario = isset($_SESSION['usuario_email']);
$nivel = $_SESSION['usuario_nivel'];
$usuario_email = $_SESSION['usuario_email'];
$usuario_nome = $_SESSION['usuario_nome'];
$usuario_nivel = $_SESSION['usuario_nivel'];
$contato = new Contato();
$editMode = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $nivel == 'admin') {
    if (isset($_POST['create'])) {
        $contato->criarContato($_POST['nome'], $_POST['idade'], $_POST['email'], $_POST['telefone']);
    } elseif (isset($_POST['update1']) || isset($_POST['update2'])) {
        $contato->editarContato($_POST['id'], $_POST['nome'], $_POST['idade'], $_POST['email'], $_POST['telefone']);
        if (isset($_POST['update2'])) {
            header('Location: contatos.php');
            exit();
        }
    } elseif (isset($_POST['delete'])) {
        $contato->deletarContato($_POST['id']);
    }
}

$contatos = $contato->listarContatos();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update1'])) {
    $editMode = true;
    $editContato = (object) [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'idade' => $_POST['idade'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone']
    ];

}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Contatos</title>
    <link href="contatos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <div class="container">
        <h2 class="btn btn-primary fs-3">Contatos</h2>
        <?php if ($nivel == 'admin'): ?>
            <form method="POST" class="mb-3">
               <input type="hidden" name="id" value="<?= $editMode ? $editContato->id : '' ?>">
                <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?= $editMode ? $editContato->nome : '' ?>" required>
                      <label class="input-label">Nome</label>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="idade" placeholder="Idade" value="<?= $editMode ? $editContato->idade : '' ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        <label class="input-label">Idade</label>
                    </div>
                    <div class="col">
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $editMode ? $editContato->email : '' ?>" required>
                        <label class="input-label">Email</label>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="telefone" placeholder="Telefone" value="<?= $editMode ? $editContato->telefone : '' ?>" required>
                        <label class="input-label">Telefone</label>
                    </div>
                    <div class="col">
                        <?php if ($editMode): ?>
                            <button type="submit" name="update2" class="btn btn-success">Atualizar</button>
                        <?php else: ?>
                            <button type="submit" name="create" class="btn btn-success">Adicionar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <table class="table compact-table">
            <thead>
                <tr>
                    <th class="idTh">ID</th>
                    <th>Nome</th>
                    <th class="idadeTh">Idade</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <?php if ($nivel == 'admin'): ?>
                        <th class="acaoTh">Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contatos as $cont): ?>
                    <tr>
                        <td class="idTd"><?= $cont->id ?></td>
                        <td><?= $cont->nome ?></td>
                        <td class="idadeTd"><?= $cont->idade ?></td>
                        <td><?= $cont->email ?></td>
                        <td><?= $cont->telefone ?></td>
                        <?php if ($nivel == 'admin'): ?>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $cont->id ?>">
                                    <input type="hidden" name="nome" value="<?= $cont->nome ?>">
                                    <input type="hidden" name="idade" value="<?= $cont->idade ?>">
                                    <input type="hidden" name="email" value="<?= $cont->email ?>">
                                    <input type="hidden" name="telefone" value="<?= $cont->telefone ?>">
                                    <button class="btn btn-edit" name="update1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $cont->id ?>">
                                    <button class="btn btn-trash" name="delete">
                                        <i class="fas fa-trash"></i>
                                    </button>                                    
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
