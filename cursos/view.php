<?php
session_start();
include_once '../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD JCL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <?php include('mensagem.php'); ?>

        <h1 class="text-center mb-4">Visualizar Curso</h1>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <?php
                if (isset($_GET['id'])) {
                    $id = pg_escape_string($database, $_GET['id']);
                    $sql = "SELECT * FROM cursos WHERE id='$id'";
                    $result = pg_query($database, $sql);
                    
                    if (pg_num_rows($result) > 0) {
                        $curso = pg_fetch_assoc($result);
                        echo "<p><strong>ID:</strong> " . $curso['id'] . "</p>";
                        echo "<p><strong>Nome:</strong> " . $curso['nome'] . "</p>";
                    } else {
                        echo "<div class='alert alert-warning'>Curso não encontrado.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>ID não fornecido.</div>";
                }
                ?>
            </div>
            <a href="/cursos/index.php" class="btn btn-warning btn-sm">Voltar</a>
        </div>

        <h1 class="text-center mb-4">Editar Curso</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <?php
                if (isset($_GET['id'])) {
                    $id = pg_escape_string($database, $_GET['id']);
                    $sql = "SELECT * FROM cursos WHERE id='$id'";
                    $result = pg_query($database, $sql);
                    
                    if (pg_num_rows($result) > 0) {
                        $curso = pg_fetch_assoc($result);
                ?>
                <form action="editar.php?id=<?= $curso['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Curso:</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="<?= $curso['nome'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-warning" name="editar_curso">Editar Curso</button>
                </form>
                <?php
                    } else {
                        echo "<div class='alert alert-warning'>Curso não encontrado.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>ID não fornecido.</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
