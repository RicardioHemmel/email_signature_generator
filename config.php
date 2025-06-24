<?php

return [
    // === Imagem gerada redimensionada 800 x 290 ===
    'image' => [
        'template_image' => 'public/signature_template.png',
        'output_width'   => 422, //Tamanho horizonal de saída da imagem base
        'output_height'  => 168, //Tamanho vertical de saída da imagem base
    ],
    // === Fontes ===
    'fonts' => [
        'arial'       => __DIR__ . '/fonts/ARIAL.TTF',
        'arial_bold'  => __DIR__ . '/fonts/ARIALBD.TTF',
        'futura_bold' => __DIR__ . '/fonts/FUTURAMDBT_BOLD.OTF',
    ],

    // === Tamanhos de fonte ===
    'font_sizes' => [
        'normalSize' => 24, //Tamanho do texto em geral
        'nameSize'   => 44, //Tamanho do texto para o Name
        'subprefeitura' => 20, //Tamanho do texto para Subprefeitura
    ],

    // === Posição e espaçamentos (Medida em Pixels) ===
    'positions' => [
        'text_start_x' => 530, //Começa os textos horizontalmente
        'text_start_y' => 125, //Começa os textos verticalmente
        'text_max_width' => 900, //Até onde o texto percorre a imagem até quebrar para a próxima linha
        'line_spacing_default' => 64, //Espaçamento de linha padrão
        'line_spacing_for_role_department' => 18, //Espaçamento de linha entre o Name e o Role_Department
        'role_department_bottom_margin' => 86, //Margem entre o Role_Department e os demais campos
        'line_spacing_after_role_department' => 48, //Espaçamento das linhas dos demais campos após Role_Department
        'subprefeitura_x' => 90, //Posição horizontal do texto Subprefeitura
        'subprefeitura_y' => 400, //Posição vertical do texto Subprefeitura
    ],

    // === Cor do texto ===
    'text_color' => [
        'red' => 0,
        'green' => 0,
        'blue' => 0,
    ],

    // === Endereços ===
    'addresses' => [
        'sede' => [
            'address' => 'Rua Cassiano dos Santos, 499',
            'complement' => '04827-110 | São Paulo | SP'
        ],
        'cpo' => [
            'address' => 'Rua Cassiano dos Santos, 43',
            'complement' => '04827-110 | São Paulo | SP'
        ],
        'almoxarifado' => [
            'address' => 'Rua Jaburuna, 82',
            'complement' => '04803-040 | São Paulo | SP'
        ],
    ],

    // === Texto fixo ===
    'subprefeitura_text' => "     SUBPREFEITURA\nCAPELA DO SOCORRO",

    // === Outros ===
    'text_angle' => 0,
];
