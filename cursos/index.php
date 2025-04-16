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
        <h1 class="text-center mb-4">Criar Aluno</h1>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <form action="criar.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="criar_curso">Criar Aluno</button>
                    <a href="/index.php" class="btn btn-warning btn-sm">Voltar</a>      
                </form>
            </div>
        </div>

        <h2 class="text-center mb-4">Lista de Cursos</h2>

        <?php
            $sql = "SELECT * FROM cursos";
            $result = pg_query($database, $sql);

            if (!$result) {
                echo "<div class='alert alert-danger'>Erro ao buscar cursos: " . pg_last_error($database) . "</div>";
            } elseif (pg_num_rows($result) > 0) {
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead><tr><th>ID</th><th>Nome</th><th>Ações</th></tr></thead>";
                echo "<tbody>";
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>
                            <a href='view.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Editar</a>
                            <form action='deletar.php' method='POST' style='display:inline-block;'>
                                <button type='submit' name='deletar_curso' value='" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'>Deletar</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='alert alert-info'>Nenhum curso encontrado.</div>";
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
