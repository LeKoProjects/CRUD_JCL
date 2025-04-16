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

        <h1 class="text-center mb-4">Visualizar Aluno</h1>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <?php
                if (isset($_GET['id'])) {
                    $id = pg_escape_string($database, $_GET['id']);
                    $sql = "SELECT * FROM alunos WHERE id='$id'";
                    $result = pg_query($database, $sql);
                    
                    if (pg_num_rows($result) > 0) {
                        $aluno = pg_fetch_assoc($result);
                        echo "<p><strong>ID:</strong> " . $aluno['id'] . "</p>";
                        echo "<p><strong>Nome:</strong> " . $aluno['nome'] . "</p>";
                        echo "<p><strong>Email:</strong> " . $aluno['email'] . "</p>";
                        echo "<p><strong>CPF:</strong> " . $aluno['cpf'] . "</p>";
                        echo "<p><strong>Telefone:</strong> " . $aluno['telefone'] . "</p>";
                        echo "<p><strong>Data de Nascimento:</strong> " . $aluno['data_nascimento'] . "</p>";
                    } else {
                        echo "<div class='alert alert-warning'>Aluno não encontrado.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>ID não fornecido.</div>";
                }
                ?>
            </div>
            <a href="/alunos/index.php" class="btn btn-warning btn-sm">Voltar</a>
        </div>

        <h1 class="text-center mb-4">Editar Aluno</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <?php
                if (isset($_GET['id'])) {
                    $id = pg_escape_string($database, $_GET['id']);
                    $sql = "SELECT * FROM alunos WHERE id='$id'";
                    $result = pg_query($database, $sql);
                    
                    if (pg_num_rows($result) > 0) {
                        $aluno = pg_fetch_assoc($result);
                ?>
                <form action="editar.php?id=<?= $aluno['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" value="<?= $aluno['nome'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $aluno['email'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF:</label>
                        <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $aluno['cpf'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" name="telefone" id="telefone" value="<?= $aluno['telefone'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp:</label>
                        <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="<?= $aluno['whatsapp'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                        <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" value="<?= $aluno['data_nascimento'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="cursos" class="form-label">Cursos:</label><br>
                        <?php
                            $sql_cursos = "SELECT * FROM cursos";
                            $result_cursos = pg_query($database, $sql_cursos);
                            
                            if (!$result_cursos) {
                                echo "<div class='alert alert-danger'>Erro ao buscar cursos: " . pg_last_error($database) . "</div>";
                            } elseif (pg_num_rows($result_cursos) > 0) {
                                while ($curso = pg_fetch_assoc($result_cursos)) {
                                    $checked = in_array($curso['id'], explode(',', $aluno['nome'])) ? 'checked' : '';
                                    echo "<div class='form-check'>
                                            <input type='checkbox' class='form-check-input' name='cursos[]' value='" . htmlspecialchars($curso['id']) . "' $checked>
                                            <label class='form-check-label'>" . htmlspecialchars($curso['nome']) . "</label>
                                          </div>";
                                }
                            } else {
                                echo "<div class='alert alert-info'>Nenhum curso encontrado.</div>";
                            }
                        ?>
                    </div>

                    <button type="submit" class="btn btn-warning" name="editar_aluno">Editar Aluno</button>
                </form>
                <?php
                    } else {
                        echo "<div class='alert alert-warning'>Aluno não encontrado.</div>";
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
