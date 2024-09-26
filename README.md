-- Tabela 'users'
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('aluno','funcionario','admin')
);

-- Tabela 'estoque'
CREATE TABLE estoque (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    tipo ENUM('comida','bebida','doce'),
    quantidade INT(11),
    preco DECIMAL(10,2),
    imagem VARCHAR(255),
    data_adicao TIMESTAMP
);

-- Tabela 'carrinho'
CREATE TABLE carrinho (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(11),
    produto_id INT(11),
    quantidade INT(11),
    FOREIGN KEY (usuario_id) REFERENCES users(id),
    FOREIGN KEY (produto_id) REFERENCES estoque(id)
);

-- Tabela 'pedidos'
CREATE TABLE pedidos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(11),
    total DECIMAL(10,2),
    status VARCHAR(50),
    data_pedido TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES users(id)
);

-- Tabela 'pedido_itens'
CREATE TABLE pedido_itens (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT(11),
    produto_id INT(11),
    quantidade INT(11),
    preco DECIMAL(10,2),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES estoque(id)
);
INSERT INTO users (name, email, password, role)
VALUES ('Administrador', 'adm@gmail.com', '$2y$10$SRsTD.d3GjzlAF9.7b.gMOv9jAkFUI7xEitT0E7rgk9H4mwUzx6Km', 'admin');
SET FOREIGN_KEY_CHECKS = 1;