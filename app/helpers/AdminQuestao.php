<?php
// app/models/AdminQuestao.php
class AdminQuestao extends Questao {
    
    public function create($data) {
        $sql = "INSERT INTO questoes (prova_id, disciplina_id, texto, referencia, julgue, ativo) 
                VALUES (:prova_id, :disciplina_id, :texto, :referencia, :julgue, :ativo)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'prova_id' => $data['prova_id'],
            'disciplina_id' => $data['disciplina_id'],
            'texto' => $data['texto'],
            'referencia' => $data['referencia'] ?? null,
            'julgue' => $data['julgue'] ?? null,
            'ativo' => $data['ativo'] ?? 1
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE questoes SET 
                    prova_id = :prova_id,
                    disciplina_id = :disciplina_id,
                    texto = :texto,
                    referencia = :referencia,
                    julgue = :julgue,
                    ativo = :ativo
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'prova_id' => $data['prova_id'],
            'disciplina_id' => $data['disciplina_id'],
            'texto' => $data['texto'],
            'referencia' => $data['referencia'] ?? null,
            'julgue' => $data['julgue'] ?? null,
            'ativo' => $data['ativo'] ?? 1
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM questoes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    public function getAllWithRelations($page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT q.*, 
                       d.nome as disciplina_nome,
                       p.ano,
                       p.nome as prova_nome,
                       b.nome as banca_nome,
                       (SELECT COUNT(*) FROM proposicoes WHERE questao_id = q.id) as total_proposicoes
                FROM questoes q
                JOIN disciplinas d ON q.disciplina_id = d.id
                JOIN provas p ON q.prova_id = p.id
                LEFT JOIN bancas b ON p.banca_id = b.id
                ORDER BY q.id DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM questoes";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}