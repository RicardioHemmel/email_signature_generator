# ✨ Gerador de Assinaturas - Subprefeitura Capela do Socorro

Sistema desenvolvido para padronizar e facilitar a criação de assinaturas institucionais da Subprefeitura da Capela do Socorro. Com uma interface simples e intuitiva, permite que qualquer colaborador gere sua própria assinatura padronizada em segundos.

---

## ⚙️ Configuração (`config.php`)

Todas as definições personalizáveis estão centralizadas nesse arquivo:

### 🖼️ `image`
- `template_image`: Caminho da imagem base.
- `output_width`, `output_height`: Dimensões da imagem final gerada.

### 🅰️ `fonts`
- Caminhos absolutos para as fontes `.TTF` e `.OTF` utilizadas.

### 🔠 `font_sizes`
- Define tamanhos específicos para:
  - Nome
  - Textos gerais
  - Texto "Subprefeitura"

### 📐 `positions`
- Controla posições, espaçamentos e margens de todos os blocos de texto sobre a imagem.

### 🎨 `text_color`
- Define a cor do texto (em RGB).

### 📍 `addresses`
- Lista de endereços disponíveis para seleção no formulário:
  - `sede`
  - `cpo`
  - `almoxarifado`

### 🏛️ `subprefeitura_text`
- Texto institucional fixo que aparece ao final da imagem.

### 🔄 `text_angle`
- Ângulo de inclinação do texto (normalmente 0).

---

## 🧠 Dependências

Para o correto funcionamento do sistema, é necessário que o PHP esteja com as seguintes extensões ativas:

- `GD` → manipulação de imagens
- `mbstring` → suporte a caracteres com acento

  Comandos:
  sudo apt install php-gd php-mbstring
  sudo systemctl restart apache2

### ☑️ Ativando GD no `php.ini`

Se estiver usando XAMPP ou ambiente local:

```ini
; Descomente esta linha:
extension=gd
