<?php
// app/models/Questao.php
class Questao extends Model {
    protected $table = 'questoes';
    
    public function getWithFilters($disciplinaId = null, $ano = null, $bancaId = null, $limit = 20, $offset = 0) {
        $sql = "SELECT q.*, 
                       d.nome as disciplina_nome,
                       p.ano,
                       b.nome as banca_nome,
                       (SELECT COUNT(*) FROM proposicoes WHERE questao_id = q.id) as total_proposicoes
                FROM questoes q
                JOIN disciplinas d ON q.disciplina_id = d.id
                JOIN provas p ON q.prova_id = p.id
                LEFT JOIN bancas b ON p.banca_id = b.id
                WHERE q.ativo = 1";
        
        $params = [];
        
        if ($disciplinaId) {
            $sql .= " AND q.disciplina_id = :disciplina_id";
            $params['disciplina_id'] = $disciplinaId;
        }
        
        if ($ano) {
            $sql .= " AND p.ano = :ano";
            $params['ano'] = $ano;
        }
        
        if ($bancaId) {
            $sql .= " AND p.banca_id = :banca_id";
            $params['banca_id'] = $bancaId;
        }
        
        $sql .= " ORDER BY p.ano DESC, q.id ASC LIMIT :limit OFFSET :offset";
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => &$val) {
            $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $val, $type);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getTotalCount($disciplinaId = null, $ano = null, $bancaId = null) {
        $sql = "SELECT COUNT(*) as total 
                FROM questoes q
                JOIN provas p ON q.prova_id = p.id
                WHERE q.ativo = 1";
        
        $params = [];
        
        if ($disciplinaId) {
            $sql .= " AND q.disciplina_id = :disciplina_id";
            $params['disciplina_id'] = $disciplinaId;
        }
        
        if ($ano) {
            $sql .= " AND p.ano = :ano";
            $params['ano'] = $ano;
        }
        
        if ($bancaId) {
            $sql .= " AND p.banca_id = :banca_id";
            $params['banca_id'] = $bancaId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    public function getProposicoes($questaoId) {
        $sql = "SELECT * FROM proposicoes 
                WHERE questao_id = :questao_id 
                ORDER BY numero_ordem ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['questao_id' => $questaoId]);
        return $stmt->fetchAll();
    }
    
    public function getSingleWithProposicoes($questaoId) {
        $sql = "SELECT q.*, 
                       d.nome as disciplina_nome,
                       p.ano,
                       b.nome as banca_nome
                FROM questoes q
                JOIN disciplinas d ON q.disciplina_id = d.id
                JOIN provas p ON q.prova_id = p.id
                LEFT JOIN bancas b ON p.banca_id = b.id
                WHERE q.id = :id AND q.ativo = 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $questaoId]);
        $questao = $stmt->fetch();
        
        if ($questao) {
            $questao['proposicoes'] = $this->getProposicoes($questaoId);
        }
        
        return $questao;
    }

    public function getAllRandom($disciplinaId = null, $ano = null, $bancaId = null, $limit = 1000) {
        $sql = "SELECT q.*, 
                       d.nome as disciplina_nome,
                       p.ano,
                       b.nome as banca_nome,
                       (SELECT COUNT(*) FROM proposicoes WHERE questao_id = q.id) as total_proposicoes
                FROM questoes q
                JOIN disciplinas d ON q.disciplina_id = d.id
                JOIN provas p ON q.prova_id = p.id
                LEFT JOIN bancas b ON p.banca_id = b.id
                WHERE q.ativo = 1";
        
        $params = [];
        
        if ($disciplinaId) {
            $sql .= " AND q.disciplina_id = :disciplina_id";
            $params['disciplina_id'] = $disciplinaId;
        }
        
        if ($ano) {
            $sql .= " AND p.ano = :ano";
            $params['ano'] = $ano;
        }
        
        if ($bancaId) {
            $sql .= " AND p.banca_id = :banca_id";
            $params['banca_id'] = $bancaId;
        }
        
        $sql .= " ORDER BY RAND() LIMIT :limit";
        $params['limit'] = $limit;
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => &$val) {
            $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $val, $type);
        }
        
        $stmt->execute();
        $questoes = $stmt->fetchAll();
        
        // Carregar proposições para cada questão
        foreach ($questoes as &$questao) {
            $questao['proposicoes'] = $this->getProposicoes($questao['id']);
        }
        
        return $questoes;
    }
}