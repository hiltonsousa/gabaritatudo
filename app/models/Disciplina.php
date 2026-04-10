<?php
// app/models/Disciplina.php
class Disciplina extends Model {
    protected $table = 'disciplinas';
    
    public function getAll() {
        return $this->findAll('nome ASC');
    }
}