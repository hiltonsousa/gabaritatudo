<?php
// app/controllers/FiltroController.php
class FiltroController {
    private $disciplinaModel;
    private $provaModel;
    private $bancaModel;
    
    public function __construct() {
        $this->disciplinaModel = new Disciplina();
        $this->provaModel = new Prova();
        $this->bancaModel = new Banca();
    }
    
    public function getOpcoes() {
        echo json_encode([
            'success' => true,
            'data' => [
                'disciplinas' => $this->disciplinaModel->getAll(),
                'anos' => $this->provaModel->getAnosDisponiveis(),
                'bancas' => $this->bancaModel->getAll()
            ]
        ]);
    }
}