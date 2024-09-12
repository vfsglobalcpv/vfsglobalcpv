<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamentos";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se os dados do formulário foram recebidos
if (isset($_POST['arn']) && isset($_POST['passport'])) {
    // Obtém os dados do formulário e sanitiza
    $arn = htmlspecialchars($_POST['arn']);
    $passport = htmlspecialchars($_POST['passport']);

    // Prepara a consulta SQL para verificar se os dados existem e buscar a mensagem
    $sql = "SELECT mensagem FROM agendamentos WHERE arn = ? AND passport = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("ss", $arn, $passport);

    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o registro foi encontrado
    if ($result->num_rows > 0) {
        // Registro encontrado - buscar e exibir a mensagem personalizada
        $row = $result->fetch_assoc();
        echo $row['mensagem'];  // Exibe apenas a mensagem personalizada
    } else {
        // Registro não encontrado
        echo "Não foram encontrados registos, forneça o ARN e o número de passaporte correctos";
    }

    // Fecha a declaração
    $stmt->close();
} else {
    echo "Dados do formulário não foram recebidos.";
}

// Fecha a conexão
$conn->close();
?>
