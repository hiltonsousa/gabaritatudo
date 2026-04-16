#!/usr/bin/env php
<?php
// import_questions.php - Script para importar questões do JSON

// Configuração do banco de dados (ajuste conforme seu ambiente)
define('DB_HOST', 'localhost');
define('DB_NAME', 'sistema_questoes_dev');
define('DB_USER', 'app_questoes_dev');
define('DB_PASS', 'bP64nq$v0J~X||'); // Altere para sua senha

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    
    echo "✅ Conectado ao banco de dados\n";
} catch (PDOException $e) {
    die("❌ Erro ao conectar: " . $e->getMessage() . "\n");
}

// Ler o JSON do arquivo ou da entrada padrão
$jsonContent = '';

if ($argc > 1 && $argv[1] === '--file') {
    // Ler de arquivo
    if ($argc < 3) {
        die("Uso: php import_questions.php --file <arquivo.json>\n");
    }
    $filename = $argv[2];
    if (!file_exists($filename)) {
        die("❌ Arquivo não encontrado: $filename\n");
    }
    $jsonContent = file_get_contents($filename);
    echo "📖 Lendo arquivo: $filename\n";
} else {
    // Ler do stdin (pipe ou redirecionamento)
    $jsonContent = file_get_contents('php://stdin');
    if (empty($jsonContent)) {
        die("❌ Nenhum dado recebido. Use: cat arquivo.json | php import_questions.php\n");
    }
    echo "📖 Lendo da entrada padrão (stdin)\n";
}

// Decodificar JSON
$data = json_decode($jsonContent, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("❌ Erro ao decodificar JSON: " . json_last_error_msg() . "\n");
}

echo "📊 JSON carregado com sucesso!\n";
echo "   Ano: " . ($data['year'] ?? 'N/A') . "\n";
echo "   Autor/Banca: " . ($data['author'] ?? 'N/A') . "\n";
echo "   Total de disciplinas: " . count($data['tests'] ?? []) . "\n\n";

// Iniciar transação
$pdo->beginTransaction();

try {
    // 1. Buscar ou criar a banca
    $bancaNome = $data['author'];
    $stmt = $pdo->prepare("SELECT id FROM bancas WHERE nome = :nome");
    $stmt->execute(['nome' => $bancaNome]);
    $banca = $stmt->fetch();
    
    if ($banca) {
        $bancaId = $banca['id'];
        echo "🏛️ Banca existente: $bancaNome (ID: $bancaId)\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO bancas (nome) VALUES (:nome)");
        $stmt->execute(['nome' => $bancaNome]);
        $bancaId = $pdo->lastInsertId();
        echo "🏛️ Nova banca criada: $bancaNome (ID: $bancaId)\n";
    }
    
    // 2. Criar a prova (uma prova para o ano)
    $ano = $data['year'];
    $stmt = $pdo->prepare("
        INSERT INTO provas (ano, banca_id, nome) 
        VALUES (:ano, :banca_id, :nome)
        ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)
    ");
    $provaNome = "Prova CACD/CEBRASPE - $ano";
    $stmt->execute([
        'ano' => $ano,
        'banca_id' => $bancaId,
        'nome' => $provaNome
    ]);
    $provaId = $pdo->lastInsertId();
    echo "📖 Prova criada: $provaNome (ID: $provaId)\n\n";
    
    $totalQuestoes = 0;
    $totalItens = 0;
    
    // 3. Processar cada disciplina
    foreach ($data['tests'] as $test) {
        $disciplinaNome = $test['discipline'];
        
        // Buscar ou criar disciplina
        $stmt = $pdo->prepare("SELECT id FROM disciplinas WHERE nome = :nome");
        $stmt->execute(['nome' => $disciplinaNome]);
        $disciplina = $stmt->fetch();
        
        if ($disciplina) {
            $disciplinaId = $disciplina['id'];
            echo "📚 Disciplina existente: $disciplinaNome (ID: $disciplinaId)\n";
        } else {
            $stmt = $pdo->prepare("INSERT INTO disciplinas (nome) VALUES (:nome)");
            $stmt->execute(['nome' => $disciplinaNome]);
            $disciplinaId = $pdo->lastInsertId();
            echo "📚 Nova disciplina criada: $disciplinaNome (ID: $disciplinaId)\n";
        }
        
        // Associar prova com disciplina
        $stmt = $pdo->prepare("
            INSERT IGNORE INTO provas_disciplinas (prova_id, disciplina_id) 
            VALUES (:prova_id, :disciplina_id)
        ");
        $stmt->execute([
            'prova_id' => $provaId,
            'disciplina_id' => $disciplinaId
        ]);
        
        // Processar questões da disciplina
        $questions = $test['questions'];
        echo "   📝 Processando " . count($questions) . " questão(ões)...\n";
        
        foreach ($questions as $question) {
            // Inserir questão
            $stmt = $pdo->prepare("
                INSERT INTO questoes (prova_id, disciplina_id, texto, referencia, julgue, ativo) 
                VALUES (:prova_id, :disciplina_id, :texto, :referencia, :julgue, 1)
            ");
            
            $stmt->execute([
                'prova_id' => $provaId,
                'disciplina_id' => $disciplinaId,
                'texto' => $question['text'],
                'referencia' => $question['reference'] ?? null,
                'julgue' => $question['judge'] ?? null
            ]);
            
            $questaoId = $pdo->lastInsertId();
            $totalQuestoes++;
            
            // Inserir itens (proposições)
            $items = $question['items'];
            foreach ($items as $item) {
                $stmt = $pdo->prepare("
                    INSERT INTO proposicoes (questao_id, numero_ordem, texto, resposta_oficial) 
                    VALUES (:questao_id, :numero_ordem, :texto, :resposta_oficial)
                ");
                
                $stmt->execute([
                    'questao_id' => $questaoId,
                    'numero_ordem' => $item['id'],
                    'texto' => $item['item'],
                    'resposta_oficial' => $item['answer']
                ]);
                $totalItens++;
            }
        }
        
        echo "      ✅ $disciplinaNome: " . count($questions) . " questões inseridas\n";
    }
    
    // Confirmar transação
    $pdo->commit();
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "✅ IMPORTAÇÃO CONCLUÍDA COM SUCESSO!\n";
    echo str_repeat("=", 50) . "\n";
    echo "📊 Resumo:\n";
    echo "   - Banca: $bancaNome\n";
    echo "   - Prova: $provaNome (ID: $provaId)\n";
    echo "   - Questões inseridas: $totalQuestoes\n";
    echo "   - Itens (proposições): $totalItens\n";
    echo str_repeat("=", 50) . "\n";
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo "❌ ERRO: " . $e->getMessage() . "\n";
    exit(1);
}