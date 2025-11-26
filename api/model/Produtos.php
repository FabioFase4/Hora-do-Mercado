<?php
//Google Gemini ajudou-me

class Produtos implements JsonSerializable
{
    public function __construct (
        private ?int $id = null,
        private string $nome = "",
        private string $descricao = "",
        private float $preco = 0,
        private string $dataLote = "",
        private string $dataValidade = "",
        private int $quantidade = 0
    ){ }

    public function JsonSerialize (): array 
    {
        // Certifique-se de que a saída JSON está correta
        return [
            "Id" => $this->id,
            "Nome" => $this->nome,
            "Descricao" => $this->descricao,
            "Preco" => $this->preco,
            "DataLote" => $this->dataLote,
            "DataValidade" => $this->dataValidade,
            "Quantidade" => $this->quantidade
        ];
    }

    // --- Getters e Setters já existentes ---
    
    public function getId (): ?int
    {
        return $this->id;
    }
    public function setId (?int $id): self 
    {
        $this->id = $id;
        return $this;
    }

    public function getNome (): string 
    {
        return $this->nome;
    }
    
    // --- Setters para Nome ---
    public function setNome (string $nome): self 
    {
        $this->nome = $nome;
        return $this;
    }

    // --- Getters e Setters Completados ---

    public function getDescricao (): string 
    {
        return $this->descricao;
    }
    public function setDescricao (string $descricao): self 
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getPreco (): float 
    {
        return $this->preco;
    }
    public function setPreco (float $preco): self 
    {
        $this->preco = $preco;
        return $this;
    }

    public function getDataLote (): string 
    {
        return $this->dataLote;
    }
    public function setDataLote (string $dataLote): self 
    {
        $this->dataLote = $dataLote;
        return $this;
    }

    public function getDataValidade (): string 
    {
        return $this->dataValidade;
    }
    public function setDataValidade (string $dataValidade): self 
    {
        $this->dataValidade = $dataValidade;
        return $this;
    }

    public function getQuantidade (): int 
    {
        return $this->quantidade;
    }
    public function setQuantidade (int $quantidade): self 
    {
        $this->quantidade = $quantidade;
        return $this;
    }
}
?>