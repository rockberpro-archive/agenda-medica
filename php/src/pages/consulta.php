<?php

require_once "../database/PacienteDB.php";
require_once "../database/MedicoDB.php";
require_once "../database/ConsultaDB.php";
require_once "../database/SituacaoConsultaDB.php";
require_once "../model/Consulta.php";

if (isset($_GET['acao']) && $_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['acao'] == 'delete')
{
    removerConsulta($_GET['id']);
}

function removerConsulta(string $id)
{
    if (isset($id))
    {
        ConsultaDB::removeConsultaById($id);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>HOSPITALLICVS: consultas</title>
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/brands.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/solid.min.css">
    <link rel="stylesheet" href="../lib/bootstrap-5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/bootstrap-5.1.1/css/bootstrap-grid.min.css">
    <style type="text/css">
        h1 {
            font-weight: bold;
        }

        .table thead {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <br />
    <div class="container-fluid">
        <div class="row" style="padding-bottom: 1%;">
            <div class="col col-md-5">
                <a href="../index.php">
                    <img src="../img/logo/logo4.png" type="img/png"></img>
                </a>
            </div>
            <div class="col">
                <h1>Consultas</h1>
            </div>
        </div>
        <div class="form-group">
            <div class="row" style="padding-bottom:1%;"></div>
            <div class="row">
                <div class="col-6" id="button-home">
                    <button type="button" class="btn btn-secondary" onclick="location.href='../index.php'">
                        <i class="fas fa-arrow-left"></i>
                        Voltar
                    </button>
                </div>
                <div class="col-2">
                    <!-- Filtro de busca -->
                    <select class="form-control" id="consulta-option-filter">
                        <!-- <option >.:: Filtro ::.</option> -->
                        <option>ID</option>
                        <option selected>Data</option>
                        <option>Hora Início</option>
                        <option>Hora Fim</option>
                        <option>Diagnostico</option>
                        <option>Receita</option>
                        <option>Paciente</option>
                        <option>Médico</option>
                        <option>Situacao Consulta</option>
                    </select>
                </div>
                <div class="col-2">
                    <input type="text" id="input-busca-consulta" class="input-group-text" onkeyup="onSearchTable()" placeholder="Buscar...">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-success" id="botao-limpar" onclick="clearInputField()">
                        <i class="fas fa-broom"></i>
                        Limpar
                    </button>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 2%;"></div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <table class="table table-responsive table-bordered" id="tabela-consulta">
                    <?php
                    $consultas = ConsultaDB::findAllConsultas();

                    $tabela = "<thead>";
                    $tabela .= "
                <tr>
                    <td>ID</td>
                    <td>Data</td>
                    <td>Hora Início</td>
                    <td>Hora Fim</td>		
                    <td>Diagnostico</td>
                    <td>Receita</td>
                    <td>Paciente</td>
                    <td>Médico</td>
                    <td>Situacao Consulta</td>
                    <td>Editar</td><td>Remover</td>
                </tr> ";

                    $tabela .= "</thead><tbody>";
                    foreach ($consultas as $consulta)
                    {

                        $id = $consulta->id;
                        $paciente =  PacienteDB::findPacienteById($consulta->ref_paciente);
                        $medico = MedicoDB::findMedicoById($consulta->ref_medico);
                        $situacao = SituacaoConsultaDB::findSituacaoConsultaById($consulta->ref_situacao_consulta);

                        $dataConsulta = Date('d/m/Y', strtotime($consulta->hora_inicio));
                        $horaInicioConsulta = Date('h:i', strtotime($consulta->hora_inicio));
                        $horaFimConsulta = Date('h:i', strtotime($consulta->hora_fim));

                        $tabela .= "
                        <tr id = '{$id}'>
                            <td>{$consulta->id}</td>
                            <td>{$dataConsulta}</td>
                            <td>{$horaInicioConsulta}</td>
                            <td>{$horaFimConsulta}</td>
                            <td>{$consulta->diagnostico}</td>
                            <td>{$consulta->receita}</td>
                            <td>{$paciente[0]->nome}</td>
                            <td>{$medico[0]->nome}</td>
                            <td>{$situacao[0]->nome}</td>
                            <td>
                            <button type=\"button\" class=\"btn btn-warning\"  onclick=\"location.href='consulta_cadastro.php?acao=edit&id={$id}'\">
                                <i class=\"fas fa-pen\"></i>
                            </button>
                        </td>
                        <td>
                            <button type=\"button\" class=\"btn btn-danger\"  onclick=\"location.href='consulta.php?acao=delete&id={$id}'\">
                                <i class=\"fas fa-trash-alt\"></i>
                            </button>
                        </td>
                        </tr>";
                    }
                    $tabela .= "</tbody>";

                    echo $tabela;
                    ?>
                </table>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row">
            <div class="row" style="padding-bottom: 1%;"></div>
            <div class="col">
                <button type="button" class="btn btn-primary" onclick="location.href='./consulta_cadastro.php'">
                    <i class="fas fa-user"></i>
                    Cadastrar consulta
                </button>
            </div>
        </div>
    </div>

    <script src="../lib/jquery/jquery-3.6.0.min.js"></script>
    <script src="../lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
    <script src="../lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
    <script src="../js/funcoes.js"></script>
</body>

</html>