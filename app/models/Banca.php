<?php
// app/models/Banca.php
class Banca extends Model {
    protected $table = 'bancas';
    
    public function getAll() {
        return $this->findAll('nome ASC');
    }
}