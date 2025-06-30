document.addEventListener('DOMContentLoaded', function () {
    // Inputs do formulário
    const elements = {
        inputs: {
            name: document.getElementById('name'),
            role: document.getElementById('role'),
            department: document.getElementById('department'),
            email: document.getElementById('email'),
            extension: document.getElementById('extension'),
            address: document.getElementById('address'),
            prefix: document.getElementById('prefix'),
            whatsapp: document.getElementById('whatsapp')
        },
        // Divs de pré-visualização do formulário
        previews: {
            name: document.getElementById('previewName'),
            roleDept: document.getElementById('previewRoleDept'),
            email: document.getElementById('previewEmail'),
            phone: document.getElementById('previewPhone'),
            address: document.getElementById('previewAddress'),
            complement: document.getElementById('previewComplement'),
            subEmail: document.getElementById('previewSubEmail'),
            instructions: document.getElementById('previewInstructions')
        },
        // Input escondido para enviar o complemento do endereço separado
        hidden: {
            addressComplement: document.getElementById('address_complement')
        }
    };

    // Informações para popular os dropdowns
    const constants = {
        addresses: {
            sede: { address: 'Rua Cassiano dos Santos, 499', complement: '04827-110 | São Paulo | SP' },
            cpo: { address: 'Rua Cassiano dos Santos, 43', complement: '04827-110 | São Paulo | SP' },
            almoxarifado: { address: 'Rua Jaburuna, 82', complement: '04803-040 | São Paulo | SP' }
        },
        prefixes: ['3397', '5660', '5666', '5667', '5668', '5669'],
        // Domínio para exibição
        emailDomain: '@smsub.prefeitura.sp.gov.br'
    };

    // Configurações de visualização dos textos
    const previewConfig = {
        baseTop: 80, // Começa o texto
        defaultSpacing: 8, // Espaçamento da linha
        afterRoleDeptSpacing: 22 // Margem para separar o cargo e setor
    };

    // Inicialização
    function init() {
        setupPrefixDropdown();
        setupEventListeners();
        updatePreview();
    }

    // Configura o dropdown de prefixos
    function setupPrefixDropdown() {
        const select = elements.inputs.prefix;
        select.innerHTML = '<option value="">Selecione um Prefixo</option>';

        constants.prefixes.forEach(prefix => {
            select.add(new Option(prefix, prefix));
        });
    }


    // Configura os event listeners
    function setupEventListeners() {
        // Validação especial para email
        elements.inputs.email?.addEventListener('input', function () {
            if (this.value.includes('@')) {
                alert('Você não precisa digitar o "@smsub.prefeitura.sp.gov.br". Apenas insira o início do e-mail');
                this.value = this.value.split('@')[0];
            }
            updatePreview();
        });

        // Adiciona listeners para todos os campos relevantes
        Object.keys(elements.inputs).forEach(key => {
            if (elements.inputs[key]) {
                elements.inputs[key].addEventListener('input', updatePreview);
            }
        });

        // Listener especial para o select de endereço
        if (elements.inputs.address) {
            elements.inputs.address.addEventListener('change', updatePreview);
        }
    }

    // Atualiza toda a pré-visualização
    function updatePreview() {
        updateTextPreview();
        updateLayout();
        updateInstructionsVisibility();
    }

    // Atualiza os textos da pré-visualização
    function updateTextPreview() {
        const { inputs, previews, hidden } = elements;
        const { addresses, emailDomain } = constants;

        // Formata os textos básicos
        previews.name.textContent = formatText(inputs.name.value, { uppercase: true }) || 'Seu Nome Completo';

        const role = formatText(inputs.role.value, { uppercase: true });
        const dept = formatText(inputs.department.value, { uppercase: true });
        previews.roleDept.textContent = role && dept ? `${role} / ${dept}` : role || dept || 'Seu Cargo / Setor';

        // Email
        const emailPrefix = inputs.email.value.trim();
        previews.email.textContent = emailPrefix ?
            `${emailPrefix.toLowerCase()}${emailDomain}` :
            `seu_email${emailDomain}`;

        // Telefone e WhatsApp
        updateContactPreview();

        // Endereço
        const addressKey = inputs.address.value || 'sede';
        const address = addresses[addressKey] || addresses.sede;
        previews.address.textContent = address.address;
        previews.complement.textContent = address.complement;
        hidden.addressComplement.value = address.complement;

        // Subprefeitura
        previews.subEmail.textContent = 'prefeitura.sp.gov.br/capela_do_socorro';
    }

    // Lógica combinada para telefone e WhatsApp
    function updateContactPreview() {
        const { inputs, previews } = elements;
        const prefix = inputs.prefix.value;
        const extension = inputs.extension.value.trim();
        const whatsapp = inputs.whatsapp.value.trim();

        let contactInfo = '';

        // Formata o telefone se existir
        const phoneInfo = prefix && extension ?
            `${prefix}-${extension}` :
            (prefix ? `${prefix}-____` :
                (extension ? `____-${extension}` : ''));

        // Formata o WhatsApp se existir
        const whatsappInfo = whatsapp ?
            whatsapp.replace(/(\d{5})(\d{4})/, '$1-$2') : '';

        // Combina as informações conforme as novas regras
        if (phoneInfo && whatsappInfo) {
            contactInfo = `Tel: +55 (11) ${phoneInfo} / Cel: ${whatsappInfo}`;
        } else if (phoneInfo) {
            contactInfo = `Tel: +55 (11) ${phoneInfo}`;
        } else if (whatsappInfo) {
            contactInfo = `Cel: +55 (11) ${whatsappInfo}`;
        }

        // Atualiza o preview
        if (contactInfo) {
            previews.phone.textContent = contactInfo;
            previews.phone.style.display = 'block';
        } else {
            previews.phone.style.display = 'none';
        }
    }

    // Atualiza o posicionamento dos elementos
    function updateLayout() {
        const { previews } = elements;
        const { baseTop, defaultSpacing, afterRoleDeptSpacing } = previewConfig;

        let currentTop = baseTop;
        const fieldsOrder = [
            previews.name,
            previews.roleDept,
            previews.email,
            previews.phone,
            previews.address,
            previews.complement,
            previews.subEmail
        ];

        fieldsOrder.forEach((field, index) => {
            if (!field) return;

            const isVisible = field.style.display !== 'none';
            if (isVisible) {
                field.style.top = currentTop + 'px';
                const spacing = index === 1 ? afterRoleDeptSpacing : defaultSpacing;
                currentTop += field.offsetHeight + spacing;
            }
        });
    }

    // Atualiza a visibilidade das instruções
    function updateInstructionsVisibility() {
        const hasContent = Object.values(elements.inputs).some(
            input => input && input.value.trim() !== ''
        );
        elements.previews.instructions.style.display = hasContent ? 'none' : 'block';
    }

    // Helper para formatação de texto
    function formatText(text, options = {}) {
        if (!text) return '';
        if (options.uppercase) return text.toUpperCase();
        if (options.lowercase) return text.toLowerCase();
        return text;
    }

    // Inicia a aplicação
    init();
});

// Validação global para campos numéricos
function validarNumero(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}

// Validação do formulário (para adicionar no onsubmit do form)
function validarFormulario() {
    const prefix = document.getElementById('prefix').value;
    const extension = document.getElementById('extension').value.trim();

    // Validação do telefone (ambos campos obrigatórios se algum estiver preenchido)
    if ((prefix && !extension) || (!prefix && extension)) {
        alert('Por favor, preencha tanto o prefixo quanto a extensão do ramal');
        return false;
    }

    return true;
}