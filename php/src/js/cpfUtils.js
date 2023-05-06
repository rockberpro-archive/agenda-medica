/** 
 * global_vars
 */
var mascaraCPF = [];
var cpf_input = document.getElementById("cpf");
/** */

/**
 * Faz verificação do CPF onInput
 */
function verificarCPF(strCPF) {
    if (strCPF.length == 14) {
        let cpfLimpo = limparMascara(strCPF);

        if (!validarCPF(cpfLimpo)) {
            limparCampoCPF();
        } else {
            cpf_input.readOnly = 'true';
        }
    }
}

function limparCampoCPF() {
    cpf_input.value = '';
    if (cpf_input.readOnly == true) {
        cpf_input.removeAttribute('readOnly');
        cpf_input.value = '';
    }
}

function geraMascara(strCPF) {
    apenasNumeros(cpf_input);

    if (strCPF.length >= 3 && strCPF.length < 4) {
        mascaraCPF[0] = strCPF.substring(0, 3) + '.';
    } else if (strCPF.length == 6) {
        mascaraCPF[1] = strCPF.substring(3, 6) + '.';
    } else if (strCPF.length == 9) {
        mascaraCPF[2] = strCPF.substring(6, 9) + '-';
    } else if (strCPF.length > 9 && strCPF.length <= 11) {
        mascaraCPF[3] = strCPF.substring(9, 11);
    }

    if (mascaraCPF.length == 4 && strCPF.length == 11 && validarCPF(limparMascara(mascaraCPF.join("").toString()))) {
        cpf_input.value = mascaraCPF.join("").toString();
        cpf_input.readOnly = 'true';
    } else if (strCPF.length == 11 && !validarCPF(limparMascara(mascaraCPF.join("").toString()))) {
        cpf_input.value = '';
    }

}

function apenasNumeros(input_element) {
    input_element.value = input_element.value.replace(/[^\d]/, '')
}

function limparMascara(strCPF) {
    let terceto1 = strCPF.substring(0, 3);
    let terceto2 = strCPF.substring(4, 7);
    let terceto3 = strCPF.substring(8, 11);
    let digitos = strCPF.substring(12, 14);

    return terceto1 + terceto2 + terceto3 + digitos;
}

function validarCPF(strCPF) {
    var soma;
    var resto;
    soma = 0;

    /* verifica a ocorrência de números repetidos */
    let testes = 0;
    for (let i = 1; i <= 11; i++) {
        let acumulador = '';

        for (let j = 1; j <= 11; j++) {
            acumulador += i;
            if (j == 11 && strCPF == acumulador) {
                //console.log(acumulador);
                testes++;
            }
        }
    }
    if (testes > 0) return false;
    if (strCPF == "00000000000") return false;

    for (i = 1; i <= 9; i++) soma = soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    resto = (soma * 10) % 11;

    if ((resto == 10) || (resto == 11)) resto = 0;
    if (resto != parseInt(strCPF.substring(9, 10))) return false;

    soma = 0;
    for (i = 1; i <= 10; i++) soma = soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    resto = (soma * 10) % 11;

    if ((resto == 10) || (resto == 11)) resto = 0;
    if (resto != parseInt(strCPF.substring(10, 11))) return false;
    return true;
}