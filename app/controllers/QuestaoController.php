<?php
// app/controllers/QuestaoController.php
class QuestaoController {
    private $questaoModel;
    
    public function __construct() {
        $this->questaoModel = new Questao();
    }
    
    public function apiListar() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $offset = ($page - 1) * $limit;
        
        $disciplinaId = isset($_GET['disciplina_id']) ? (int)$_GET['disciplina_id'] : null;
        $ano = isset($_GET['ano']) ? (int)$_GET['ano'] : null;
        $bancaId = isset($_GET['banca_id']) ? (int)$_GET['banca_id'] : null;
        
        $questoes = $this->questaoModel->getWithFilters($disciplinaId, $ano, $bancaId, $limit, $offset);
        $total = $this->questaoModel->getTotalCount($disciplinaId, $ano, $bancaId);
        
        // Carregar proposições para cada questão
        foreach ($questoes as &$questao) {
            $questao['proposicoes'] = $this->questaoModel->getProposicoes($questao['id']);
        }
        
        echo json_encode([
            'success' => true,
            'data' => $questoes,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit)
            ]
        ]);
    }
    
    public function apiGetSingle($id) {
        $questao = $this->questaoModel->getSingleWithProposicoes($id);
        
        if ($questao) {
            echo json_encode(['success' => true, 'data' => $questao]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Questão não encontrada']);
        }
    }

    public function apiListarRandom() {
        $disciplinaId = isset($_GET['disciplina_id']) ? (int)$_GET['disciplina_id'] : null;
        $ano = isset($_GET['ano']) ? (int)$_GET['ano'] : null;
        $bancaId = isset($_GET['banca_id']) ? (int)$_GET['banca_id'] : null;
        $limit = isset($_GET['limit']) ? min((int)$_GET['limit'], 500) : 100;
        
        $questoes = $this->questaoModel->getAllRandom($disciplinaId, $ano, $bancaId, $limit);
        
        echo json_encode([
            'success' => true,
            'data' => $questoes,
            'total' => count($questoes)
        ]);
    }
}