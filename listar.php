<?php

$conn = new mysqli("localhost", "", "", "galeria");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "SELECT caminho FROM imagens WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $caminho = $row['caminho'];
    
    if (file_exists($caminho)) {
        unlink($caminho);
    }
    
    $sql = "DELETE FROM imagens WHERE id = $id";
    $conn->query($sql);
    
    header("Location: listar.php");
}

$sql = "SELECT * FROM imagens";
$result = $conn->query($sql);

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
        <table class="min-w-full bg-white rounded shadow-md">
            <thead class="bg-black text-white">
                <tr>
                    <th class="py-2 px-4">Imagem</th>
                    <th class="py-2 px-4">Descrição</th>
                    <th class="py-2 px-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-b">
                        <td class="py-2 px-4 flex justify-center"><img src="<?php echo $row['caminho']; ?>" alt="imagem" class="w-32 h-32 object-cover"></td>
                        <td class="py-2 px-4"><?php echo $row['descricao']; ?></td>
                        <td class="py-2 px-4 flex justify-center items-center">
                            <a href="visualizar.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:cursor-pointer">🔍</a>
                            <a href="listar.php?excluir=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta imagem?')" class="text-red-500 hover:cursor-pointer">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="upload.php" class="block mt-4 text-blue-950 hover:cursor-pointer hover:bg-yellow-500 bg-yellow-400 rounded-lg font-bold p-4 text-center shadow-black shadow-2xl">Enviar uma nova imagem</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
