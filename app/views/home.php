<?php
// public/views/home.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Sistema de Questões - Gabarita Tudo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 1.8rem;
        }
        
        /* Filtros */
        .filters {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-group {
            flex: 1;
            min-width: 150px;
        }
        
        .filter-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #666;
        }
        
        .filter-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
        }
        
        .filter-group button {
            width: 100%;
            padding: 10px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 22px;
        }
        
        .filter-group button:hover {
            background: #5a67d8;
        }
        
        /* Questões */
        .questions-container {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .question-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .question-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .question-meta {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            font-size: 0.85rem;
        }
        
        .badge {
            background: #e0e7ff;
            color: #4c51bf;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-year {
            background: #fed7aa;
            color: #9c4221;
        }
        
        .question-text {
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .question-reference {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 15px;
            font-style: italic;
        }
        
        .proposition {
            margin: 12px 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .proposition-text {
            margin-bottom: 10px;
        }
        
        .proposition-options {
            display: flex;
            gap: 15px;
        }
        
        .proposition-options label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }
        
        .proposition-options input {
            cursor: pointer;
        }
        
        .question-footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
            font-size: 0.85rem;
            color: #888;
        }
        
        /* Loading */
        .loading {
            text-align: center;
            padding: 40px;
            font-size: 1.2rem;
            color: #666;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .pagination button {
            padding: 10px 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .pagination button:hover:not(:disabled) {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .filters {
                flex-direction: column;
            }
            
            .filter-group button {
                margin-top: 0;
            }
            
            .question-card {
                padding: 15px;
            }
            
            .question-meta {
                font-size: 0.75rem;
            }
        }
        
        /* Ad container */
        .ad-container {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        
        .ad-label {
            font-size: 0.7rem;
            color: #999;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>📚 Gabarita Tudo</h1>
            <p>Estude com questões de concursos e prepare-se para a aprovação</p>
        </div>
    </div>
    
    <div class="container">
        <!-- Filtros -->
        <div class="filters">
            <div class="filter-group">
                <label>📖 Disciplina</label>
                <select id="disciplinaFilter">
                    <option value="">Todas</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>📅 Ano</label>
                <select id="anoFilter">
                    <option value="">Todos</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label>🏛️ Banca</label>
                <select id="bancaFilter">
                    <option value="">Todas</option>
                </select>
            </div>
            
            <div class="filter-group">
                <button id="applyFilters">🔍 Aplicar Filtros</button>
            </div>
        </div>
        
        <!-- Ad Container Top -->
        <div class="ad-container" id="adTop" style="display: none;">
            <div class="ad-label">Publicidade</div>
            <div id="googleAdTop"></div>
        </div>
        
        <!-- Questões -->
        <div id="questionsContainer" class="questions-container">
            <div class="loading">Carregando questões...</div>
        </div>
        
        <!-- Paginação -->
        <div id="pagination" class="pagination"></div>
        
        <!-- Ad Container Bottom -->
        <div class="ad-container" id="adBottom" style="display: none;">
            <div class="ad-label">Publicidade</div>
            <div id="googleAdBottom"></div>
        </div>
    </div>
    
    <script>
        let currentPage = 1;
        let totalPages = 1;
        let currentFilters = {
            disciplina_id: '',
            ano: '',
            banca_id: ''
        };
        
        // Carregar opções de filtro
        async function loadFilters() {
            try {
                const response = await fetch('/api/filtros');
                const data = await response.json();
                
                if (data.success) {
                    // Disciplinas
                    const disciplinaSelect = document.getElementById('disciplinaFilter');
                    data.data.disciplinas.forEach(disciplina => {
                        const option = document.createElement('option');
                        option.value = disciplina.id;
                        option.textContent = disciplina.nome;
                        disciplinaSelect.appendChild(option);
                    });
                    
                    // Anos
                    const anoSelect = document.getElementById('anoFilter');
                    data.data.anos.forEach(ano => {
                        const option = document.createElement('option');
                        option.value = ano.ano;
                        option.textContent = ano.ano;
                        anoSelect.appendChild(option);
                    });
                    
                    // Bancas
                    const bancaSelect = document.getElementById('bancaFilter');
                    data.data.bancas.forEach(banca => {
                        const option = document.createElement('option');
                        option.value = banca.id;
                        option.textContent = banca.nome;
                        bancaSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Erro ao carregar filtros:', error);
            }
        }
        
        // Carregar questões
        async function loadQuestions() {
            const container = document.getElementById('questionsContainer');
            container.innerHTML = '<div class="loading">Carregando questões...</div>';
            
            try {
                const params = new URLSearchParams({
                    page: currentPage,
                    limit: 10,
                    ...currentFilters
                });
                
                const response = await fetch(`/api/questoes?${params}`);
                const data = await response.json();
                
                if (data.success && data.data.length > 0) {
                    displayQuestions(data.data);
                    setupPagination(data.pagination);
                } else {
                    container.innerHTML = '<div class="loading">Nenhuma questão encontrada com os filtros selecionados.</div>';
                    document.getElementById('pagination').innerHTML = '';
                }
            } catch (error) {
                console.error('Erro ao carregar questões:', error);
                container.innerHTML = '<div class="loading">Erro ao carregar questões. Tente novamente.</div>';
            }
        }
        
        // Exibir questões
        function displayQuestions(questions) {
            const container = document.getElementById('questionsContainer');
            container.innerHTML = '';
            
            questions.forEach((question, index) => {
                const card = document.createElement('div');
                card.className = 'question-card';
                
                // Determinar tipo de questão
                const isSingleProposition = question.total_proposicoes === 1;
                const propositionType = isSingleProposition ? 'Certo ou Errado' : 'Única opção correta';
                
                card.innerHTML = `
                    <div class="question-header">
                        <div class="question-meta">
                            <span class="badge">${question.disciplina_nome}</span>
                            <span class="badge badge-year">${question.ano}</span>
                            ${question.banca_nome ? `<span class="badge">${question.banca_nome}</span>` : ''}
                            <span class="badge">${propositionType}</span>
                        </div>
                    </div>
                    
                    ${question.referencia ? `<div class="question-reference">${question.referencia}</div>` : ''}
                    
                    <div class="question-text">
                        <strong>Questão ${index + 1}:</strong><br>
                        ${question.texto}
                    </div>
                    
                    ${question.julgue ? `<div class="question-reference"><strong>Julgue:</strong> ${question.julgue}</div>` : ''}
                    
                    <div class="propositions">
                        ${question.proposicoes.map(prop => `
                            <div class="proposition">
                                <div class="proposition-text">
                                    <strong>${prop.numero_ordem}.</strong> ${prop.texto}
                                </div>
                                <div class="proposition-options">
                                    ${isSingleProposition ? `
                                        <label><input type="radio" name="prop_${prop.id}" value="C"> Certo</label>
                                        <label><input type="radio" name="prop_${prop.id}" value="E"> Errado</label>
                                    ` : `
                                        <label><input type="radio" name="prop_${prop.id}" value="C"> Opção correta</label>
                                        <label><input type="radio" name="prop_${prop.id}" value="E"> Opção incorreta</label>
                                    `}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="question-footer">
                        <small>Selecione uma opção para cada proposição e confira o gabarito oficial.</small>
                    </div>
                `;
                
                container.appendChild(card);
            });
        }
        
        // Configurar paginação
        function setupPagination(pagination) {
            const paginationDiv = document.getElementById('pagination');
            paginationDiv.innerHTML = '';
            
            totalPages = pagination.total_pages;
            
            // Botão anterior
            const prevButton = document.createElement('button');
            prevButton.textContent = '« Anterior';
            prevButton.disabled = currentPage === 1;
            prevButton.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    loadQuestions();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            };
            paginationDiv.appendChild(prevButton);
            
            // Números das páginas (limitado a 5)
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            
            for (let i = startPage; i <= endPage; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className = i === currentPage ? 'active' : '';
                pageButton.onclick = () => {
                    currentPage = i;
                    loadQuestions();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                };
                paginationDiv.appendChild(pageButton);
            }
            
            // Botão próximo
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Próximo »';
            nextButton.disabled = currentPage === totalPages;
            nextButton.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    loadQuestions();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            };
            paginationDiv.appendChild(nextButton);
        }
        
        // Aplicar filtros
        document.getElementById('applyFilters').addEventListener('click', () => {
            currentFilters = {
                disciplina_id: document.getElementById('disciplinaFilter').value,
                ano: document.getElementById('anoFilter').value,
                banca_id: document.getElementById('bancaFilter').value
            };
            currentPage = 1;
            loadQuestions();
        });
        
        // Inicializar
        loadFilters();
        loadQuestions();
    </script>
</body>
</html>