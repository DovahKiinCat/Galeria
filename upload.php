<?php

$conn = new mysqli("localhost", "", "", "galeria");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST['descricao'];
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));
    $nomeArquivo = uniqid() . "." . $imageFileType;
    $target_file = $target_dir . $nomeArquivo;

    if($imageFileType != "jpg" && $imageFileType != "png") {
        echo "Apenas arquivos JPG e PNG são permitidos.";
        exit;
    }

    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO imagens (nome_arquivo, descricao, caminho) VALUES ('$nomeArquivo', '$descricao', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            echo "Imagem enviada com sucesso!";
        } else {
            echo "Erro ao salvar no banco: " . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Fotos Preferidas</title>
    <link rel="stylesheet" href="output.css">
</head>
<body class="bg-gray-800">

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-white">Enviar imagem</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            <label for="imagem" class="block text-sm font-medium text-gray-700">Escolha uma imagem (PNG ou JPG):</label>
            <input type="file" name="imagem" id="imagem" class="mt-2 p-2 border border-gray-300 rounded-md w-full" required><br><br>
            
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição:</label>
            <textarea name="descricao" id="descricao" class="mt-2 p-2 border border-gray-300 rounded-md w-full" required></textarea><br><br>
            
            <button type="submit" class="block mt-4 text-blue-950 hover:cursor-pointer hover:bg-yellow-500 bg-yellow-400 rounded-lg font-bold p-4 text-center shadow-xl">Enviar</button>
        </form>
        <a href="listar.php" class="block mt-4 text-blue-950 hover:cursor-pointer hover:bg-yellow-500 bg-yellow-400 rounded-lg font-bold p-4 text-center shadow-black shadow-2xl">Ver imagens enviadas</a>
    </div>
</body>
</html>
