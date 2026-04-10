<?php
// app/models/Prova.php
class Prova extends Model {
    protected $table = 'provas';
    
    public function getAll() {
        $sql = "SELECT p.*, b.nome as banca_nome 
                FROM provas p 
                LEFT JOIN bancas b ON p.banca_id = b.id 
                ORDER BY p.ano DESC, p.nome ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getAnosDisponiveis() {
        $sql = "SELECT DISTINCT ano FROM provas ORDER BY ano DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}