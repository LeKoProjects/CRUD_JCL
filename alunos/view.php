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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <?php include('mensagem.php'); ?>
    <h1>Visualizar Aluno</h1>
    <div>
        <?php
        if (isset($_GET['id'])) {
            $id = pg_escape_string($database, $_GET['id']);
            $sql = "SELECT * FROM alunos WHERE id='$id'";
            $result = pg_query($database, $sql);
            
            if (pg_num_rows($result) > 0) {
                $aluno = pg_fetch_assoc($result);
                echo "<p>ID: " . $aluno['id'] . "</p>";
                echo "<p>Nome: " . $aluno['nome'] . "</p>";
                echo "<p>Email: " . $aluno['email'] . "</p>";
                echo "<p>CPF: " . $aluno['cpf'] . "</p>";
                echo "<p>Telefone: " . $aluno['telefone'] . "</p>";
                echo "<p>Data de Nascimento: " . $aluno['data_nascimento'] . "</p>";
            } else {
                echo "<p>Aluno não encontrado.</p>";
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
            $sql = "SELECT * FROM alunos WHERE id='$id'";
            $result = pg_query($database, $sql);
            
            if (pg_num_rows($result) > 0) {
                $aluno = pg_fetch_assoc($result);
        ?>
        <form action="editar.php?id=<?= $aluno['id'] ?>" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= $aluno['nome'] ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $aluno['email'] ?>" required><br>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="<?= $aluno['cpf'] ?>" required><br>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" value="<?= $aluno['telefone'] ?>" required><br>

            <label for="whatsapp">WhatsApp:</label>
            <input type="text" name="whatsapp" id="whatsapp" value="<?= $aluno['whatsapp'] ?>" required><br>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" value="<?= $aluno['data_nascimento'] ?>" required><br>

            <label for="cursos">Cursos:</label><br>
            <?php
                $sql_cursos = "SELECT * FROM cursos";
                $result_cursos = pg_query($database, $sql_cursos);
                
                if (!$result_cursos) {
                    echo "<p>Erro ao buscar cursos: " . pg_last_error($database) . "</p>";
                } elseif (pg_num_rows($result_cursos) > 0) {
                    while ($curso = pg_fetch_assoc($result_cursos)) {
                        $checked = in_array($curso['id'], explode(',', $aluno['nome'])) ? 'checked' : '';
                        echo "<input type='checkbox' name='cursos[]' value='" . htmlspecialchars($curso['id']) . "' $checked> " . htmlspecialchars($curso['nome']) . "<br>";
                    }
                } else {
                    echo "<p>Nenhum curso encontrado.</p>";
                }
            ?>

            <button type="submit" name="editar_aluno">Editar Aluno</button>
        </form>
        <?php
            } else {
                echo "<p>Aluno não encontrado.</p>";
            }
        } else {
            echo "<p>ID não fornecido.</p>";
        }
        ?>
    </div>
</body>
</html>