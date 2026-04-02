-- -----------------------------------------------------
-- 1. Criar o banco de dados
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS sistema_questoes
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sistema_questoes;

-- -----------------------------------------------------
-- 2. Criar o usuário do sistema (com senha)
-- -----------------------------------------------------
-- Cria o usuário (troque 'senha_segura' por uma senha forte)
CREATE USER IF NOT EXISTS 'app_questoes'@'localhost' 
IDENTIFIED BY '8&t|YOAc5e2o7/7{2';

-- Concede privilégios para o usuário no banco
GRANT SELECT, INSERT, UPDATE, DELETE ON sistema_questoes.* 
TO 'app_questoes'@'localhost';

-- Aplica as permissões
FLUSH PRIVILEGES;

-- -----------------------------------------------------
-- 3. Criar as tabelas
-- -----------------------------------------------------

-- Tabela: bancas
CREATE TABLE bancas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unq_nome (nome)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: disciplinas
CREATE TABLE disciplinas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unq_nome (nome)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: provas
CREATE TABLE provas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ano YEAR NOT NULL,
    banca_id INT UNSIGNED NULL,
    nome VARCHAR(200) NULL,
    PRIMARY KEY (id),
    INDEX idx_ano (ano),
    INDEX idx_banca (banca_id),
    FOREIGN KEY (banca_id) REFERENCES bancas(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: provas_disciplinas
CREATE TABLE provas_disciplinas (
    prova_id INT UNSIGNED NOT NULL,
    disciplina_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (prova_id, disciplina_id),
    FOREIGN KEY (prova_id) REFERENCES provas(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (disciplina_id) REFERENCES disciplinas(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: questoes
CREATE TABLE questoes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    prova_id INT UNSIGNED NOT NULL,
    disciplina_id INT UNSIGNED NOT NULL,
    texto LONGTEXT NOT NULL,
    referencia TEXT NULL,
    julgue VARCHAR(255) NULL,
    ativo TINYINT(1) DEFAULT 1,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_prova (prova_id),
    INDEX idx_disciplina (disciplina_id),
    INDEX idx_ativo (ativo),
    FOREIGN KEY (prova_id) REFERENCES provas(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (disciplina_id) REFERENCES disciplinas(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: proposicoes
CREATE TABLE proposicoes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    questao_id INT UNSIGNED NOT NULL,
    numero_ordem SMALLINT UNSIGNED NOT NULL,
    texto TEXT NOT NULL,
    resposta_oficial ENUM('C', 'E', 'X') NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unq_questao_ordem (questao_id, numero_ordem),
    FOREIGN KEY (questao_id) REFERENCES questoes(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: usuarios
CREATE TABLE usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NULL,
    premium_ate DATE NULL,
    ativo TINYINT(1) DEFAULT 1,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY unq_email (email)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: respostas_usuarios
CREATE TABLE respostas_usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    proposicao_id INT UNSIGNED NOT NULL,
    resposta ENUM('C', 'E') NOT NULL,
    data_resposta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY unq_usuario_proposicao (usuario_id, proposicao_id),
    INDEX idx_usuario (usuario_id),
    INDEX idx_proposicao (proposicao_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (proposicao_id) REFERENCES proposicoes(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- 4. Inserir dados iniciais (opcional)
-- -----------------------------------------------------

-- Inserir uma banca de exemplo
INSERT INTO bancas (nome) VALUES ('CACD / CEBRASPE') 
ON DUPLICATE KEY UPDATE nome = nome;

-- Inserir disciplinas de exemplo
INSERT INTO disciplinas (nome) VALUES 
('LÍNGUA PORTUGUESA'),
('HISTÓRIA DO BRASIL'),
('HISTÓRIA MUNDIAL'),
('GEOGRAFIA'),
('LÍNGUA INGLESA'),
('POLÍTICA INTERNACIONAL'),
('DIREITO')
ON DUPLICATE KEY UPDATE nome = nome;

-- -----------------------------------------------------
-- 5. Verificar se tudo foi criado corretamente
-- -----------------------------------------------------
SHOW TABLES;
SELECT 'Banco de dados criado com sucesso!' AS Status;