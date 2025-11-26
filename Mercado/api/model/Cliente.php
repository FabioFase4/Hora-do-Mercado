<?php
class Cliente implements JsonSerializable
{
    public function __construct (
        private ?int $id = null,
        private string $nome = "",
        private string $senha = "",
        private string $email = ""
    ){ }

    public function JsonSerialize (): array 
    {
        return [
            'id'    => $this->id,
            'nome'  => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ];
    }

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
    public function setNome (string $nome): self 
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail (): string 
    {
        return $this->email;
    }
    public function setEmail (string $email): self 
    {
        $this->email = $email;
        return $this;
    }

    public function getSenha (): string 
    {
        return $this->senha;
    }
    public function setSenha (string $senha): self 
    {
        $this->senha = $senha;
        return $this;
    }
}
?>