<?php
    $host = 'localhost';
    $port = '5432';
    $user = 'postgres';
    $db = 'postgres';
    $password = '020385';

    $conexao = "host=$host port=$port dbname=$db user=$user password=$password";
    $database = pg_connect($conexao);

    if (!$database) {
        die("Erro ao conectar ao banco de dados.");
    }

    function checkAndCreateTable($database, $tableName, $createQuery) {
        $checkQuery = "
            SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_name = '$tableName'
            );
        ";
        $checkResult = pg_query($database, $checkQuery);

        $tableExists = pg_fetch_result($checkResult, 0, 0);

        if ($tableExists === 'f') {
            $result = pg_query($database, $createQuery);

            if (!$result) {
                die("Erro ao criar a tabela $tableName: " . pg_last_error($database));
            }
        }
    }

    $createAlunosTable = "
        CREATE TABLE alunos (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            data_nascimento DATE NOT NULL,
            cpf VARCHAR(255) NOT NULL,
            telefone VARCHAR(255) NOT NULL,
            whatsapp VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL
        );
    ";
    checkAndCreateTable($database, 'alunos', $createAlunosTable);

    $createCursosTable = "
        CREATE TABLE cursos (
            id SERIAL PRIMARY KEY,
            nome VARCHAR(100) NOT NULL
        );
    ";
    checkAndCreateTable($database, 'cursos', $createCursosTable);

    $createAlunosCursosTable = "
        CREATE TABLE alunos_cursos (
            id SERIAL PRIMARY KEY,
            aluno_id INT NOT NULL REFERENCES alunos(id) ON DELETE CASCADE,
            curso_id INT NOT NULL REFERENCES cursos(id) ON DELETE CASCADE
        );
    ";
    checkAndCreateTable($database, 'alunos_cursos', $createAlunosCursosTable);
?>