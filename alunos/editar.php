<?php
    session_start();
    include("../conexao.php");

    if (isset($_POST['editar_aluno'])) {

        $id = pg_escape_string($database, trim($_GET['id']));
        $nome = pg_escape_string($database, trim($_POST['nome']));
        $email = pg_escape_string($database, trim($_POST['email']));
        $cpf = pg_escape_string($database, trim($_POST['cpf']));
        $data_nascimento = date('Y-m-d', strtotime($_POST['data_nascimento']));
        $telefone = pg_escape_string($database, trim($_POST['telefone']));
        $whatsapp = pg_escape_string($database, trim($_POST['whatsapp']));
        $cursos = $_POST['cursos'] ?? [];

        $sql = "UPDATE alunos SET nome = '$nome', email = '$email', cpf = '$cpf', telefone = '$telefone', data_nascimento = '$data_nascimento', whatsapp = '$whatsapp' WHERE id = '$id'";

        $result = pg_query($database, $sql);

        if ($result) {
            pg_query($database, "DELETE FROM alunos_cursos WHERE aluno_id = '$id'");

            foreach ($cursos as $curso_id) {
                $curso_id = pg_escape_string($database, $curso_id);
                pg_query($database, "INSERT INTO alunos_cursos (aluno_id, curso_id) VALUES ('$id', '$curso_id')");
            }

            $_SESSION['msg'] = "Aluno atualizado e cursos associados com sucesso!";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar aluno.');</script>";
        }
    }
?>