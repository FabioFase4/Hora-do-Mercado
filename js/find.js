const CardContainer = document.getElementById("card-container");
const LinksGithub = document.getElementById("links");

async function RenderGithubs ()
{
    try {
        let resposta = await fetch ("http://127.0.0.1:8080/Mercado/json/githubs.json");
        let dados = await resposta.json();

        LinksGithub.innerHTML = ""; 

        for (let linha of dados)
        {
            const option = document.createElement("option");
            option.value = linha.link;
            option.textContent = linha.user; 
            LinksGithub.appendChild(option);
        }
    } catch (error) {
        console.error("Erro ao carregar ou renderizar links do Github:", error);
        LinksGithub.innerHTML = `<option value="">Erro ao carregar links</option>`;
    }
}

async function openGithub ()
{
    const link = LinksGithub.value;
    if (link) 
    { 
        window.open (link, "_blank");
    }
}

RenderGithubs();