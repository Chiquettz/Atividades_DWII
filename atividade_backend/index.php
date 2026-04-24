<?php
$nome = "";
$email = "";
$telefone = "";
$mensagem = "";
$tipoMensagem = "";

$db_url = getenv("DATABASE_URL");

if (!$db_url) {
    die("Erro: variável DATABASE_URL não encontrada.");
}

$conn = pg_connect($db_url);

if (!$conn) {
    die("Erro ao conectar no banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");

    if ($nome === "" || $email === "" || $telefone === "") {
        $mensagem = "Preencha todos os campos.";
        $tipoMensagem = "erro";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Digite um e-mail válido.";
        $tipoMensagem = "erro";
    } else {
        $query = "INSERT INTO usuarios (nome, email, telefone) VALUES ($1, $2, $3)";
        $result = pg_query_params($conn, $query, [$nome, $email, $telefone]);

        if ($result) {
            $mensagem = "Usuário cadastrado com sucesso no banco de dados.";
            $tipoMensagem = "sucesso";

            $nome = "";
            $email = "";
            $telefone = "";
        } else {
            $mensagem = "Erro ao salvar no banco de dados.";
            $tipoMensagem = "erro";
        }
    }
}

$queryLista = "SELECT id, nome, email, telefone FROM usuarios ORDER BY id DESC";
$resultLista = pg_query($conn, $queryLista);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade - DW</title>
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap');

    * {
        margin: 0;
        padding: 0;
        font-family: 'Google Sans', sans-serif;
    }

    body {
        display: flex;
        background-image: linear-gradient(90deg, #457b9d 40%, #1d3557 90%);
        justify-content: center;
        align-items: center;
        padding-top: 160px;
    }

    .card_container {
        display: flex;
        padding: 40px;
        align-items: center;
        flex-direction: column;
        background-color: white;
        font-size: large;
        color: black;     
        border: 2px solid transparent; 
        border-radius: 8px;    
        box-shadow: 0px 10px 30px rgba(0,0,0,0.2); 
    }

    #campos {
        display: flex;
        flex-direction: column;
        padding-top: 20px;
        gap: 13px;
        width: 100%;
    }

    input {
        padding: 10px;
        border: 1px solid;
        border-radius: 4px;
    }

    #btnCadastro {
        padding: 10px;
        background-color: #457b9d;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .sucesso {
      background: #d1e7dd;
      color: #0f5132;
      border: 1px solid #badbcc;
    }

    .erro {
      background: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 12px;
      text-align: left;
    }

    th {
      background: #f1f1f1;
    }

    .sem-registros {
      margin-top: 15px;
      color: #666;
    }

</style>

<body>
    <div class="card_container">
        <?php if ($mensagem !== ""): ?>
            <div class="mensagem <?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <h2 style="margin-top: 35px;">Usuários cadastrados</h2>

        <?php if ($resultLista && pg_num_rows($resultLista) > 0): ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($usuario = pg_fetch_assoc($resultLista)): ?>
                <tr>
                <td><?php echo htmlspecialchars($usuario["id"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["nome"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                <td><?php echo htmlspecialchars($usuario["telefone"]); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="sem-registros">Nenhum usuário cadastrado.</p>
        <?php endif; ?>
    </div>

</body>
</html>