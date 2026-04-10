<?php
// app/models/Proposicao.php
class Proposicao extends Model {
    protected $table = 'proposicoes';
    
    public function create($data) {
        $sql = "INSERT INTO proposicoes (questao_id, numero_ordem, texto, resposta_oficial) 
                VALUES (:questao_id, :numero_ordem, :texto, :resposta_oficial)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'questao_id' => $data['questao_id'],
            'numero_ordem' => $data['numero_ordem'],
            'texto' => $data['texto'],
            'resposta_oficial' => $data['resposta_oficial']
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE proposicoes SET 
                    numero_ordem = :numero_ordem,
                    texto = :texto,
                    resposta_oficial = :resposta_oficial
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'numero_ordem' => $data['numero_ordem'],
            'texto' => $data['texto'],
            'resposta_oficial' => $data['resposta_oficial']
        ]);
    }
    
    public function deleteByQuestao($questaoId) {
        $sql = "DELETE FROM proposicoes WHERE questao_id = :questao_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['questao_id' => $questaoId]);
    }
    
    public function getByQuestao($questaoId) {
        $sql = "SELECT * FROM proposicoes WHERE questao_id = :questao_id ORDER BY numero_ordem ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['questao_id' => $questaoId]);
        return $stmt->fetchAll();
    }
}