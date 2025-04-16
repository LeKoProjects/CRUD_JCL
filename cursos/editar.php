<?php
    session_start();
    include "../conexao.php";

    if(isset($_POST['editar_curso'])){
        $id = pg_escape_string($database, trim($_GET['id']));
        $nome = isset($_POST['nome']) ? pg_escape_literal($database, trim($_POST['nome'])) : "NULL";

        $sql = "UPDATE cursos SET nome = $nome WHERE id = $id";
       
        if(pg_query($database, $sql)){
            $_SESSION["msg"] = "Curso editado com sucesso!";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Erro ao criar o curso.');</script>";
        }
    }
?><!DOCTYPE html>