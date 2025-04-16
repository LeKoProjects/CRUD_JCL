<?php
    session_start();
    include("../conexao.php");

    if(isset($_POST['criar_curso'])){
        $id = 
        $nome = pg_escape_string($database, trim($_POST['nome']));

        $sql = "INSERT INTO cursos (nome) VALUES ('$nome')";
       
        if(pg_query($database, $sql)){
            $_SESSION["msg"] = "Curso criado com sucesso!";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Erro ao criar o curso.');</script>";
        }
    }
?><!DOCTYPE html>