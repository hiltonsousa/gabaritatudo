<?php
// admin/index.php (dashboard principal)
require_once dirname(__DIR__) . '/app/bootstrap.php';
Auth::requireAdmin();

$adminController = new AdminController();
$stats = $adminController->getStats();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Gabarita Tudo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f5f5;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100%;
            background: #2d3748;
            color: white;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #4a5568;
            margin-bottom: 20px;
        }
        
        .sidebar-header h2 {
            font-size: 1.2rem;
        }
        
        .sidebar-header p {
            font-size: 0.85rem;
            color: #a0aec0;
            margin-top: 5px;
        }
        
        .nav-item {
            padding: 12px 20px;
            color: #cbd5e0;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }
        
        .nav-item:hover {
            background: #4a5568;
            color: white;
        }
        
        .nav-item.active {
            background: #667eea;
            color: white;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .logout-btn {
            background: #e53e3e;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #c53030;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .quick-actions {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .quick-actions h3 {
            margin-bottom: 15px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a67d8;
        }
        
        .btn-secondary {
            background: #48bb78;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #38a169;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>📚 Gabarita Tudo</h2>
            <p>Painel Administrativo</p>
        </div>
        
        <nav>
            <a href="/admin/" class="nav-item active">📊 Dashboard</a>
            <a href="/admin/questoes/listar.php" class="nav-item">📝 Questões</a>
            <a href="/admin/provas/listar.php" class="nav-item">📖 Provas</a>
            <a href="/admin/disciplinas/listar.php" class="nav-item">📚 Disciplinas</a>
            <a href="/admin/bancas/listar.php" class="nav-item">🏛️ Bancas</a>
        </nav>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <a href="/admin/logout.php" class="logout-btn">Sair</a>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total de Questões</h3>
                <div class="stat-number"><?php echo $stats['total_questoes']; ?></div>
            </div>
            
            <div class="stat-card">
                <h3>Total de Provas</h3>
                <div class="stat-number"><?php echo $stats['total_provas']; ?></div>
            </div>
            
            <div class="stat-card">
                <h3>Total de Disciplinas</h3>
                <div class="stat-number"><?php echo $stats['total_disciplinas']; ?></div>
            </div>
            
            <div class="stat-card">
                <h3>Total de Usuários</h3>
                <div class="stat-number"><?php echo $stats['total_usuarios']; ?></div>
            </div>
        </div>
        
        <div class="quick-actions">
            <h3>Ações Rápidas</h3>
            <div class="action-buttons">
                <a href="/admin/questoes/cadastrar.php" class="btn btn-primary">➕ Nova Questão</a>
                <a href="/admin/provas/cadastrar.php" class="btn btn-primary">📖 Nova Prova</a>
                <a href="/admin/disciplinas/cadastrar.php" class="btn btn-secondary">📚 Nova Disciplina</a>
                <a href="/admin/bancas/cadastrar.php" class="btn btn-secondary">🏛️ Nova Banca</a>
            </div>
        </div>
    </div>
</body>
</html>