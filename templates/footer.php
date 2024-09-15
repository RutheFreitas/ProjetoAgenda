<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .imagemUTD {
            width: 30px;
            height: 30px;
        }
        .divFooter {
            background-color: gray;
            color: yellow;
            align-items: center;
        }
        .text-start {
            font-family:'Courier New', Courier, monospace;
            font-size: 110%;
        }
        .text-end {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: 150%;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #f8f9fa;
            color: transparent;
            background-color: transparent;
        }
    </style>
</head>
<body>
    <main class="container">
        <!-- Conteúdo principal da página -->
    </main>
    <footer class="bg-light text-center text-lg-start mt-auto">
        <div class="d-flex justify-content-between p-3 divFooter">
            <div class="text-start">
                <img src="../templates/utd_icone.png" alt="UTD: logomarca" class="img-fluid rounded imagemUTD">
                UTD: Linguagem de Programação PHP
            </div>
            <div class="text-end">
                Ruthe de Oliveira Freitas
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
