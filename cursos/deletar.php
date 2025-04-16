<?php
    session_start();
    include '../conexao.php';

    if (isset($_POST['deletar_curso'])) {
        $id = pg_escape_string($database, trim($_POST['deletar_curso']));

        $sql = "DELETE FROM cursos WHERE id = $1";
        $result = pg_query_params($database, $sql, array($id));

        if ($result) {
            $_SESSION['msg'] = "Curso deletado com sucesso!";
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['msg'] = "Erro ao deletar curso: " . pg_last_error($database);
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['msg'] = "Nenhum dado foi enviado.";
        header('Location: index.php');
        exit();
    }
?>