<?php
// Conexão com o banco de dados
$pdo = new PDO('mysql: host=localhost; dbname=BD_1B_1;', 'username','123456789');

// Coletar dados do formulário
$username = $_POST['username'];
$password = $_POST['password'];
//var_dump($username);
//var_dump($password);


// Verificar se o usuário existe
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuarios_nome = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
var_dump($password);
var_dump($user['pass']);

$hash = password_hash($user['pass'], PASSWORD_DEFAULT);


if ($user && password_verify($password, $hash)) {
    header("Location: index_central.php");
    
    } 
    
    else {
    header("Location: index.php");
    echo "Credenciais inválidas. Tente novamente.";
}
?>