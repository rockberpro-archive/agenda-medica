<?php

require_once "../database/MedicoDB.php";
require_once "../model/Pessoa.php";
require_once "../model/Medico.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['acao']) && isset(($_GET['id'])) && $_GET['acao'] == 'delete') {
    MedicoDB::removeMedicoById(($_GET['id']));
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>HOSPITALLICVS: médicos</title>
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
                <h1>Médicos</h1>
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
                    <select class="form-control" id="medico-option-filter">
                        <!-- <option >.:: Filtro ::.</option> -->
                        <option>ID</option>
                        <option selected>Nome</option>
                        <option>CPF</option>
                        <option>CRM</option>
                        <option>Telefone</option>
                        <option>E-mail</option>
                        <option>Data Cadastro</option>
                    </select>
                </div>
                <div class="col-2">
                    <input class="input-group-text" type="text" id="input-busca-medico" onkeyup="onSearchTable()" placeholder="Buscar...">
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
                <table class="table table-responsive table-bordered" id="tabela-medico">
                    <?php
                    $medicos = MedicoDB::findAllMedicos();

                    $tabela = "<thead>";
                    $tabela .= "<tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>CPF</td>
                            <td>CRM</td>		
                            <td>Telefone</td>
                            <td>E-mail</td>
                            <td>Data Cadastro</td>
                            <td>Editar</td><td>Remover</td>                
                        </tr>";
                    $tabela .= "</thead><tbody>";
                    foreach ($medicos as $medico) {

                        $id = $medico->id;
                        $dataCadastro = Date('d/m/Y', strtotime($medico->data_cadastro));

                        $tabela .= "
                            <tr id = '{$id}'>
                                <td>{$medico->ref_pessoa}</td>
                                <td>{$medico->nome}</td>
                                <td>{$medico->cpf}</td>
                                <td>{$medico->codigo_crm}</td>
                                <td>{$medico->telefone}</td>
                                <td>{$medico->email}</td>
                                <td>{$dataCadastro}</td>
                                <td>
                                    <button type=\"button\" class=\"btn btn-warning\"  onclick=\"location.href='medico_cadastro.php?acao=edit&id={$id}'\">
                                        <i class=\"fas fa-pen\"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type=\"button\" class=\"btn btn-danger\"  onclick=\"location.href='medico.php?acao=delete&id={$id}'\">
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
                <button type="button" class="btn btn-primary" onclick="location.href='./medico_cadastro.php'">
                    <i class="fas fa-user"></i>
                    Cadastrar médico
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