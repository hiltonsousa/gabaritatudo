<?php
// app/controllers/AdminController.php
class AdminController {
    
    public function getStats() {
        $db = Database::getInstance()->getConnection();
        
        $stats = [];
        
        // Total de questões
        $stmt = $db->query("SELECT COUNT(*) as total FROM questoes");
        $stats['total_questoes'] = $stmt->fetch()['total'];
        
        // Total de provas
        $stmt = $db->query("SELECT COUNT(*) as total FROM provas");
        $stats['total_provas'] = $stmt->fetch()['total'];
        
        // Total de disciplinas
        $stmt = $db->query("SELECT COUNT(*) as total FROM disciplinas");
        $stats['total_disciplinas'] = $stmt->fetch()['total'];
        
        // Total de usuários
        $stmt = $db->query("SELECT COUNT(*) as total FROM usuarios");
        $stats['total_usuarios'] = $stmt->fetch()['total'];
        
        return $stats;
    }
}