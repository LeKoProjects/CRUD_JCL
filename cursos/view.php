<?php
session_start();
include_once '../conexao.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>CRUD JCL</title>
</head>
<body>
    <?php include('mensagem.php'); ?>
    <h1>Visualizar Curso</h1>
    <div>
        <?php
        if (isset($_GET['id'])) {
            $id = pg_escape_string($database, $_GET['id']);
            $sql = "SELECT * FROM cursos WHERE id='$id'";
            $result = pg_query($database, $sql);
            
            if (pg_num_rows($result) > 0) {
                $curso = pg_fetch_assoc($result);
                echo "<p>ID: " . $curso['id'] . "</p>";
                echo "<p>Nome: " . $curso['nome'] . "</p>";
            } else {
                echo "<p>Curso não encontrado.</p>";
            }
        } else {
            echo "<p>ID não fornecido.</p>";
        }
        ?>
    </div>

    <h1>Editar Aluno</h1>
    <div>
        <?php
        if (isset($_GET['id'])) {
            $id = pg_escape_string($database, $_GET['id']);
            $sql = "SELECT * FROM cursos WHERE id='$id'";
            $result = pg_query($database, $sql);
            
            if (pg_num_rows($result) > 0) {
                $curso = pg_fetch_assoc($result);
        ?>
        <form action="editar.php?id=<?= $curso['id'] ?>" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $curso['nome'] ?>" required><br>
            <button type="submit" name="editar_curso">Editar Curso</button>
        </form>
        <?php
            } else {
                echo "<p>curso não encontrado.</p>";
            }
        } else {
            echo "<p>ID não fornecido.</p>";
        }
        ?>
    </div>
</body>
</html>