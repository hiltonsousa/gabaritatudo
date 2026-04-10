<?php
// /var/www/dev.gabaritatudo.com.br/app/models/AdminQuestao.php
class AdminQuestao extends Questao {
    
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
    
    // CORRIGIDO: Agora com a mesma assinatura da classe pai
    public function getTotalCount($disciplinaId = null, $ano = null, $bancaId = null) {
        // Ignorar os filtros para o admin (mostrar todas as questões)
        $sql = "SELECT COUNT(*) as total FROM questoes";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}