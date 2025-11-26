let Dados = [];
const Opcoes = document.getElementById("opcoes");

async function Resposta ()
{
    let resposta = await fetch ("http://127.0.0.1:8080/Mercado/json/data.json");
    Dados = await resposta.json();
    await preenchaDados(Dados);
}

async function preenchaDados (dados)
{
    Opcoes.innerHTML = "";
    for (let linha of dados)
    {
        const dado = linha;
        console.log(dado);
        
        const option = document.createElement("option");
        option.value = dado.nome;
        option.innerHTML = dado.nome;
        Opcoes.appendChild(option);
    }
}

Resposta();