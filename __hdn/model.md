Nós estamos projetando um sistema web que vai apresentar ao usuário provas fechadas, com múltiplas questões. 
Cada questão terá um texto e uma ou mais proposições.
Questões com uma proposição são do tipo "certo" ou "errado"
Questões com mais de uma proposição são do tipo "apenas opção está certa"
Cada questão tem associada: autor/banca (opcional), ano (opcional), disciplina (obrigatorio)
Ao acessar o site, o usuário filtra por disciplina, ano, autor/banca, e tem acesso às questões
por enquanto, vou cadastrar apenas questoes das várias provas do concurso para o itamaraty, mas futuramente terei provas de diversos concursos e mesmo provas para alunos do ensino fundamental, médio e superior estudarem
A ideia inicial é monetizar com propagandas do google (por exemplo, mostrando uma propaganda de tela cheia a cada 3 questoes em telas pequenas, e mostrando uma propaganda por questao no rodapé em telas grandes)
a monetizacao futura poderá ser feita mediante pagamento, usuario/senha e remoçao das propagandas 
backend: servidor ubuntu 22, apache, mysql, php 
frontend: html e javascript puro, responsivo

segue o exemplo de uma prova do itamaraty

{
  "year": 2025,
  "author": "CACD / CEBRASPE",
  "tests": [
    {
      "discipline": "L\u00cdNGUA PORTUGUESA",
      "questions": [
        {
          "text": "Bem antes que tentassem me convencer que a data de nascimento da modernidade era um espirro cartesiano, ou ent\u00e3o um novo interesse emp\u00edrico pela natureza que transpira das p\u00e1ginas do Novum Organum de Bacon, ou ainda (mais tarde e mais \u201cmarxista\u201d) a abertura dos primeiros bancos \u2014 bem antes de tudo isso, quando era rapaz, se ensinava que a modernidade come\u00e7ou em outubro de 1492. Nos livros da escola, o primeiro cap\u00edtulo dos tempos modernos eram e s\u00e3o as grandes explora\u00e7\u00f5es. Entre estas, a viagem de Colombo ocupa um lugar muito especial. Descidas Saara adentro ou intermin\u00e1veis caravanas por montes e desertos at\u00e9 a China de nada valiam comparadas com a aventura do genov\u00eas. Precisa ler Mediterr\u00e2neo de Fernand Braudel para conceber o alcance simb\u00f3lico do pulo al\u00e9m de Gibraltar, n\u00e3o costeando, mas reto para frente. Precisa, entre outras palavras, evocar o mar Mediterr\u00e2neo \u2014 este p\u00e1tio comum naveg\u00e1vel e navegado por mil\u00eanios, esp\u00e9cie de \u00fatero vital compartilhado \u2014 para entender por que a viagem de Colombo acabou e continua sendo uma met\u00e1fora do fim do mundo fechado, do abandono da casa materna e paterna.",
          "reference": "Contardo Calligaris. A psican\u00e1lise e o sujeito colonial. In: Edson L. A. Sousa (org.). Psican\u00e1lise e coloniza\u00e7\u00e3o: leituras do sintoma social no Brasil. Porto Alegre: Artes e Of\u00edcios, 1999, p. 11-12 (com adapta\u00e7\u00f5es).",
          "judge": "Relativo ao texto precedente, julgue:",
          "items": [
            {
              "id": 1,
              "item": "No quarto per\u00edodo, a refer\u00eancia \u00e0s viagens e explora\u00e7\u00f5es realizadas antes da descoberta da Am\u00e9rica demonstra como era (e \u00e9) considerado grandioso o feito de Colombo nos livros escolares.",
              "answer": "C"
            },
            {
              "id": 2,
              "item": "No texto s\u00e3o mencionadas quatro diferentes vis\u00f5es do movimento filos\u00f3fico e art\u00edstico que, no Brasil, teve seu \u00e1pice em 1922.",
              "answer": "E"
            },
            {
              "id": 3,
              "item": "Nos dois \u00faltimos per\u00edodos do texto, a substitui\u00e7\u00e3o de \u201cPrecisa\u201d por \u00c9 preciso manteria inalterada a fun\u00e7\u00e3o sint\u00e1tica das ora\u00e7\u00f5es \u201cler Mediterr\u00e2neo de Fernand Braudel\u201d e \u201cevocar o mar Mediterr\u00e2neo\u201d.",
              "answer": "E"
            },
            {
              "id": 4,
              "item": "Segundo o autor do texto, o ensino da hist\u00f3ria da modernidade dirigido aos jovens fixou-se em um passado que se mant\u00e9m como refer\u00eancia dos tempos modernos apesar das concep\u00e7\u00f5es relacionadas ao que foi chamado no texto de \u201cespirro cartesiano\u201d.",
              "answer": "X"
            },
            {
              "id": 5,
              "item": "No primeiro per\u00edodo do texto, o trecho \u201cBem antes que (...) bem antes de tudo isso\u201d indica quando a modernidade come\u00e7ou, assim como o faz o trecho \u201cem outubro de 1492\u201d.",
              "answer": "E"
            },
            {
              "id": 6,
              "item": "Pela leitura do texto, \u00e9 poss\u00edvel relacionar a constru\u00e7\u00e3o da hist\u00f3ria da modernidade a uma perspectiva euroc\u00eantrica, apesar de o Mediterr\u00e2neo fazer parte do passado e do presente de outras culturas, al\u00e9m da europeia.",
              "answer": "C"
            },
            {
              "id": 7,
              "item": "No texto, a regi\u00e3o do Mediterr\u00e2neo representa o mundo fechado, como identific\u00e1vel, no \u00faltimo per\u00edodo do texto, no uso conotativo das express\u00f5es \u201c\u00fatero\u201d e \u201ccasa materna e paterna\u201d, embora essa vis\u00e3o seja minimizada pela ideia transmitida por \u201cnaveg\u00e1vel e navegado\u201d.",
              "answer": "E"
            }
          ]
        },
        {
          "text": "Ap\u00f3s as experi\u00eancias hist\u00f3ricas do s\u00e9culo passado, na psican\u00e1lise, no estruturalismo l\u00e9vi-straussiano, na semiologia e no p\u00f3s-estruturalismo, n\u00e3o h\u00e1 mais plausibilidade para se pensar em um humano t\u00edpico do s\u00e9culo XIX. Um ser volitivo e racional, plenamente consciente de suas necessidades materiais e que age movido por suas decis\u00f5es voluntariosas com a finalidade de atender a essas necessidades. Tudo muito coerente, por\u00e9m ficcional. A pessoa que pensamos desde o final do s\u00e9culo XX \u00e9 bem diversa. Muito mais amb\u00edgua e inconsistente em seu agir no mundo, um agir reativo ao seu meio em confronto com suas viv\u00eancias culturais. Atende a necessidades materiais e a \u201cnecessidades\u201d simb\u00f3licas, isto \u00e9, a desejos. Pensamos a pessoa como um animal simb\u00f3lico e desejante, uma estrutura movida por algo bem mais complexo do que aquela simples e plena consci\u00eancia racional. Movimenta-se por algo que vai al\u00e9m de suas necessidades biol\u00f3gicas. O desejo abarca a necessidade. Cada pessoa \u00e9 uma entidade eminentemente simb\u00f3lica, deseja por meio do simb\u00f3lico. Movimenta-se por seus desejos, fala seus desejos, deseja mediante a express\u00e3o simb\u00f3lica. Fala por significa\u00e7\u00f5es desejantes. Trata-se de um ente constitu\u00eddo na e pela linguagem, enla\u00e7ado socialmente pela linguagem. N\u00e3o uma linguagem como mera transmiss\u00e3o de ideias que j\u00e1 estariam na consci\u00eancia individual. N\u00e3o uma linguagem como um simples produto da mente racional e intencional que estaria meramente expressando e comunicando pensamentos que a antecedem, mas linguagem como produ\u00e7\u00e3o, como processo de produ\u00e7\u00e3o de ideias desejantes. Uma linguagem considerada como la\u00e7o societ\u00e1rio. Como aquilo que une um humano a outro, que os faz humanos e, assim, os torna pessoas simb\u00f3lico-desejantes. S\u00e3o sujeitos sujeitados \u00e0 linguagem. Cada pessoa fala seus desejos e se torna sujeito desses desejos que a sujeitam.",
          "reference": "Carlos Alvarez Maia. Hist\u00f3ria, ci\u00eancia e linguagem: o dilema do relativismo-realismo. Rio de Janeiro: Mauad Editora, 2015, p. 11.",
          "judge": "Em rela\u00e7\u00e3o \u00e0s ideias e a aspectos lingu\u00edsticos e textuais do texto precedente, julgue:",
          "items": [
            {
              "id": 8,
              "item": "No antepen\u00faltimo per\u00edodo do segundo par\u00e1grafo, \u201chumanos\u201d e \u201cpessoas simb\u00f3lico-desejantes\u201d exercem, nas ora\u00e7\u00f5es em que se inserem, a mesma fun\u00e7\u00e3o sint\u00e1tica.",
              "answer": "C"
            },
            {
              "id": 9,
              "item": "No segundo par\u00e1grafo, est\u00e1 el\u00edptico o sujeito das ora\u00e7\u00f5es \u201cFala por significa\u00e7\u00f5es desejantes\u201d e \u201cTrata-se de um ente constitu\u00eddo na e pela linguagem\u201d, sendo o sujeito de refer\u00eancia de ambas o termo \u201cCada pessoa\u201d, que introduz o par\u00e1grafo.",
              "answer": "E"
            },
            {
              "id": 10,
              "item": "Entende-se do texto que a imagem associada ao ser humano do s\u00e9culo XIX \u00e9 essencialmente diversa da imagem associada ao ser humano desde o final do s\u00e9culo XX, per\u00edodo em que ele deixa de preocupar-se com o mundo material ao seu redor.",
              "answer": "E"
            },
            {
              "id": 11,
              "item": "Em suas ocorr\u00eancias no sexto per\u00edodo do segundo par\u00e1grafo, o voc\u00e1bulo \u201cque\u201d classifica-se como pronome relativo e funciona, assim como o voc\u00e1bulo \u201ca\u201d, em \u201ca antecedem\u201d, como elemento de coes\u00e3o referencial.",
              "answer": "C"
            },
            {
              "id": 12,
              "item": "No texto, a linguagem \u00e9 tratada como elemento com fun\u00e7\u00e3o mais abrangente que a de mera transmiss\u00e3o de ideias ou de express\u00e3o e comunica\u00e7\u00e3o de pensamentos, pois est\u00e1 envolvida na pr\u00f3pria constru\u00e7\u00e3o de desejos e pensamentos.",
              "answer": "C"
            },
            {
              "id": 13,
              "item": "No \u00faltimo per\u00edodo do texto, o autor enfatiza a capacidade que tem o ser humano de expressar o objeto de seu desejo e destaca como esse seu desejo o aprisiona.",
              "answer": "X"
            },
            {
              "id": 14,
              "item": "No quinto e sexto per\u00edodos do segundo par\u00e1grafo, a repeti\u00e7\u00e3o do trecho \u201cN\u00e3o uma linguagem como\u201d \u00e9 recurso usado para refor\u00e7ar que a linguagem de um ente \u201cenla\u00e7ado socialmente pela linguagem\u201d (quarto per\u00edodo do segundo par\u00e1grafo) \u00e9 diferente da linguagem do homem \u201cque age movido por suas decis\u00f5es voluntariosas com a finalidade de atender a essas necessidades\u201d, mencionado no segundo per\u00edodo do primeiro par\u00e1grafo.",
              "answer": "C"
            }
          ]
        }
      ]
    },
    {
      "discipline": "HIST\u00d3RIA DO BRASIL",
      "questions": [
        {
          "text": "A independ\u00eancia do Brasil, formalizada em 1822, est\u00e1 vinculada aos acontecimentos europeus e brasileiros que comp\u00f5em a \u201cEra das Revolu\u00e7\u00f5es\u201d, entre fins do s\u00e9culo XVIII e princ\u00edpios do s\u00e9culo XIX. Da extin\u00e7\u00e3o do monop\u00f3lio comercial metropolitano ao intento recolonizador portugu\u00eas, a partir da Revolu\u00e7\u00e3o do Porto de 1820, os fatos se sucederam de modo a preparar o rompimento dos la\u00e7os de subordina\u00e7\u00e3o do Brasil a Portugal.",
          "reference": "",
          "judge": "Tendo as informa\u00e7\u00f5es precedentes como refer\u00eancia inicial e considerando os processos hist\u00f3ricos de coloniza\u00e7\u00e3o, da Independ\u00eancia e das d\u00e9cadas iniciais do regime imperial brasileiro, julgue:",
          "items": [
            {
              "id": 41,
              "item": "Entre os movimentos libert\u00e1rios ou emancipacionistas ocorridos no Brasil, entre os \u00faltimos anos do s\u00e9culo XVIII e a primeira metade do s\u00e9culo XIX, destacam-se a Inconfid\u00eancia Mineira (1789), a Baiana (1798) e a Revolu\u00e7\u00e3o Pernambucana de 1817, que compartilhavam incontest\u00e1vel identidade de objetivos, interesses e m\u00e9todos de a\u00e7\u00e3o.",
              "answer": "E"
            },
            {
              "id": 42,
              "item": "A transfer\u00eancia da sede do Estado portugu\u00eas para o Brasil, em in\u00edcios do s\u00e9culo XIX, est\u00e1 diretamente vinculada \u00e0s circunst\u00e2ncias hist\u00f3ricas vividas pela Europa a partir da Revolu\u00e7\u00e3o Francesa de 1789, mais especificamente em face do expansionismo napole\u00f4nico.",
              "answer": "C"
            },
            {
              "id": 43,
              "item": "A decis\u00e3o de elevar o Brasil \u00e0 condi\u00e7\u00e3o de Reino Unido a Portugal foi considerada estrat\u00e9gia ousada por se opor aos interesses comerciais ingleses e por n\u00e3o se subordinar a imposi\u00e7\u00f5es emanadas do Congresso de Viena, s\u00edmbolo do conservadorismo restaurador p\u00f3s-Napole\u00e3o.",
              "answer": "E"
            },
            {
              "id": 44,
              "item": "A abertura do Brasil ao com\u00e9rcio internacional, em 1808, representou o fim do monop\u00f3lio comercial da Metr\u00f3pole, esteio de uma coloniza\u00e7\u00e3o marcada pelos princ\u00edpios mercantilistas que se assentavam no denominado \u201cexclusivo de com\u00e9rcio\u201d.",
              "answer": "C"
            },
            {
              "id": 45,
              "item": "O Primeiro Reinado (1822-1831) foi marcado por desaven\u00e7as pol\u00edticas entre D. Pedro I e setores da sociedade brasileira, o que se confirmou pela dissolu\u00e7\u00e3o da Assembleia Constituinte e outorga da Constitui\u00e7\u00e3o de 1824, fatos que alimentaram a crescente oposi\u00e7\u00e3o \u00e0s atitudes do imperador, consideradas absolutistas.",
              "answer": "C"
            }
          ]
        }
      ]
    }
  ]
}

vamos projetar o banco? 