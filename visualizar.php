<?php

$conn = new mysqli("localhost", "", "", "galeria");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM imagens WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Imagem</title>
    <link rel="stylesheet" href="output.css">
</head>
<body class="bg-gray-800">
    <div class="container mx-auto p-4">
        <img src="<?php echo $row['caminho']; ?>" alt="imagem" class="w-full max-w-lg mx-auto object-cover shadow-2xl shadow-black"><br><br>
        <p class="text-lg justify-center items-center flex text-white font-bold"><?php echo $row['descricao']; ?></p>
        <a href="listar.php" class="block mt-4 text-blue-950 hover:cursor-pointer hover:bg-yellow-500 bg-yellow-400 rounded-lg font-bold p-4 text-center shadow-black shadow-2xl">Voltar para a lista</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
