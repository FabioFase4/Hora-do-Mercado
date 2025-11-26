# O Modelo de Banco de Dados

Drop DataBase If Exists Banco4;
Create DataBase If Not Exists Banco4;
Use Banco4;

Create Table If Not Exists Clientes (
	Id Int Primary Key Not Null Auto_Increment,
    Nome VarChar (150) Not Null,
    Senha VarChar (75) Not Null,
    Email VarChar (75) Not Null)
Auto_Increment = 1;
    
Create Table If Not Exists Produtos (
	Id Int Primary Key Not Null Auto_Increment,
    Nome VarChar (150) Not Null,
    Descricao VarChar (200) Not Null,
    Preco Decimal (10, 2),
    DataLote Date Not Null,
    DataValidade Date Not Null,
    Quantidade Int Not Null)
Auto_Increment = 1;
    
Create Table If Not Exists Vendas (
	Id Int Primary Key Not Null Auto_Increment,
    Id_Cliente Int Not Null,
    Id_Produto Int Not Null, 
    DataVenda Date Not Null,
    FOREIGN KEY (Id_Cliente) REFERENCES Clientes(Id),
	FOREIGN KEY (Id_Produto) REFERENCES Produtos(Id))
Auto_Increment = 1;

Create Table If Not Exists Admins (
	Id Int Primary Key Not Null Auto_Increment,
    Nome VarChar (150) Not Null,
    Senha VarChar (75) Not Null,
    Email VarChar (75) Not Null)
Auto_Increment = 1;

Insert Into Clientes Values 
(1, "Fábio Silva de Lima", md5("Fsl230409!"), "fabiosilvalsjc@gmail.com"),
(2, "João Paulo Pires", md5("Pires123!"), "joaopires@gmail.com"),
(3, "Arthur dos Reis Lelis", md5("Arthur1234!"), "arthurlelis@gmail.com"),
(4, "Lucas Ferreira Stabile", md5("Lucas9876!"), "lucas@gmail.com");

INSERT INTO Produtos VALUES
(1, "Sabonete", "Lavagem do Corpo para melhor fragância", 15.00, '2023-01-01', '2030-01-01', 130),
(2, "Tênis da Nike", "Seu estilo aumenta com o Tênis da Nike", 234.90, '2024-06-23', '2030-01-01', 240),
(3, "Garrafa de Água", "Hidratação em Primeiro Lugar", 120.00, '2024-08-07', '2040-08-07', 90),
(4, "Perfume de Rosa", "Um bom cheiro atrai as pessoas", 70.50, '2024-10-05', '2032-12-05', 100),
(5, "Pente", "O estilo também está no cabelo", 20.40, '2024-04-07', '2050-06-07', 410);

Insert Into Estoque Values
(1, 1, 1, "2025-10-25"),
(2, 2, 2, "2025-09-01"),
(3, 3, 3, "2024-05-12"),
(4, 4, 4, "2018-05-21"),
(5, 4, 5, "2024-08-30");

