-- INSERT DATA
--

-- Médicos
INSERT INTO pessoa (nome, cpf, telefone, email, data_cadastro)
            VALUES (
                    'Dummy Doctor',
                    '12345678910',
                    '51987654321',
                    'dummy.doctor@email.com',
                    '2020-09-06 15:00:00'
                    );

INSERT INTO medico (ref_pessoa, codigo_crm)
			VALUES ((select id from pessoa where cpf = '12345678910'),
					'xxxxx');         

-- Pacientes
INSERT INTO pessoa (nome, cpf, telefone, email, data_cadastro)
              VALUES (
                      'Dummy Patient',
                      '98765432100',
                      '51987654321',
                      'dummy.patient@email.com',
                      '2020-09-07 15:00:00'
                     );

INSERT INTO paciente (ref_pessoa)
            VALUES (
                    (select id from pessoa where cpf = '98765432100')
                   );                      

-- Situações
INSERT INTO situacao_consulta (nome, descricao) 
                       VALUES (
                               'Agendado',
                               'Paciente agendou consulta'    
                              );

INSERT INTO situacao_consulta (nome, descricao) 
                       VALUES (
                               'Cancelado',
                               'Paciente cancelou a consulta'    
                              );

INSERT INTO situacao_consulta (nome, descricao) 
                       VALUES (
                               'Encerrado',
                               'Paciente terminou a consulta'    
                              );                                                                 

-- Consultas
INSERT INTO consulta (
                      hora_inicio,
                      hora_fim,
                      diagnostico,
                      receita,
                      ref_paciente,
                      ref_medico,
                      ref_situacao_consulta
                     )
              VALUES (
                      '2021-09-30 17:00:00',
                      '2021-09-30 18:00:00',
                      'dianostico_texto',
                      'receita_texto',
                      (select id from pessoa where cpf = '98765432100'), -- 'Dummmy Patient'
                      (select id from pessoa where cpf = '12345678910'), -- 'Dummy Doctor'
                      (select id from situacao_consulta where nome = 'Agendado')
                     );
