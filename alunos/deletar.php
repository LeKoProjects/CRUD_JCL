<?php
    session_start();
    include '../conexao.php';

    if (isset($_POST['deletar_aluno'])) {
        $id = pg_escape_string($database, trim($_POST['deletar_aluno']));

        $sql = "DELETE FROM alunos WHERE id = $1";
        $result = pg_query_params($database, $sql, array($id));

        if ($result) {
            $_SESSION['msg'] = "Aluno deletado com sucesso!";
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['msg'] = "Erro ao deletar aluno: " . pg_last_error($database);
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['msg'] = "Nenhum dado foi enviado.";
        header('Location: index.php');
        exit();
    }
?>