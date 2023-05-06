-- CREATE TABLES
--

CREATE TABLE pessoa (
    id SERIAL NOT NULL PRIMARY KEY,
    nome TEXT NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    telefone TEXT NOT NULL,
    email TEXT,
    data_cadastro TIMESTAMP NOT NULL
);


CREATE TABLE medico (
    ref_pessoa INT NOT NULL PRIMARY KEY REFERENCES pessoa(id),
    codigo_crm TEXT NOT NULL
);

CREATE TABLE paciente (
    ref_pessoa INT NOT NULL PRIMARY KEY REFERENCES pessoa(id)
);

CREATE TABLE situacao_consulta (
    id SERIAL NOT NULL PRIMARY KEY,
    nome TEXT NOT NULL,
    descricao TEXT
);

CREATE TABLE consulta (
    id SERIAL NOT NULL PRIMARY KEY,
    hora_inicio TIMESTAMP,
    hora_fim TIMESTAMP,
    diagnostico TEXT,
    receita TEXT,
    ref_paciente INT NOT NULL REFERENCES paciente(ref_pessoa),
    ref_medico INT NOT NULL REFERENCES medico(ref_pessoa),
    ref_situacao_consulta INT NOT NULL REFERENCES situacao_consulta(id)
);
