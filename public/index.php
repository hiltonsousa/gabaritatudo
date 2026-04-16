<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar bootstrap (fora da pasta public)
require_once dirname(__DIR__) . '/app/bootstrap.php';

// Roteamento simples
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remover query string e base path
$request = strtok($request, '?');
$request = str_replace('/index.php', '', $request);
$request = $request ?: '/';

// Rotas da aplicação
switch ($request) {
    case '/':
    case '/home':
        // Página inicial com filtros
        require_once __DIR__ . '/views/home.php';
        break;
        
    case '/api/questoes':
        // API para listar questões
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if (class_exists('QuestaoController')) {
            $controller = new QuestaoController();
            $controller->apiListar();
        } else {
            echo json_encode(['error' => 'Controller não encontrado']);
        }
        break;
        
    case '/api/filtros':
        // API para obter opções de filtro
        header('Content-Type: application/json');
        
        if (class_exists('FiltroController')) {
            $controller = new FiltroController();
            $controller->getOpcoes();
        } else {
            echo json_encode(['error' => 'Controller não encontrado']);
        }
        break;

    case '/api/questoes/random':
        // API para listar questões em ordem aleatória
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        if (class_exists('QuestaoController')) {
            $controller = new QuestaoController();
            $controller->apiListarRandom();
        } else {
            echo json_encode(['error' => 'Controller não encontrado']);
        }
        break;
        
    default:
        // Verificar se é arquivo estático (css, js, imagens)
        $file = __DIR__ . $request;
        if (file_exists($file) && !is_dir($file)) {
            return false; // Deixa o Apache servir o arquivo
        }
        
        // Página não encontrada
        http_response_code(404);
        require_once __DIR__ . '/views/404.php';
        break;
}