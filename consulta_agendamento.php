<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamentos";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ARN foi enviado via GET na URL
if (isset($_GET['arn'])) {
    $arn = $_GET['arn']; // Pegando o ARN pela URL
    
    // Preparar a consulta para pegar a mensagem e os dados relacionados
    $sql = "SELECT arn, passport, mensagem FROM agendamentos WHERE arn = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Ligar o parâmetro
        $stmt->bind_param("s", $arn);
        
        // Executar a consulta
        $stmt->execute();
        $stmt->bind_result($arnResult, $passport, $mensagem);

        // Verificar se foi encontrado algum resultado
        if ($stmt->fetch()) {
            echo "<h1>Agendamento Encontrado</h1>";
            echo "<p><strong>ARN:</strong> " . $arnResult . "</p>";
            echo "<p><strong>Passaporte:</strong> " . $passport . "</p>";
            echo "<p><strong>Mensagem:</strong> " . $mensagem . "</p>";
        } else {
            echo "<p>Registro não encontrado!</p>";
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
} else {
    echo "Por favor, forneça um número ARN válido.";
}

// Fechar a conexão
$conn->close();
?>
