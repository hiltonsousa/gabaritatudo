<?php
// app/helpers/Auth.php
class Auth {
    
    public static function login($email, $senha) {
        $database = Database::getInstance();
        $db = $database->getConnection();
        
        $sql = "SELECT * FROM usuarios WHERE email = :email AND ativo = 1 LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['is_admin'] = $usuario['is_admin'];
            return true;
        }
        
        return false;
    }
    
    public static function logout() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['usuario_id']);
    }
    
    public static function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /admin/login.php');
            exit();
        }
    }
    
    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('HTTP/1.0 403 Forbidden');
            die('Acesso negado. Você não tem permissão de administrador.');
        }
    }
    
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['usuario_id'],
                'email' => $_SESSION['usuario_email'],
                'nome' => $_SESSION['usuario_nome']
            ];
        }
        return null;
    }
}