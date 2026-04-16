#!/bin/bash

OUTPUT="codigo_completo_$(date +%Y%m%d_%H%M%S).proj"

# Pastas a ignorar (ajuste conforme seu projeto)
IGNORE_PATTERNS=(
    "vendor"
    "node_modules" 
    ".git"
    "storage"
    "bootstrap/cache"
    "cache"
    "logs"
    "tmp"
    "temp"
    ".idea"
    ".vscode"
    "venv"
    ".github"
    "__pycache__"
)

# Função para verificar se deve ignorar o caminho
should_ignore() {
    local path="$1"
    for pattern in "${IGNORE_PATTERNS[@]}"; do
        if [[ "$path" == *"/$pattern/"* ]] || [[ "$path" == *"/$pattern" ]]; then
            return 0
        fi
    done
    return 1
}

echo "Gerando: $OUTPUT"

# 1. Estrutura
echo "=== ESTRUTURA DO PROJETO ===" > $OUTPUT
echo "" >> $OUTPUT

# Usando find com exclusão via função (mais confiável)
find . -type d | sort | while read dir; do
    if ! should_ignore "$dir"; then
        # Mostra com indentação simples
        level=$(echo "$dir" | tr -cd '/' | wc -c)
        indent=$(printf '%*s' $level '')
        echo "${indent}📁 $(basename "$dir")/" >> $OUTPUT
    fi
done

echo "" >> $OUTPUT
echo "=== CONTEÚDO DOS ARQUIVOS ===" >> $OUTPUT
echo "" >> $OUTPUT

# 2. Conteúdo
for ext in php html htm js css sql conf md; do
    find . -type f -name "*.$ext" | sort | while read file; do
        if ! should_ignore "$file"; then
            echo "" >> $OUTPUT
            echo "=========================================" >> $OUTPUT
            echo "📄 $file" >> $OUTPUT
            echo "=========================================" >> $OUTPUT
            echo "\`\`\`$ext" >> $OUTPUT
            cat "$file" >> $OUTPUT
            echo "" >> $OUTPUT
            echo "\`\`\`" >> $OUTPUT
        fi
    done
done

echo "✅ Completo! Arquivo: $OUTPUT"