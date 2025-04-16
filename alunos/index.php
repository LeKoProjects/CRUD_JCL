<?php
    include("../conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <h1 class="text-center mb-4">Criar Curso</h1>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <form action="criar.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input type="text" class="form-control" id="telefone" name="telefone">
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp:</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp">
                    </div>

                    <div class="mb-3">
                        <label for="cursos" class="form-label">Cursos:</label><br>
                        <?php
                            $sql = "SELECT * FROM cursos";
                            $result = pg_query($database, $sql);

                            if (!$result) {
                                echo "<div class='alert alert-danger'>Erro ao buscar cursos: " . pg_last_error($database) . "</div>";
                            } elseif (pg_num_rows($result) > 0) {
                                while ($row = pg_fetch_assoc($result)) {
                                    echo "<div class='form-check'>
                                            <input type='checkbox' class='form-check-input' name='cursos[]' value='" . htmlspecialchars($row['id']) . "'>
                                            <label class='form-check-label'>" . htmlspecialchars($row['nome']) . "</label>
                                          </div>";
                                }
                            } else {
                                echo "<div class='alert alert-info'>Nenhum curso encontrado.</div>";
                            }
                        ?>
                    </div>

                    <button type="submit" class="btn btn-primary" name="criar_aluno">Criar Aluno</button>
                    <a href="/index.php" class="btn btn-warning btn-sm">Voltar</a>
                </form>
            </div>
        </div>

        <h2 class="text-center mb-4">Lista de Alunos</h2>

        <?php
            $sql = "SELECT * FROM alunos";
            $result = pg_query($database, $sql);

            if (!$result) {
                echo "<div class='alert alert-danger'>Erro ao buscar alunos: " . pg_last_error($database) . "</div>";
            } elseif (pg_num_rows($result) > 0) {
                echo "<table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data de Nascimento</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>WhatsApp</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['data_nascimento']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cpf']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['whatsapp']) . "</td>";
                    echo "<td>
                            <a href='view.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Editar</a>
                            <form action='deletar.php' method='POST' style='display:inline-block;'>
                                <button type='submit' name='deletar_aluno' value='" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Deletar</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='alert alert-info'>Nenhum aluno encontrado.</div>";
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
