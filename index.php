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
            <form id="signatureForm" action="generate_image.php" method="post" target="_blank" onsubmit="return validarFormulario()">
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" id="name" name="name" placeholder="Seu nome completo" required maxlength="50">
                </div>

                <div class="form-group">
                    <label for="role">Cargo</label>
                    <input type="text" id="role" name="role" placeholder="Seu cargo" maxlength="36" required>
                </div>

                <div class="form-group">
                    <label for="department">Setor</label>
                    <input type="text" id="department" name="department" placeholder="Sua unidade" maxlength="36" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <div id="email-domain-container">
                        <input type="text" id="email" name="email" placeholder="Seu email" maxlength="100" required>
                        <div><b>@smsub.prefeitura.sp.gov.br</b></div>
                    </div>
                </div>

                <div class="form-group" id="prefix-extension-container">
                    <div>
                        <label for="prefix">Prefixo</label>
                        <select id="prefix" name="prefix"></select>
                    </div>

                    <div>
                        <label for="extension">Ramal</label>
                        <input type="text" id="extension" name="extension"
                            placeholder="Número do ramal"
                            pattern="\d{4}"
                            maxlength="4"
                            title="Digite exatamente 4 números"
                            oninput="validarNumero(this)">
                    </div>
                </div>

                <div class="form-group">
                    <label for="whatsapp">Celular (opcional)</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="Ex: 912345678"
                        maxlength="9" minlength="9" oninput="validarNumero(this)">
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
                <div id="previewSubprefeitura" class="preview-text">
                    SUBPREFEITURA<br>CAPELA DO SOCORRO
                </div>
                <div class="preview-overlay">
                    <div id="previewName" class="preview-text" style="font-size: 20px; font-weight: bold; left: 200px; top: 80px;">Seu Nome Completo</div>
                    <div id="previewRoleDept" class="preview-text" style="font-size: 14px; left: 200px; top: 110px;">Seu Cargo / Setor</div>
                    <div id="previewEmail" class="preview-text" style="font-size: 14px; left: 200px; top: 148px;">seu_email@smsub.prefeitura.sp.gov.br</div>
                    <div id="previewPhone" class="preview-text" style="font-size: 14px; left: 200px; top: 170px;"></div>
                    <div id="previewAddress" class="preview-text" style="font-size: 14px; left: 200px; top: 190px;">Rua Cassiano dos Santos, 499</div>
                    <div id="previewComplement" class="preview-text" style="font-size: 14px; left: 200px; top: 210px;">04827-110 | São Paulo | SP</div>
                    <div id="previewSubEmail" class="preview-text" style="font-size: 14px; left: 200px; top: 230px;">prefeitura.sp.gov.br/capela_do_socorro</div>
                </div>
            </div>
            <div id="previewInstructions" style="margin-top: 15px; font-size: 14px; color: #6c757d; text-align: center;">
                Preencha os campos ao lado para ver a prévia atualizada
            </div>
        </div>
    </div>

    <footer style="text-align: center; padding: 20px; margin-top: 30px; background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
        <p style="margin: 0; color: #6c757d; font-size: 14px;">
            Projeto desenvolvido por Ricardo Hemmel |
            <a href="https://github.com/RicardioHemmel/email_signature_generator" target="_blank" style="color: #0d6efd; text-decoration: none;">
                Código fonte disponível no GitHub
            </a>
        </p>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>