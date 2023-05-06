<?php

// require_once "../database/PacienteDB.php";
// require_once "../database/MedicoDB.php";
// require_once "../database/ConsultaDB.php";
// require_once "../database/SituacaoConsultaDB.php";
require_once "../model/Pessoa.php";
require_once "../model/Paciente.php";
require_once "../model/Medico.php";
require_once "../model/SituacaoConsulta.php";

class Consulta
{

    public $id;
    public $hora_inicio;
    public $hora_fim;
    public $diagnostico;
    public $receita;
    public $ref_paciente;
    public $ref_medico;
    public $ref_situacao_consulta;

    public function __construct() {}

    public function __destruct()
    {
        foreach ($this as $key => $row) {
            unset($row);
        }
    }
}
