<?php
//Google Gemini ajudou-me
/**
 * Classe Modelo para a tabela Vendas.
 * Implementa JsonSerializable para fácil conversão em JSON (usado em APIs).
 */
class Vendas implements JsonSerializable
{
    /**
     * @param ?int $id Chave primária. Nulo por padrão para novas vendas.
     * @param int $idCliente Chave estrangeira para a tabela Clientes.
     * @param int $idProduto Chave estrangeira para a tabela Produtos.
     * @param string $dataVenda Data em que a transação ocorreu (formato 'YYYY-MM-DD').
     */
    public function __construct (
        private ?int $id = null,
        private int $idCliente = 0,
        private int $idProduto = 0,
        private string $dataVenda = ""
    ){ }

    // --- Implementação da Interface JsonSerializable ---
    
    public function jsonSerialize (): array 
    {
        return [
            "Id" => $this->id,
            "IdCliente" => $this->idCliente,
            "IdProduto" => $this->idProduto,
            "DataVenda" => $this->dataVenda
        ];
    }

    // --- Getters e Setters ---

    // ID
    public function getId (): ?int
    {
        return $this->id;
    }
    public function setId (?int $id): self 
    {
        $this->id = $id;
        return $this;
    }

    // ID Cliente
    public function getIdCliente (): int 
    {
        return $this->idCliente;
    }
    public function setIdCliente (int $idCliente): self 
    {
        $this->idCliente = $idCliente;
        return $this;
    }

    // ID Produto
    public function getIdProduto (): int 
    {
        return $this->idProduto;
    }
    public function setIdProduto (int $idProduto): self 
    {
        $this->idProduto = $idProduto;
        return $this;
    }

    // Data da Venda
    public function getDataVenda (): string 
    {
        return $this->dataVenda;
    }
    public function setDataVenda (string $dataVenda): self 
    {
        $this->dataVenda = $dataVenda;
        return $this;
    }
}
?>