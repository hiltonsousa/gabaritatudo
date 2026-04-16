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
        
        .question-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .question-meta {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .badge {
            background: #e0e7ff;
            color: #4c51bf;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
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
            margin: 15px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            transition: all 0.3s;
        }
        
        .proposition.correct {
            background: #c6f6d5;
            border-left-color: #38a169;
        }
        
        .proposition.incorrect {
            background: #fed7d7;
            border-left-color: #e53e3e;
        }
        
        .proposition-text {
            margin-bottom: 12px;
            font-weight: 500;
        }
        
        .proposition-options {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .proposition-options label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        
        .proposition-options label:hover {
            background: #e2e8f0;
        }
        
        .proposition-options input {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }
        
        .feedback {
            margin-top: 10px;
            padding: 8px;
            border-radius: 6px;
            font-size: 0.85rem;
            display: none;
        }
        
        .feedback.show {
            display: block;
        }
        
        .feedback.correct {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .feedback.incorrect {
            background: #fed7d7;
            color: #742a2a;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            justify-content: center;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: #38a169;
            color: white;
        }
        
        .btn-success:hover {
            background: #2f855a;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #718096;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #4a5568;
            transform: translateY(-2px);
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        .progress {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: #edf2f7;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #4a5568;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            font-size: 1.2rem;
            color: #666;
        }
        
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
            
            .question-container {
                padding: 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
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
        
        <div class="ad-container" id="adTop" style="display: none;">
            <div class="ad-label">Publicidade</div>
            <div id="googleAdTop"></div>
        </div>
        
        <div id="questionArea">
            <div class="loading">Carregando questões...</div>
        </div>
        
        <div class="ad-container" id="adBottom" style="display: none;">
            <div class="ad-label">Publicidade</div>
            <div id="googleAdBottom"></div>
        </div>
    </div>
    
    <script>
        let questions = [];
        let currentIndex = 0;
        let currentFilters = {
            disciplina_id: '',
            ano: '',
            banca_id: ''
        };
        let userAnswers = {};
        let validated = false;
        
        async function loadFilters() {
            try {
                const response = await fetch('/api/filtros');
                const data = await response.json();
                
                if (data.success) {
                    const disciplinaSelect = document.getElementById('disciplinaFilter');
                    data.data.disciplinas.forEach(disciplina => {
                        const option = document.createElement('option');
                        option.value = disciplina.id;
                        option.textContent = disciplina.nome;
                        disciplinaSelect.appendChild(option);
                    });
                    
                    const anoSelect = document.getElementById('anoFilter');
                    data.data.anos.forEach(ano => {
                        const option = document.createElement('option');
                        option.value = ano.ano;
                        option.textContent = ano.ano;
                        anoSelect.appendChild(option);
                    });
                    
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
        
        async function loadQuestions() {
            const area = document.getElementById('questionArea');
            area.innerHTML = '<div class="loading">Carregando questões...</div>';
            
            try {
                const params = new URLSearchParams({
                    page: 1,
                    limit: 1000,
                    ...currentFilters
                });
                
                const response = await fetch(`/api/questoes?${params}`);
                const data = await response.json();
                
                if (data.success && data.data.length > 0) {
                    questions = shuffleArray(data.data);
                    currentIndex = 0;
                    userAnswers = {};
                    validated = false;
                    displayCurrentQuestion();
                } else {
                    area.innerHTML = '<div class="loading">Nenhuma questão encontrada com os filtros selecionados.</div>';
                }
            } catch (error) {
                console.error('Erro ao carregar questões:', error);
                area.innerHTML = '<div class="loading">Erro ao carregar questões. Tente novamente.</div>';
            }
        }
        
        function shuffleArray(array) {
            const shuffled = [...array];
            for (let i = shuffled.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
            }
            return shuffled;
        }
        
        function displayCurrentQuestion() {
            if (currentIndex >= questions.length) {
                document.getElementById('questionArea').innerHTML = `
                    <div class="question-container">
                        <h2>🎉 Parabéns!</h2>
                        <p>Você completou todas as questões!</p>
                        <button class="btn btn-primary" onclick="resetQuestions()">Recomeçar</button>
                    </div>
                `;
                return;
            }
            
            const question = questions[currentIndex];
            const isSingleProposition = question.total_proposicoes === 1;
            
            let html = `
                <div class="question-container">
                    <div class="question-meta">
                        <span class="badge">${escapeHtml(question.disciplina_nome)}</span>
                        <span class="badge badge-year">${question.ano}</span>
                        ${question.banca_nome ? `<span class="badge">${escapeHtml(question.banca_nome)}</span>` : ''}
                        <span class="badge">${isSingleProposition ? 'Certo ou Errado' : 'Múltipla escolha'}</span>
                    </div>
                    
                    ${question.referencia ? `<div class="question-reference">${escapeHtml(question.referencia)}</div>` : ''}
                    
                    <div class="question-text">
                        ${escapeHtml(question.texto)}
                    </div>
                    
                    ${question.julgue ? `<div class="question-reference"><strong>Julgue:</strong> ${escapeHtml(question.julgue)}</div>` : ''}
                    
                    <div class="propositions">
            `;
            
            question.proposicoes.forEach(prop => {
                const savedAnswer = userAnswers[prop.id];
                const isCorrect = savedAnswer && validated && savedAnswer === prop.resposta_oficial;
                const isIncorrect = savedAnswer && validated && savedAnswer !== prop.resposta_oficial && prop.resposta_oficial !== 'X';
                
                let propositionClass = '';
                if (validated) {
                    if (isCorrect) propositionClass = 'correct';
                    if (isIncorrect) propositionClass = 'incorrect';
                }
                
                html += `
                    <div class="proposition ${propositionClass}" data-prop-id="${prop.id}">
                        <div class="proposition-text">
                            <strong>${prop.numero_ordem}.</strong> ${escapeHtml(prop.texto)}
                        </div>
                        <div class="proposition-options">
                            <label>
                                <input type="radio" name="prop_${prop.id}" value="C" 
                                    ${savedAnswer === 'C' ? 'checked' : ''}
                                    ${validated ? 'disabled' : ''}>
                                Certo
                            </label>
                            <label>
                                <input type="radio" name="prop_${prop.id}" value="E" 
                                    ${savedAnswer === 'E' ? 'checked' : ''}
                                    ${validated ? 'disabled' : ''}>
                                Errado
                            </label>
                        </div>
                        <div class="feedback ${validated ? 'show' : ''} ${isCorrect ? 'correct' : (isIncorrect ? 'incorrect' : '')}">
                            ${validated ? getFeedbackMessage(prop, savedAnswer) : ''}
                        </div>
                    </div>
                `;
            });
            
            html += `
                    </div>
                    
                    <div class="action-buttons">
                        ${!validated ? `<button class="btn btn-success" onclick="validateAnswers()">✅ Validar Respostas</button>` : ''}
                        <button class="btn btn-primary" onclick="nextQuestion()" ${!validated && currentIndex < questions.length - 1 ? 'disabled' : ''}>▶ Próxima Questão</button>
                    </div>
                    
                    <div class="progress">
                        Questão ${currentIndex + 1} de ${questions.length}
                    </div>
                </div>
            `;
            
            document.getElementById('questionArea').innerHTML = html;
            
            if (!validated) {
                attachRadioListeners();
            }
        }
        
        function attachRadioListeners() {
            const question = questions[currentIndex];
            question.proposicoes.forEach(prop => {
                const radios = document.querySelectorAll(`input[name="prop_${prop.id}"]`);
                radios.forEach(radio => {
                    radio.addEventListener('change', (e) => {
                        if (!validated) {
                            userAnswers[prop.id] = e.target.value;
                        }
                    });
                });
            });
        }
        
        function validateAnswers() {
            const question = questions[currentIndex];
            let hasAllAnswers = true;
            
            question.proposicoes.forEach(prop => {
                if (!userAnswers[prop.id]) {
                    hasAllAnswers = false;
                }
            });
            
            if (!hasAllAnswers) {
                alert('Por favor, responda todas as proposições antes de validar.');
                return;
            }
            
            validated = true;
            displayCurrentQuestion();
            
            // Mostrar anúncio após validação (a cada 3 questões)
            const questionNumber = currentIndex + 1;
            if (questionNumber % 3 === 0 && window.innerWidth <= 768) {
                showFullscreenAd();
            }
        }
        
        function getFeedbackMessage(prop, userAnswer) {
            if (prop.resposta_oficial === 'X') {
                return '⚠️ Esta proposição foi anulada pela banca.';
            }
            
            const isCorrect = userAnswer === prop.resposta_oficial;
            const expectedText = prop.resposta_oficial === 'C' ? 'Certo' : 'Errado';
            
            if (isCorrect) {
                return '✅ Correto! Parabéns.';
            } else {
                return `❌ Incorreto. A resposta correta é: ${expectedText}.`;
            }
        }
        
        function nextQuestion() {
            if (!validated && currentIndex < questions.length - 1) {
                alert('Você precisa validar suas respostas antes de avançar.');
                return;
            }
            
            currentIndex++;
            validated = false;
            
            if (currentIndex < questions.length) {
                displayCurrentQuestion();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                displayCurrentQuestion();
            }
        }
        
        function resetQuestions() {
            questions = shuffleArray(questions);
            currentIndex = 0;
            userAnswers = {};
            validated = false;
            displayCurrentQuestion();
        }
        
        function showFullscreenAd() {
            // Placeholder para anúncio de tela cheia
            console.log('Mostrar anúncio de tela cheia');
            // Implementar com Google AdSense ou similar
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        document.getElementById('applyFilters').addEventListener('click', () => {
            currentFilters = {
                disciplina_id: document.getElementById('disciplinaFilter').value,
                ano: document.getElementById('anoFilter').value,
                banca_id: document.getElementById('bancaFilter').value
            };
            loadQuestions();
        });
        
        loadFilters();
        loadQuestions();
    </script>
</body>
</html>