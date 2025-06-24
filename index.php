<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Assinatura</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="public/signatureIcon.png" type="image/png">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Gerador de Assinatura</h2>
            <form id="signatureForm" action="generate_image.php" method="post" target="_blank">
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" id="name" name="name" placeholder="Seu nome completo" required maxlength="50">
                </div>

                <div class="form-group">
                    <label for="role">Cargo</label>
                    <input type="text" id="role" name="role" placeholder="Seu cargo" maxlength="36">
                </div>

                <div class="form-group">
                    <label for="department">Setor</label>
                    <input type="text" id="department" name="department" placeholder="Sua unidade" maxlength="36">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0px 8px;">
                        <input type="text" id="email" name="email" placeholder="Seu email" maxlength="100">
                        <div><b>@smsub.prefeitura.sp.gov.br</b></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="extension">Ramal</label>
                    <input type="text" id="extension" name="extension" placeholder="Número do ramal">
                </div>

                <div class="form-group">
                    <label for="address">Endereço</label>
                    <select id="address" name="address">
                        <option value="">Selecione um endereço</option>
                        <option value="sede">Prédio Sede - Rua Cassiano dos Santos, 499</option>
                        <option value="cpo">CPO - Rua Cassiano dos Santos, 43</option>
                        <option value="almoxarifado">Almoxarifado - Rua Jaburuna, 82</option>
                    </select>
                </div>

                <input type="hidden" name="address_complement" id="address_complement">

                <button type="submit" id="downloadBtn">
                    Gerar Assinatura
                </button>
            </form>
        </div>

        <div class="preview-container">
            <h2>Prévia da Assinatura</h2>
            <div class="preview">
                <img id="previewImage" src="public/signature_template.png" alt="Template de Assinatura">
                <div class="preview-overlay">
                    <div id="previewName" class="preview-text" style="font-size: 20px; font-weight: bold; left: 200px; top: 80px;">Seu Nome Completo</div>
                    <div id="previewRoleDept" class="preview-text" style="font-size: 14px; left: 200px; top: 110px;">Seu Cargo / Setor</div>
                    <div id="previewEmail" class="preview-text" style="font-size: 14px; left: 200px; top: 148px;">seu_email@smsub.prefeitura.sp.gov.br</div>
                    <div id="previewExtension" class="preview-text" style="font-size: 14px; left: 200px; top: 170px;">Tel: +55 (11) 3397-</div>
                    <div id="previewAddress" class="preview-text" style="font-size: 14px; left: 200px; top: 190px;">Rua Cassiano dos Santos, 499</div>
                    <div id="previewComplement" class="preview-text" style="font-size: 14px; left: 200px; top: 210px;"> 04827-110 | São Paulo | SP</div>
                    <div id="previewSubEmail" class="preview-text" style="font-size: 14px; left: 200px; top: 230px;">capeladosocorro.prefeitura.sp.gov.br</div>
                </div>
            </div>
            <div id="previewInstructions" style="margin-top: 15px; font-size: 14px; color: #6c757d; text-align: center;">
                Preencha os campos ao lado para ver a prévia atualizada
            </div>
        </div>

    </div>

    <script src="js/script.js"></script>
</body>

</html>