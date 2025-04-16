<?php
    session_start();
    include("../conexao.php");

    if(isset($_POST['criar_aluno'])){

        $nome = pg_escape_string($database, trim($_POST['nome']));
        $email = pg_escape_string($database, trim($_POST['email']));
        $cpf = pg_escape_string($database, trim($_POST['cpf']));
        $data_nascimento = date('Y-m-d', strtotime($_POST['data_nascimento']));
        $telefone = pg_escape_string($database, trim($_POST['telefone']));
        $whatsapp = pg_escape_string($database, trim($_POST['whatsapp']));
        $cursos = $_POST['cursos'] ?? [];

        $sql = "INSERT INTO alunos (nome, email, cpf, telefone, data_nascimento, whatsapp) 
        VALUES ('$nome', '$email', '$cpf', '$telefone', '$data_nascimento', '$whatsapp') RETURNING id";

        $result = pg_query($database, $sql);

        if ($result) {
            $row = pg_fetch_assoc($result);
            $aluno_id = $row['id'];

            foreach ($cursos as $curso_id) {
                $curso_id = pg_escape_string($database, $curso_id);
                pg_query($database, "INSERT INTO alunos_cursos (aluno_id, curso_id) VALUES ('$aluno_id', '$curso_id')");
            }

            $_SESSION['msg'] = "Aluno criado e cursos associados com sucesso!";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Erro ao criar aluno.');</script>";
        }
    }
?>