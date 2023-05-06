<?php

require_once "../database/PacienteDB.php";
require_once "../model/Pessoa.php";
require_once "../model/Paciente.php";

if (isset($_GET['acao']) && $_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['id'] && $_GET['acao'] == 'delete') {
    PacienteDB::removePacienteById($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/brands.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/solid.min.css">
    <link rel="stylesheet" href="../lib/bootstrap-5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/bootstrap-5.1.1/css/bootstrap-grid.min.css">
    <title>HOSPITALLICVS: pacientes</title>
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
                <h1>Pacientes</h1>
            </div>
        </div>
        <div class="row" style="padding-bottom:1%;"></div>
        <div class="form-group">
            <div class="row">
                <div class="col-6" id="button-home">
                    <button type="button" class="btn btn-secondary" onclick="location.href='../index.php'">
                        <i class="fas fa-arrow-left"></i>
                        Voltar
                    </button>
                </div>
                <div class="col-2">
                    <!-- Filtro de busca -->
                    <select class="form-control" id="paciente-option-filter">
                        <!-- <option >.:: Filtro ::.</option> -->
                        <option>ID</option>
                        <option selected>Nome</option>
                        <option>CPF</option>
                        <option>Telefone</option>
                        <option>E-mail</option>
                        <option>Data Cadastro</option>
                    </select>
                </div>
                <div class="col-2">
                    <input type="text" id="input-busca-paciente" class="input-group-text" onkeyup="onSearchTable()" placeholder="Buscar...">
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
                <table class="table table-responsive table-bordered" id="tabela-paciente">
                    <?php
                    $pacientes = PacienteDB::findAllPacientes();

                    $tabela = "<thead>";
                    $tabela .= "
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>CPF</td>		
                            <td>Telefone</td>
                            <td>E-mail</td>
                            <td>Data Cadastro</td>
                            <td>Editar</td><td>Remover</td>                
                        </tr> ";
                    $tabela .= "</thead><tbody>";
                    foreach ($pacientes as $paciente) {

                        $id = $paciente->id;
                        $dataCadastro = Date('d/m/Y', strtotime($paciente->data_cadastro));

                        $tabela .= "
                            <tr id = '{$id}'>
                                <td>{$paciente->ref_pessoa}</td>
                                <td>{$paciente->nome}</td>
                                <td>{$paciente->cpf}</td>
                                <td>{$paciente->telefone}</td>
                                <td>{$paciente->email}</td>
                                <td>{$dataCadastro}</td>
                                <td>
                                    <button type=\"button\" class=\"btn btn-warning\"  onclick=\"location.href='paciente_cadastro.php?acao=edit&id={$id}'\">
                                        <i class=\"fas fa-pen\"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type=\"button\" class=\"btn btn-danger\"  onclick=\"location.href='paciente.php?acao=delete&id={$id}'\">
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
        </div>
        <div class="row">
            <div class="row" style="padding-bottom: 1%;"></div>
            <div class="col">
                <button type="button" class="btn btn-primary" onclick="location.href='./paciente_cadastro.php'">
                    <i class="fas fa-user"></i>
                    Cadastrar paciente
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