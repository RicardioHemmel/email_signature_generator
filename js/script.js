// Aguarda o carregamento completo da página
document.addEventListener('DOMContentLoaded', function () {

    // Lista de inputs
    const formInputs = {
        name: document.getElementById('name'),
        role: document.getElementById('role'),
        department: document.getElementById('department'),
        email: document.getElementById('email'),
        extension: document.getElementById('extension')
    };

    // Dropdown de endereços
    const addressSelect = document.getElementById('address');
    // Texto de complemento para o endereço
    const addressComplementHidden = document.getElementById('address_complement');

    // Array de Objetos com todas as opções de endereços
    const addressMap = {
        sede: {
            address: 'Rua Cassiano dos Santos, 499',
            complement: '04827-110 | São Paulo | SP'
        },
        cpo: {
            address: 'Rua Cassiano dos Santos, 43',
            complement: '04827-110 | São Paulo | SP'
        },
        almoxarifado: {
            address: 'Rua Jaburuna, 82',
            complement: '04803-040 | São Paulo | SP'
        }
    };

    // Lista de campos de Pré-visualização
    const previewFields = {
        name: document.getElementById('previewName'),
        roleDept: document.getElementById('previewRoleDept'),
        email: document.getElementById('previewEmail'),
        extension: document.getElementById('previewExtension'),
        address: document.getElementById('previewAddress'),
        complement: document.getElementById('previewComplement'),
        subprefeitura: document.getElementById('previewSubEmail'),
        instructions: document.getElementById('previewInstructions')
    };


    // Configurações básicas da pré-visualização dos textos
    const baseTop = 70;
    const defaultSpacing = 6;
    const afterRoleDeptSpacing = 22;

    //Função para formatar texto em caixa alta ou baixa
    function formatText(value, options = {}) {
        if (!value) return '';
        let result = value;
        if (options.uppercase) result = result.toUpperCase();
        if (options.lowercase) result = result.toLowerCase();
        return result;
    }

    // Atualiza os textos com base nos valores dos inputs
    function updatePreview() {

        // Trata os valores recebidos dos inputs
        const name = formatText(formInputs.name.value, { uppercase: true }) || 'Seu Nome Completo';
        const role = formatText(formInputs.role.value, { uppercase: true });
        const dept = formatText(formInputs.department.value, { uppercase: true });
        const roleDeptText = role && dept ? `${role} / ${dept}` : role || dept || 'Seu Cargo / Setor';
        const emailPrefix = formInputs.email.value.trim();
        const email = emailPrefix ? formatText(emailPrefix + '@smsub.prefeitura.sp.gov.br', { lowercase: true }) : 'seu_email@smsub.prefeitura.sp.gov.br';
        const extension = formInputs.extension.value.trim();

        // Endereço e complemento
        const selectedKey = document.getElementById('address').value;
        const fallback = addressMap['sede']; // endereço padrão
        const selected = addressMap[selectedKey] || fallback;

        // Campo oculto com endereço completo
        addressComplementHidden.value = selected.complement;

        // Insere os valores formatados na pré-visualização
        previewFields.name.textContent = name;
        previewFields.roleDept.textContent = roleDeptText;
        previewFields.email.textContent = email;
        previewFields.extension.textContent = extension ? `Tel: +55 (11) 3397-${extension}` : '';
        previewFields.address.textContent = selected.address;
        previewFields.complement.textContent = selected.complement;

        // Espaçamento dinâmico
        let currentTop = baseTop;
        const orderedFields = [
            { el: previewFields.name, spacing: defaultSpacing },
            { el: previewFields.roleDept, spacing: afterRoleDeptSpacing },
            { el: previewFields.email, spacing: defaultSpacing },
            { el: previewFields.extension, spacing: defaultSpacing },
            { el: previewFields.address, spacing: defaultSpacing },
            { el: previewFields.complement, spacing: defaultSpacing },
            { el: previewFields.subprefeitura, spacing: defaultSpacing }
        ];

        orderedFields.forEach(({ el, spacing }) => {
            el.style.top = currentTop + 'px';
            const height = el.offsetHeight;
            currentTop += height + spacing;
        });

        const algumPreenchido = Object.values(formInputs).some(input => input.value.trim() !== '');
        previewFields.instructions.style.display = algumPreenchido ? 'none' : 'block';
    }

    // Eventos dos inputs
    Object.values(formInputs).forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('focus', () => {
            input.previousElementSibling.style.color = 'var(--primary)';
        });
        input.addEventListener('blur', () => {
            input.previousElementSibling.style.color = 'var(--dark)';
        });
    });

    // Prevenção do uso de @ no campo email
    formInputs.email.addEventListener('input', function () {
        if (this.value.includes('@')) {
            alert('Você não precisa digitar o "@smsub.prefeitura.sp.gov.br". Apenas insira o início do e-mail.');
            this.value = this.value.replace(/@.*/, '');
        }
        updatePreview();
    });

    // Atualiza o preview ao trocar de endereço
    addressSelect.addEventListener('change', updatePreview);

    updatePreview();
});
