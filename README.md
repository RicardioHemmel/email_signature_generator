**⚙️ Configuração (config.php)
Contém todos os parâmetros ajustáveis:

image
template_image: caminho da imagem base

output_width, output_height: dimensões finais da imagem gerada

fonts
Caminhos para as fontes .TTF e .OTF utilizadas no texto.

font_sizes
Define o tamanho de cada tipo de texto (nome, textos gerais e “Subprefeitura”).

positions
Define posições, espaçamentos e margens de cada bloco textual na imagem.

text_color
Cor do texto em RGB.

addresses
Endereços disponíveis para seleção no formulário.

subprefeitura_text
Texto institucional que é inserido no rodapé da assinatura.

text_angle
Ângulo de inclinação dos textos (em graus).

🧠 Dependências
Para o correto funcionamento, é necessário que o servidor PHP tenha as seguintes extensões ativas:

GD – para manipulação de imagens

FreeType – para desenhar texto com fontes TTF/OTF

mbstring – para manipulação correta de caracteres com acento

(Se tiver usando o XAMPP precisa descomentar a linha do php.ini: "extension=gd")

💡 Funcionamento (generate_image.php)
Carrega o config.php com as definições da assinatura.

Recebe os dados do formulário via POST:

nome

cargo

setor

ramal

e-mail (prefixo, o sufixo é fixo)

endereço (chave: sede, cpo, almoxarifado)

Constrói a imagem com base nos dados:

Usa imagettftext() para desenhar os textos.

Utiliza uma função textWrap() para quebrar linhas automaticamente com base no espaço disponível.

Redimensiona a imagem final para a resolução final definida.(Peguei uma base de proporção com a função de redimensionar de forma proporcional do windows)

Exporta a imagem em PNG com o nome formatado (NOME_YYYYMMDD_HHMMSS.png).

Envia para download ou exibição inline, conforme o cabeçalho HTTP.
**
