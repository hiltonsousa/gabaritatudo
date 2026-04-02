<?php

// Carregar configurações do banco
require_once __DIR__ . '/config/database.php';

// Autoloader simples para classes
spl_autoload_register(function ($class_name) {
    $paths = [
        __DIR__ . '/models/',
        __DIR__ . '/controllers/',
        __DIR__ . '/helpers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Carregar helpers
$helpersFile = __DIR__ . '/helpers/functions.php';
if (file_exists($helpersFile)) {
    require_once $helpersFile;
}

// Configurar sessão segura
if (session_status() === PHP_SESSION_NONE) {
    // Configurar diretório de sessões
    $sessionPath = dirname(__DIR__) . '/storage/sessions';
    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0755, true);
    }
    ini_set('session.save_path', $sessionPath);
    
    // Configurações de segurança da sessão
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    
    session_start();
}

// Configurar timezone
date_default_timezone_set('America/Sao_Paulo');