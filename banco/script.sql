CREATE DATABASE IF NOT EXISTS cardapio_db;
USE cardapio_db;

-- Tabela do Adm
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela de Categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255) DEFAULT 'sem-foto.jpg',
    disponivel BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Usuario admin para logar --
INSERT INTO usuarios (nome, email, senha) VALUES ('admin', 'admin@email.com', 'admin');

-- Categorias básicas para iniciar
INSERT INTO categorias (nome) VALUES ('Hambúrgueres'), ('Bebidas'), ('Sobremesas');

-- Produtos para iniciar --
INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem, disponivel) VALUES
(1, 'Smash Burger Duplo', 'Dois suculentos hambúrgueres de 90g prensados na chapa, queijo prato derretido, bacon crocante e maionese da casa no pão brioche.', 32.90, 'sem-foto.jpg', 1),

(2, 'Soda Italiana de Maçã Verde', 'Bebida refrescante feita com xarope de maçã verde, água com gás, muito gelo e rodelas de limão siciliano.', 14.50, 'sem-foto.jpg', 1),

(3, 'Brownie com Sorvete', 'Delicioso brownie de chocolate belga servido quentinho, acompanhado de uma bola de sorvete de creme e calda de chocolate.', 22.90, 'sem-foto.jpg', 1);

