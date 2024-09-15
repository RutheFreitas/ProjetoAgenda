<?php
$loggedIn = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <style>
        .custom-icon {
            font-size: 3rem; /* Ajuste o tamanho conforme necessário */
            color: #ffc107; /* Cor amarela */
        }        
        #navContato {
            color: blue;
            background-color: white;
        }
        #navContato:hover {
            color: white;
            background-color: blue;
        }
        #navUsuario {
            color: red;
            background-color: white;
        }
        #navUsuario:hover {
            color: white;
            background-color: red;
        }
        #navSair {
            color: gray;
            background-color: white;
        }
        #navSair:hover {
            color: white;
            background-color: gray;
        }
        .small-label {
            font-size: 0.8rem; /* Ajuste o tamanho conforme necessário */
            color: #6c757d; /* Cor cinza */
            margin-top: -10px;
        }        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 text-warning" href="#">
                <i class="bi bi-person-video2 custom-icon"></i>
                Agenda
                <div class="small-label">Usuário: <?= $usuario_nome ?> (<?= $usuario_nivel?>)</div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($loggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link fs-4" id="navContato" href="contatos.php">Contatos</a>
                        </li>
                        <?php if ($_SESSION['usuario_nivel'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link fs-4" id="navUsuario" href="usuarios.php">Usuários</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link fs-4" id="navSair" href="logout.php">Sair</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link fs-4 text-dark bg-white" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
