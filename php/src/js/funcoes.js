/**
 * Encontra em que página o usuário está posicionado
 */
function findCurrentPage() {
    return location.href.split('/').slice(-1)[0];
}

/*
 * Limpar qualquer valor presente no <input>
 */
function clearInputField() {
    switch (findCurrentPage()) {
        case 'medico.php':
            document.getElementById('input-busca-medico').value = '';
            break;
        case 'paciente.php':
            document.getElementById('input-busca-paciente').value = '';
            break;
        case 'consulta.php':
            document.getElementById('input-busca-consulta').value = '';
            break;
        default:
            break;
    }
    location.reload(); // atualiza tabela
}

/*
 * Retorna o elemento <input> correspondente á página acessada
 * 
 * usado em: findSelectedOptionHeaderOfTablePosition()
 */
function getInputFieldIdAccordingPage() {
    switch (findCurrentPage()) {
        case 'medico.php':
            return document.getElementById("input-busca-medico");
            break;
        case 'paciente.php':
            return document.getElementById("input-busca-paciente");
            break;
        case 'consulta.php':
            return document.getElementById("input-busca-consulta");
            break;
        default:
            break;
    }
}

/*
 * Retorna o elemento <table> correspondente á página acessada
 * 
 * usado em: findSelectedOptionHeaderOfTablePosition()
 */
function getTableIdAccordingPage() {
    switch (findCurrentPage()) {
        case 'medico.php':
            return document.getElementById("tabela-medico");
            break;
        case 'paciente.php':
            return document.getElementById("tabela-paciente");
            break;
        case 'consulta.php':
            return document.getElementById("tabela-consulta");
            break;
        default:
            break;
    }
}

function getSelectOptionListAccordingPage() {
    switch (findCurrentPage()) {
        case 'medico.php':
            return document.getElementById("medico-option-filter");
            break;
        case 'paciente.php':
            return document.getElementById("paciente-option-filter");
            break;
        case 'consulta.php':
            return document.getElementById("consulta-option-filter");
            break;
        default:
            break;
    }
}

/**
 * Relaciona o valor do <input id="medico-option-filter"> com a coluna a ser buscada na tabela
 */
function findSelectedOptionHeaderOfTablePosition() {
    let options = getSelectOptionListAccordingPage();
    let selectedIndexText = options.options[options.selectedIndex].text;
    let input, filter, table, tr_header, tds_header;

    input = getInputFieldIdAccordingPage();
    table = getTableIdAccordingPage();
    tr_header = table.getElementsByTagName("tr")[0];
    tds_header = tr_header.getElementsByTagName("td");

    for (let td_position = 0; td_position < tds_header.length; td_position++) {
        if (tds_header[td_position].innerText.indexOf(selectedIndexText) > -1) {
            return td_position;
        }
    }

}

/*
 * Compõe tabela com base no parâmetro do <input id="medico-option-filter">
 */
function onSearchTable() {
    let input, filter, table, tr, td, i, txtValue;
    input = getInputFieldIdAccordingPage();
    filter = input.value.toUpperCase();
    table = getTableIdAccordingPage();
    tr = table.getElementsByTagName("tr");

    /* esconder linhas que não satisfazem o filtro */
    for (row_position = 1; row_position < tr.length; row_position++) { // row[0] é o header, por isso começa em 1
        td = tr[row_position].getElementsByTagName("td")[findSelectedOptionHeaderOfTablePosition()]; // td[1] é onde está o nome dos médicos
        if (td) {
            txtValue = td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[row_position].style.display = ""; // limpa display para permitir visualização
            } else {
                tr[row_position].style.display = "none"; // desliga display
            }
        }
    }

}