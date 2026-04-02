import pdfplumber
import re
import json

def group_lines(words, tolerance=3):
    lines = []
    words = sorted(words, key=lambda w: w["top"])

    for w in words:
        placed = False
        for line in lines:
            if abs(line[0]["top"] - w["top"]) < tolerance:
                line.append(w)
                placed = True
                break
        if not placed:
            lines.append([w])

    # ordenar palavras dentro da linha
    for line in lines:
        line.sort(key=lambda w: w["x0"])

    return [" ".join(w["text"] for w in line) for line in lines]

def pdf_to_text():
    full_text = []
    input_file = input("Input file: ").replace("'", "")
    output_file = input("Output file: ")
    single_column_pages = input("Single column pages: ").split(",")
    if len(single_column_pages) > 0:
        single_column_pages = [int(x) for x in single_column_pages]
    with pdfplumber.open(input_file) as pdf:
        for page in pdf.pages:
            if page.page_number not in single_column_pages:
                words = page.extract_words()
                mid = page.width / 2
                left = [w for w in words if w["x0"] < mid]
                right = [w for w in words if w["x0"] >= mid]

                left_lines = group_lines(left)
                right_lines = group_lines(right)

                full_text.append("\n".join(left_lines + right_lines))
            else:
                full_text.append(page.extract_text())

    document = "\n".join(full_text)

    output_doc = open(output_file,"w")
    output_doc.write(document)
    output_doc.close()

def normalize_text(text):
    return re.sub(r'\n(?!\d+\s)', ' ', text)

def extract_questions(text):
    text = normalize_text(text)
    pattern = r'(\d+)\s+(.*?)(?=\n\d+\s|$)'
    matches = re.findall(pattern, text, re.DOTALL)
    result = []
    for id, item in matches:
        result.append({
            "id": int(id),
            "item": item.strip()
        })
    return result

def format_text(pattern, raw_text):
    print(raw_text)
    input()
    arr = raw_text.split("\n\n")

    text = ""
    reference = ""
    judge = ""
    items = []

    if pattern == "TRCQ":
        text = arr[0].replace("\n", " ")
        reference = arr[1].replace("\n", " ")
        judge = arr[2].replace("\n", " ")
        items = extract_questions(arr[3])
    elif pattern == "CQ":
        text = arr[0].replace("\n", " ")
        items = extract_questions(arr[1])
    elif pattern == "TCQ":
        text = arr[0].replace("\n", " ")
        judge = arr[1].replace("\n", " ")
        items = extract_questions(arr[2])

    result = {
        "text": text,
        "reference": reference,
        "judge": judge,
        "items": items
    }

    return result

def parse_quiz(text):
    lines = text.splitlines()

    result = []
    current_discipline = None
    current_question = None
    # question_buffer = []
    question_buffer = ""

    i = 0
    while i < len(lines):
        # linha = lines[i].strip()
        linha = lines[i]

        # Nova disciplina
        if linha == "#D#":
            # Salva questão anterior se existir
            if current_question:
                current_question = format_text(current_question["type"], question_buffer)
                # current_question["text"] = "\n".join(question_buffer).strip()
                current_discipline["questions"].append(current_question)
                current_question = None
                # question_buffer = []
                question_buffer = ""

            # Próxima linha é o nome da disciplina
            i += 1
            # nome_disciplina = lines[i].strip()
            nome_disciplina = lines[i]

            current_discipline = {
                "discipline": nome_disciplina,
                "questions": []
            }
            result.append(current_discipline)

        # Nova questão (qualquer marcador que começa com #, exceto #D#)
        elif linha.startswith("#"):
            # Salva questão anterior
            if current_question:
                current_question = format_text(current_question["type"], question_buffer)
                # current_question["text"] = "\n".join(question_buffer).strip()
                current_discipline["questions"].append(current_question)

            # Inicia nova questão
            current_question = {
                "type": linha.replace("#", ""),
                # "text": ""
            }
            # question_buffer = []
            question_buffer = ""

        else:
            # Acumula texto da questão atual
            if current_question:
                # question_buffer.append(linha)
                question_buffer += linha + "\n"

        i += 1

    # Salva última questão
    if current_question:
        current_question = format_text(current_question["type"], question_buffer)
        # current_question["text"] = "\n".join(question_buffer).strip()
        current_discipline["questions"].append(current_question)

    return result

def process_file(input_file, output_file):
    text = open(input_file, "r").read()
    result = parse_quiz(text)
    fo = open(output_file, "w")
    fo.write(json.dumps(result, indent=4))
    fo.close()

if __name__ == "__main__":
    #extract()
    raw_text = """
Bem antes que tentassem me convencer que a data de
nascimento da modernidade era um espirro cartesiano, ou então
um novo interesse empírico pela natureza que transpira das
páginas do Novum Organum de Bacon, ou ainda (mais tarde e
mais “marxista”) a abertura dos primeiros bancos — bem antes
de tudo isso, quando era rapaz, se ensinava que a modernidade
começou em outubro de 1492. Nos livros da escola, o primeiro
capítulo dos tempos modernos eram e são as grandes
explorações. Entre estas, a viagem de Colombo ocupa um lugar
muito especial. Descidas Saara adentro ou intermináveis
caravanas por montes e desertos até a China de nada valiam
comparadas com a aventura do genovês. Precisa ler
Mediterrâneo de Fernand Braudel para conceber o alcance
simbólico do pulo além de Gibraltar, não costeando, mas reto
para frente. Precisa, entre outras palavras, evocar o mar
Mediterrâneo — este pátio comum navegável e navegado por
milênios, espécie de útero vital compartilhado — para entender
por que a viagem de Colombo acabou e continua sendo uma
metáfora do fim do mundo fechado, do abandono da casa
materna e paterna.

Contardo Calligaris. A psicanálise e o sujeito colonial.
In: Edson L. A. Sousa (org.). Psicanálise e colonização: leituras do sintoma
social no Brasil. Porto Alegre: Artes e Ofícios, 1999, p. 11-12 (com adaptações).

Relativo ao texto precedente, julgue:

1 No quarto período, a referência às viagens e explorações
realizadas antes da descoberta da América demonstra como
era (e é) considerado grandioso o feito de Colombo nos
livros escolares.
2 No texto são mencionadas quatro diferentes visões do
movimento filosófico e artístico que, no Brasil, teve seu
ápice em 1922.
3 Nos dois últimos períodos do texto, a substituição de
“Precisa” por É preciso manteria inalterada a função
sintática das orações “ler Mediterrâneo de Fernand
Braudel” e “evocar o mar Mediterrâneo”.
4 Segundo o autor do texto, o ensino da história da
modernidade dirigido aos jovens fixou-se em um passado
que se mantém como referência dos tempos modernos apesar
das concepções relacionadas ao que foi chamado no texto de
“espirro cartesiano”.
5 No primeiro período do texto, o trecho “Bem antes que (...)
bem antes de tudo isso” indica quando a modernidade
começou, assim como o faz o trecho “em outubro de 1492”.
6 Pela leitura do texto, é possível relacionar a construção da
história da modernidade a uma perspectiva eurocêntrica,
apesar de o Mediterrâneo fazer parte do passado e do
presente de outras culturas, além da europeia.
7 No texto, a região do Mediterrâneo representa o mundo
fechado, como identificável, no último período do texto, no
uso conotativo das expressões “útero” e “casa materna e
paterna”, embora essa visão seja minimizada pela ideia
transmitida por “navegável e navegado”.
    """
    raw_text = """"
Em relação ao governo Vargas (1930-1945), julgue:

56 Os institutos de aposentadoria e pensões foram fundados
ainda no governo provisório de Vargas como forma de
unificar o sistema de previdência social, sob a gestão do
recém-criado Ministério do Trabalho.
57 A Ação Integralista Brasileira (AIB), movimento liderado
por Plínio Salgado na década de 1930, incorporou elementos
de discriminação contra judeus em sua ideologia, inspirada
em parte no fascismo europeu da época.
58 O voto feminino no Brasil, fundamental na luta pela
igualdade de gênero no país — liderada, por exemplo, por
Bertha Lutz, Leolinda Daltro e Carlota Pereira de Queirós —,
foi conquistado em 1932 após forte resistência conservadora,
que alegava desvio do papel da mulher no lar e se estruturara
a partir de pressões religiosas e de setores da elite política.
59 O aumento da demanda por energia elétrica foi consequência
imediata do processo de industrialização e urbanização do
Brasil nos anos 1930, o que levou o primeiro Governo
Vargas a estabelecer um novo modelo energético, pautado na
ação direta do Estado e na construção de grandes
hidrelétricas, como a de Paulo Afonso, inaugurada ainda no
Estado Novo.
60 A criação de sindicatos únicos, com o monopólio da
representação de determinada categoria, ocorreu com a
primeira Lei Sindical, de 1931, modelo substituído
posteriormente pela pluralidade sindical limitada,
estabelecida pela Constituição de 1934."""
    raw_text = """"
O país A tem abundância de mão de obra, e o país B tem
abundância de capital. A produção do bem X é mais intensiva em
mão de obra, enquanto a produção do bem Y é mais intensiva
em capital.

Considerando a situação hipotética apresentada e as teorias
neoclássicas do comércio internacional, que aperfeiçoaram a
análise proposta pela teoria clássica, incluindo a possibilidade de
incorporar múltiplos fatores de produção, julgue:

201 De acordo com o teorema de Samuelson-Stolper,
uma política protecionista voltada à importação do bem Y no
país B tende a aumentar a remuneração da mão de obra
no país B.
202 Um resultado da aplicação do modelo de Hecksher-Ohlin,
atendidos todos os seus pressupostos, é que o comércio
exterior tende a aumentar a remuneração da mão de obra no
país A.
"""
    # r = format_text("TCQ", raw_text)
    # print(json.dumps(r, indent=2))

    fi = input("Input file: ").replace("'", "")
    fo = input("Output file: ")
    process_file(fi, fo)

