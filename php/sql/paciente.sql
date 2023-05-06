SELECT *
FROM paciente paciente
    LEFT JOIN paciente paciente ON pessoa.id = paciente.ref_pessoa;

SELECT *
FROM pessoa pessoa
    RIGHT JOIN paciente paciente ON pessoa.id = paciente.ref_pessoa;