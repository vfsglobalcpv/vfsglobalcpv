<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";  // Usuário padrão do XAMPP
$password = "";  // Senha padrão do XAMPP, geralmente vazia
$dbname = "agendamentos";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $arn = $_POST['arn'];
    $passport = $_POST['passport'];
    $mensagem = $_POST['mensagem'];

    // Inserir os dados na tabela
    $sql = "INSERT INTO agendamentos (arn, passport, mensagem) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Ligar os parâmetros
        $stmt->bind_param("sss", $arn, $passport, $mensagem);

        // Executar a consulta
        if ($stmt->execute()) {
            echo "Novo agendamento inserido com sucesso!";
        } else {
            echo "Erro ao inserir agendamento: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>
