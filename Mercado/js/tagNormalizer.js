async function CreateLink (href, target, html)
{
    const a = document.createElement("a");
    a.innerHTML = html;
    a.href = href;
    a.target = target;
    return a;
}

async function CreateTitle (type, html)
{
    const ht = document.createElement(`h${type}`);
    ht.innerHTML = html;
    return ht;
}

async function CreateParagraph (html, classe)
{
    const p = document.createElement("p");
    p.innerHTML = html;
    p.className = classe;
    return p;
}

