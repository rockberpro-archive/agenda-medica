-- SELECT DATA

SELECT *
FROM paciente paciente
	INNER JOIN pessoa pessoa
		ON paciente.ref_pessoa = pessoa.id
;		

SELECT *
FROM medico medico
	INNER JOIN pessoa pessoa 
		ON medico.ref_pessoa = pessoa.id
;