<?php
// admin/questoes/listar.php
require_once dirname(__DIR__, 2) . '/app/bootstrap.php';
Auth::requireAdmin();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;

$questaoModel = new AdminQuestao();
$questoes = $questaoModel->getAllWithRelations($page, $limit);
$total = $questaoModel->getTotalCount();
$totalPages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questões - Admin Gabarita Tudo</title>
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
        
        .nav-item {
            padding: 12px 20px;
            color: #cbd5e0;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }
        
        .nav-item:hover, .nav-item.active {
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
        
        .btn-danger {
            background: #e53e3e;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c53030;
        }
        
        .btn-warning {
            background: #ed8936;
            color: white;
        }
        
        .btn-warning:hover {
            background: #dd6b20;
        }
        
        .table-container {
            background: white;
            border-radius: 8px;
            overflow-x: auto;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        th {
            background: #f7fafc;
            font-weight: 600;
            color: #4a5568;
        }
        
        tr:hover {
            background: #f7fafc;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .badge-warning {
            background: #fed7aa;
            color: #9c4221;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .actions a {
            padding: 4px 8px;
            font-size: 0.85rem;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .pagination a, .pagination span {
            padding: 8px 12px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            color: #4a5568;
        }
        
        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .search-box {
            margin-bottom: 20px;
        }
        
        .search-box input {
            padding: 10px;
            width: 300px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
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
            <a href="/admin/" class="nav-item">📊 Dashboard</a>
            <a href="/admin/questoes/listar.php" class="nav-item active">📝 Questões</a>
            <a href="/admin/provas/listar.php" class="nav-item">📖 Provas</a>
            <a href="/admin/disciplinas/listar.php" class="nav-item">📚 Disciplinas</a>
            <a href="/admin/bancas/listar.php" class="nav-item">🏛️ Bancas</a>
        </nav>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Gerenciar Questões</h1>
            <a href="/admin/questoes/cadastrar.php" class="btn btn-primary">+ Nova Questão</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Texto (resumo)</th>
                        <th>Disciplina</th>
                        <th>Prova</th>
                        <th>Proposições</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questoes as $questao): ?>
                    <tr>
                        <td><?php echo $questao['id']; ?></td>
                        <td><?php echo htmlspecialchars(substr($questao['texto'], 0, 100)) . '...'; ?></td>
                        <td><?php echo htmlspecialchars($questao['disciplina_nome']); ?></td>
                        <td><?php echo $questao['ano'] . ' - ' . htmlspecialchars($questao['prova_nome'] ?? 'Sem nome'); ?></td>
                        <td><?php echo $questao['total_proposicoes']; ?></td>
                        <td>
                            <span class="badge <?php echo $questao['ativo'] ? 'badge-success' : 'badge-warning'; ?>">
                                <?php echo $questao['ativo'] ? 'Ativo' : 'Inativo'; ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="/admin/questoes/editar.php?id=<?php echo $questao['id']; ?>" class="btn-warning" style="padding: 4px 8px;">✏️ Editar</a>
                            <a href="/admin/questoes/excluir.php?id=<?php echo $questao['id']; ?>" class="btn-danger" style="padding: 4px 8px;" onclick="return confirm('Tem certeza que deseja excluir esta questão?')">🗑️ Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>