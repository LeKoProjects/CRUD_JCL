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
    <h1>CRIAR ALUNO</h1>
    <form action="criar.php" method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="data_nascimento">Data de Nascimento:</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br><br>

        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" required><br><br>

        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone"><br><br>

        <label for="whatsapp">WhatsApp:</label><br>
        <input type="text" id="whatsapp" name="whatsapp"><br><br>

        <label for="cursos">Cursos:</label><br>
        <?php
            $sql = "SELECT * FROM cursos";
            $result = pg_query($database, $sql);

            if (!$result) {
                echo "<p>Erro ao buscar cursos: " . pg_last_error($database) . "</p>";
            } elseif (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "<input type='checkbox' name='cursos[]' value='" . htmlspecialchars($row['id']) . "'> " . htmlspecialchars($row['nome']) . "<br>";
                }
            } else {
                echo "<tr><td colspan='2'>Nenhum curso encontrado.</td></tr>";
            }
        ?>

        <button type="submit" name="criar_aluno">Criar Aluno</button>
    </form>

    <h2>Lista de Alunos</h2>
    <table border="1">
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
        <?php
            $sql = "SELECT * FROM alunos";
            $result = pg_query($database, $sql);

            if (!$result) {
                echo "<p>Erro ao buscar alunos: " . pg_last_error($database) . "</p>";
            } elseif (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['data_nascimento']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cpf']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['whatsapp']) . "</td>";
                    echo "<td><a href='view.php?id=" . htmlspecialchars($row['id']) . "'>Editar</a></td>";
                    echo "<td><form action='deletar.php' method='POST'><button type='submit' name='deletar_aluno' value='" . htmlspecialchars($row['id']) . "'>Deletar</button></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Nenhum aluno encontrado.</td></tr>";
            }
        ?>
</body>
</html>