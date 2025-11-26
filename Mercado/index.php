<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado</title>
    <link rel="stylesheet" href="css/index.css">
    <?php
        include_once("api.php");
    ?>
</head>
<body>
    <div class = "opcoes">
        <h1>Acesso</h1>
        <a href="view/loginCliente.html" class = "opcao">Sou Cliente</a><br><br><br>
        <a href="view/loginAdmin.html" class = "opcao">Sou Administrador</a>
    </div>
    
    <div class = "githubs" id = "githubs">
        <h1>Githubs</h1>
    </div>

    <script>
        async function data ()
        {
            const githubs = document.getElementById ("githubs");
            const dados = await fetch ("json/githubs.json");
            const lista = await dados.json();

            for (const linha of lista)
            {
                const a = document.createElement ("a");
                a.className = "atalho";
                a.innerHTML = linha.user;
                a.href = linha.link;
                a.target = "_blank";
                githubs.appendChild(a);
                githubs.appendChild(document.createElement ("br"));
            }
        }   
        data();
        
    </script>
</body>
</html>



