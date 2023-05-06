SELECT *
FROM medico medico
    LEFT JOIN pessoa pessoa ON pessoa.id = medico.ref_pessoa;

SELECT *
FROM pessoa pessoa
    RIGHT JOIN medico medico ON pessoa.id = medico.ref_pessoa;

SELECT COUNT(*)
FROM consulta WHERE ref_medico = :id;
