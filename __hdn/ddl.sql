-- =========================
-- 1. EXAMS (provas / conjuntos)
-- =========================
CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    organization VARCHAR(255),
    year INT,
    type ENUM('exam', 'subject') DEFAULT 'exam',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- 2. SUBJECTS (disciplinas)
-- =========================
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    FOREIGN KEY (parent_id) REFERENCES subjects(id)
);

-- =========================
-- 3. RELAÇÃO EXAM x SUBJECT
-- =========================
CREATE TABLE exam_subjects (
    exam_id INT,
    subject_id INT,
    PRIMARY KEY (exam_id, subject_id),
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- =========================
-- 4. QUESTION GROUPS (texto base)
-- =========================
CREATE TABLE question_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_id INT NOT NULL,
    subject_id INT,
    text TEXT NOT NULL,
    reference TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

CREATE INDEX idx_groups_exam ON question_groups(exam_id);

-- =========================
-- 5. QUESTION ITEMS (itens)
-- =========================
CREATE TABLE question_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    statement TEXT NOT NULL,
    type ENUM('boolean', 'multiple_choice') DEFAULT 'boolean',
    correct_answer VARCHAR(5) NOT NULL,
    explanation TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES question_groups(id) ON DELETE CASCADE
);

CREATE INDEX idx_items_group ON question_items(group_id);

-- =========================
-- 6. OPTIONS (múltipla escolha)
-- =========================
CREATE TABLE question_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    label VARCHAR(5) NOT NULL,
    text TEXT NOT NULL,
    FOREIGN KEY (item_id) REFERENCES question_items(id) ON DELETE CASCADE
);

CREATE INDEX idx_options_item ON question_options(item_id);

-- =========================
-- 7. USERS (opcional)
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    password_hash VARCHAR(255),
    is_premium BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- 8. ATTEMPTS (simulados)
-- =========================
CREATE TABLE attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    mode ENUM('exam', 'random') NOT NULL,
    exam_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    finished_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE SET NULL
);

-- =========================
-- 9. ANSWERS (respostas)
-- =========================
CREATE TABLE attempt_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attempt_id INT NOT NULL,
    item_id INT NOT NULL,
    user_answer VARCHAR(5),
    is_correct BOOLEAN,
    response_time_ms INT,
    FOREIGN KEY (attempt_id) REFERENCES attempts(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES question_items(id) ON DELETE CASCADE
);

CREATE INDEX idx_attempt_answers_attempt ON attempt_answers(attempt_id);
CREATE INDEX idx_attempt_answers_item ON attempt_answers(item_id);

-- =========================
-- 10. STATS (estatísticas)
-- =========================
CREATE TABLE question_stats (
    item_id INT PRIMARY KEY,
    total_answers INT DEFAULT 0,
    total_correct INT DEFAULT 0,
    FOREIGN KEY (item_id) REFERENCES question_items(id) ON DELETE CASCADE
);

-- =========================
-- 11. TAGS (futuro)
-- =========================
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE
);

CREATE TABLE question_tags (
    item_id INT,
    tag_id INT,
    PRIMARY KEY (item_id, tag_id),
    FOREIGN KEY (item_id) REFERENCES question_items(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);