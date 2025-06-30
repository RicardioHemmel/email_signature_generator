<?php
//Traz os parâmetros configuráveis da aplicação
$config = require 'config.php';

//Carrega a imagem de fundo (modelo da assinatura)
$image = imagecreatefrompng($config['image']['template_image']);

//Define a cor preta para o texto (R, G, B)
$textColorblack = imagecolorallocate($image, $config['text_color']['red'], $config['text_color']['green'], $config['text_color']['blue']);

// Define qual o endereço usar baseado na chave vinda do HTML
$addressKey = $_POST['address'] ?? 'sede';
$addressData = $config['addresses'][$addressKey] ?? $config['addresses']['sede'];

$address = $addressData['address'];
$complement = $addressData['complement'];

// Prepara os dados de contato (ramal e whatsapp)
$phoneInfo = '';
$whatsappInfo = $_POST['whatsapp'] ?? '';

// Formata o ramal se existir
if (!empty($_POST['prefix']) && !empty($_POST['extension'])) {
    $phoneInfo = $_POST['prefix'] . '-' . $_POST['extension'];
} elseif (!empty($_POST['prefix'])) {
    $phoneInfo = $_POST['prefix'] . '-____';
} elseif (!empty($_POST['extension'])) {
    $phoneInfo = '____-' . $_POST['extension'];
}

// Formata o WhatsApp se existir
if (!empty($whatsappInfo)) {
    $whatsappInfo = preg_replace('/(\d{5})(\d{4})/', '$1-$2', $whatsappInfo);
}

// Combina as informações de contato conforme as regras
$contactInfo = '';
if ($phoneInfo && $whatsappInfo) {
    $contactInfo = 'Tel: +55 (11) ' . $phoneInfo . ' / Cel: ' . $whatsappInfo;
} elseif ($phoneInfo) {
    $contactInfo = 'Tel: +55 (11) ' . $phoneInfo;
} elseif ($whatsappInfo) {
    $contactInfo = 'Cel: +55 (11) ' . $whatsappInfo;
}

//Define os dados a serem exibidos
$data = [
    'name'     => mb_strtoupper($_POST['name']),
    'role'    => mb_strtoupper($_POST['role']),
    'department'  => mb_strtoupper($_POST['department']),
    'email'    => mb_strtolower($_POST['email'] . '@smsub.prefeitura.sp.gov.br'),
    'contact' => $contactInfo,
    'address' => $address,
    'address_complement' => $complement,
    'subprefecture_email' => 'prefeitura.sp.gov.br/capela_do_socorro',
];

// Remove campos vazios
$data = array_filter($data);

// Combina cargo e unidade se ambos existirem
if (isset($data['role'], $data['department'])) {
    $roleDepartment = $data['role'] . ' / ' . $data['department'];
    unset($data['role'], $data['department']);
}

// Remove o campo de contato se estiver vazio
if (empty($data['contact'])) {
    unset($data['contact']);
}

// Define a ordem dos campos (com cargo_unidade após o nome)
$inputsOrder = ['name'];
if (isset($roleDepartment)) {
    $inputsOrder[] = 'role_department';
}

//Copia as chaves de $data e concatena na lista do $inputsOrder com a diferença da chave 'name'
$inputsOrder = array_merge($inputsOrder, array_diff(array_keys($data), ['name']));

// Adiciona o campo combinado ao array de dados
if (isset($roleDepartment)) {
    $data['role_department'] = $roleDepartment;
}

// Função auxiliar para quebrar uma string em várias linhas
function textWrap($text, $fontSize, $angle, $arialFont, $maxWidth)
{
    $words = explode(' ', $text);
    $rows = [];
    $currentRow = '';

    foreach ($words as $word) {
        $rowTest = $currentRow ? $currentRow . ' ' . $word : $word;
        $textBox = imagettfbbox($fontSize, $angle, $arialFont, $rowTest);
        $width = $textBox[2] - $textBox[0];

        if ($width > $maxWidth) {
            $rows[] = $currentRow;
            $currentRow = $word;
        } else {
            $currentRow = $rowTest;
        }
    }

    if ($currentRow) $rows[] = $currentRow;

    return $rows;
}

// Percorre os campos na ordem definida e desenha cada um como texto na imagem
$rowY = $config['positions']['text_start_y'];
$afterRoleDepartment = false; //Depois que passar por role_department muda o $spacing

foreach ($inputsOrder as $input) {
    //Estilizações condicionais
    $value = $data[$input];
    $currentFont = ($input === 'name') ? $config['fonts']['arial_bold'] : $config['fonts']['arial'];
    $currentFontSize = ($input === 'name') ? $config['font_sizes']['nameSize'] : $config['font_sizes']['normalSize'];
    $currentSpacing = $afterRoleDepartment ? $config['positions']['line_spacing_after_role_department'] : $config['positions']['line_spacing_default'];

    //Quebra o texto em linhas
    $rows = textWrap($value, $currentFontSize, $config['text_angle'], $currentFont, $config['positions']['text_max_width']);

    //Exibe as linhas com o espaçamento certo
    foreach ($rows as $row) {
        if ($input === 'role_department') {
            $rowY -= $config['positions']['line_spacing_for_role_department'];
            $currentSpacing = $config['positions']['role_department_bottom_margin'];
            $afterRoleDepartment = true;
        }
        imagettftext($image, $currentFontSize, $config['text_angle'], $config['positions']['text_start_x'], $rowY, $textColorblack, $currentFont, $row);
        $rowY += $currentSpacing;
    }
}

// Insere o texto Subprefeitura
imagettftext($image, $config['font_sizes']['subprefeitura'], $config['text_angle'], $config['positions']['subprefeitura_x'], $config['positions']['subprefeitura_y'], $textColorblack, $config['fonts']['futura_bold'], $config['subprefeitura_text']);

//Redimensiona para imagem final
$imageFinal = imagecreatetruecolor($config['image']['output_width'], $config['image']['output_height']);
imagealphablending($imageFinal, false);
imagesavealpha($imageFinal, true);

imagecopyresampled(
    $imageFinal,
    $image,
    0,
    0,
    0,
    0,
    $config['image']['output_width'],
    $config['image']['output_height'],
    imagesx($image),
    imagesy($image)
);

//Formata o nome do arquivo antes de gerar a imagem para salvar
function sanitizeFilename($string)
{
    // Transforma acentuados em equivalentes sem acento
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

    // Substitui espaços por underline
    $string = str_replace(' ', '_', $string);

    // Remove tudo que não é letra, número, traço ou underline
    $string = preg_replace('/[^A-Za-z0-9_\-]/', '', $string);

    // Opcional: tudo minúsculo
    $string = strtoupper($string);

    return $string;
}

// Disponibiliza para download em PNG
header('Content-Type: image/png');

$timestamp = date('Ymd_His'); // Ex: 20250618_142530
$filename = sanitizeFilename($data['name']) . '_' . $timestamp . '.png';

//Baixa a imagem
header('Content-Disposition: attachment; filename="' . $filename . '"'); 

// Exibe a imagem em vez de baixa-la
//header('Content-Disposition: inline; filename="' . $filename . '"');


imagepng($imageFinal, null, 9); // Qualidade máxima PNG

// Libera a memória
imagedestroy($image);