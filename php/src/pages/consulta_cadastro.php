<?php

require_once "../database/SituacaoConsultaDB.php";
require_once "../database/ConsultaDB.php";
require_once "../database/PacienteDB.php";
require_once "../database/MedicoDB.php";
require_once "../model/Consulta.php";
require_once "../model/SituacaoConsulta.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['consultaParaEditar'])) {
        ConsultaDB::updateConsulta($_POST);
    } else {
        ConsultaDB::registerConsulta($_POST);
    }
    echo "<script> location.href='consulta.php' </script>";
}

/* fixa variável na sessão para ser mantida após o refresh() */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['acao']) && $_GET['acao'] == 'edit') {
    $_SESSION['consultaParaEditar'] = encontrarConsultaParaEditar($_GET['id']);
}

/* limpa sessão para não atrapalhar em novos cadastros */
if (!isset($_GET['acao'])) {
    $_SESSION['consultaParaEditar'] = null;
}

function encontrarConsultaParaEditar(string $id): Object
{
    if (isset($id)) {
        return ConsultaDB::findConsultaById($id)[0];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>HOSPITALLICVS: cadastro</title>
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
        <div class="row">
            <div class="col" align="center">
                <h1>Cadastro Consultas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col" id="button-home">
                <button type="button" class="btn btn-secondary" onclick="location.href='consulta.php'">
                    <i class="fas fa-arrow-left"></i>
                    Listagem
                </button>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="form-group">
                <form method="post" action="consulta_cadastro.php" style="padding-left:1%">
                    <div class="row">
                        <div class="col col-md-1">
                            <label for="id_consulta"">ID</label><br />
                            <input class="form-control" readonly hiden type="text" id="id_consulta" name="id_consulta" value="<?= isset($_SESSION['consultaParaEditar']->id) ? $_SESSION['consultaParaEditar']->id : '' ?>" /><br /><br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-2">
                            <label for="hora_inicio">Hora Início:</label><br />
                            <input class="form-control" type="datetime-local" id="hora_inicio" name="hora_inicio" value="<?= isset($_SESSION['consultaParaEditar']) ? Date('Y-m-d\TH:i', strtotime($_SESSION['consultaParaEditar']->hora_inicio)) : '' ?>" required><br /><br />
                        </div>
                        <div class="col col-md-2">
                            <label for="hora_fim">Hora Fim:</label><br />
                            <input class="form-control" type="datetime-local" id="hora_fim" name="hora_fim" value="<?= isset($_SESSION['consultaParaEditar']) ? Date('Y-m-d\TH:i', strtotime($_SESSION['consultaParaEditar']->hora_fim)) : '' ?>" required /><br /><br />
                        </div>
                    </div>
                    <div class="row" id="row_diagnostico_receita">
                        <div class="col-md-4">
                            <label for="diagnostico" id="label_didagnostico">Diagnóstico:</label><br />
                            <textarea class="form-control" id="diagnostico" name="diagnostico"><?= isset($_SESSION['consultaParaEditar']->diagnostico) ? $_SESSION['consultaParaEditar']->diagnostico : '' ?></textarea><br /><br />
                        </div>
                        <div class="col-md-4">
                            <label for="receita" id="label_receita">Receita:</label><br />
                            <textarea class="form-control" id="receita" name="receita"><?= isset($_SESSION['consultaParaEditar']->receita) ? $_SESSION['consultaParaEditar']->receita : '' ?></textarea><br /><br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="ref_paciente">Paciente:</label><br />
                            <select class="form-control" name="ref_paciente" id="ref_paciente" required>
                                <option>-- Pacientes cadastrados --</option>
                                <?php
                                $pacientes = PacienteDB::findAllPacientes();

                                foreach ($pacientes as $paciente) {

                                    $value = "{$paciente->id}";
                                    $id = "{$paciente->id}-paciente";

                                    // $_SESSION['consultaParaEditar'] só está definido quando acionado o botão "Editar"
                                    if (
                                        isset($_SESSION['consultaParaEditar'])
                                        && ($_SESSION['consultaParaEditar']->ref_paciente == $paciente->id)
                                    ) {
                                        echo "<option selected id='{$id}' value='{$value}'>{$paciente->nome}</option>";
                                    } else {
                                        echo "<option id='{$id}' value='{$value}'>{$paciente->nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <br /><br /> -->
                        <div class="col-2">
                            <label for="ref_medico">Médico:</label><br />
                            <select class="form-control" name="ref_medico" id="ref_medico" required>
                                <option>-- Médicos cadastrados --</option>
                                <?php
                                $medicos = MedicoDB::findAllMedicos();

                                foreach ($medicos as $medico) {

                                    $value = "{$medico->id}";
                                    $id = "{$medico->id}-medico";

                                    // $_SESSION['consultaParaEditar'] só está definido quando acionado o botão "Editar"
                                    if (
                                        isset($_SESSION['consultaParaEditar'])
                                        && ($_SESSION['consultaParaEditar']->ref_medico == $medico->id)
                                    ) {
                                        echo "<option selected id='{$id}' value='{$value}'>{$medico->nome}</option>";
                                    } else {
                                        echo "<option id='{$id}' value='{$value}'>{$medico->nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <br /><br /> -->
                        <div class="col-2">
                            <label for="ref_situacao_consulta">Situação:</label><br />
                            <select class="form-control" name="ref_situacao_consulta" id="ref_situacao_consulta" required>
                                <option>-- Situação da Consulta --</option>
                                <?php
                                $situacoes = SituacaoConsultaDB::findAllSituacaoConsulta();

                                foreach ($situacoes as $situacao) {

                                    $value = "{$situacao->id}";
                                    $id = "{$situacao->id}-situacao";

                                    // $_SESSION['consultaParaEditar'] só está definido quando acionado o botão "Editar"
                                    if (
                                        isset($_SESSION['consultaParaEditar'])
                                        && ($_SESSION['consultaParaEditar']->ref_situacao_consulta == $situacao->id)
                                    ) {
                                        echo "<option selected id='{$id}' value='{$value}'>{$situacao->nome}</option>";
                                    } else {
                                        echo "<option id='{$id}' value='{$value}'>{$situacao->nome}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- <br /><br /> -->
                    <div class="row" style="padding-bottom: 4%;"></div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                <?= isset($_SESSION['consultaParaEditar']) ? 'Atualizar' : 'Cadastrar' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../lib/jquery/jquery-3.6.0.min.js"></script>
    <script src="../lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
    <script src="../lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>

    <script>
        var isModeEdit = <?= ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['acao']) && $_GET['acao'] == 'edit') ? 1 : 0 ?>

        window.onload = function() {
            let row_diagnostico_receita = document.getElementById('row_diagnostico_receita');
            let label_diagnostico = document.getElementById('label_didagnostico');
            let label_receita = document.getElementById('label_receita');
            let input_diagnostico = document.getElementById('diagnostico');
            let input_receita = document.getElementById('receita');

            if (!isModeEdit) {
                row_diagnostico_receita.hidden = 'true';
                label_diagnostico.hidden = 'true';
                label_receita.hidden = 'true';
                input_diagnostico.hidden = 'true';
                input_receita.hidden = 'true';
            }
        }
    </script>
</body>

</html>