<?php
$nome = "";
$email = "";
$telefone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["campoNome"] ?? "";
    $email = $_POST["campoEmail"] ?? "";
    $telefone = $_POST["campoTelefone"] ?? "";
}
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

    #resultado {
        padding-top: 30px;
    }

</style>

<body>
    <div class="card_container">
        <div class="titulo">
            <h2>Cadastro de Usuário</h2>
            <p>Preencha todos os campos abaixo.</p>
        </div>

        <form method="POST" id="campos" action="">
            <input type="text" name="campoNome" placeholder="Digite seu Nome:" required>
            <input type="email" name="campoEmail" placeholder="Digite seu E-mail:" required>
            <input type="text" name="campoTelefone" placeholder="Digite seu Telefone:" required>

            <button type="submit" id="btnCadastro">Cadastrar</button>
        </form>
    </div> 

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <h2>Dados recebidos pelo servidor</h2>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($telefone); ?></p>

    <?php endif; ?>

</body>
</html>