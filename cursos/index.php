<?php
    include("../conexao.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRIAR ALUNO</title>
</head>
<body>
    <h1>Lista de Cursos</h1>
    <form action="criar.php" method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <button type="submit" name="criar_curso">Criar Aluno</button>
    </form>

    <h2>Lista de Cursos</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
        </tr>
        <?php
            $sql = "SELECT * FROM cursos";
            $result = pg_query($database, $sql);

            if (!$result) {
                echo "<p>Erro ao buscar cursos: " . pg_last_error($database) . "</p>";
            } elseif (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td><a href='view.php?id=" . htmlspecialchars($row['id']) . "'>Editar</a></td>";
                    echo "<td><form action='deletar.php' method='POST'><button type='submit' name='deletar_curso' value='" . htmlspecialchars($row['id']) . "'>Deletar</button></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Nenhum curso encontrado.</td></tr>";
            }
        ?>
</body>
</html>